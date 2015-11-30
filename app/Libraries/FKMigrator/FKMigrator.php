<?php

namespace App\Libraries\FKMigrator;

use Schema;
use DB;

class FKMigrator
{

    protected $filePath = 'database/relationships.json';

    protected $relationships = [];

    protected function getFkeys($tableName)
    {
        $fkeys =  DB::connection()
            ->getDoctrineSchemaManager()
            ->listTableForeignKeys($tableName);
        return array_map(function($current){
                return $current->getName();
            }, $fkeys);
    }

    public function up()
    {
        foreach ($this->relationships as $tableName => $definitions) {
            $fkeys = $this->getFkeys($tableName);
            foreach ($definitions['relationships'] as $params) {
                if(
                    Schema::hasTable($params[2])
                    && in_array($params[0], ['belongsTo', 'hasOne']) 
                    && !in_array("{$tableName}_{$params[3]}_foreign", $fkeys)
                ) {
                    Schema::table($tableName, function($table) use ($params) {
                        $table->foreign($params[3])
                            ->references('id')
                            ->on($params[2])
                            ->onDelete('cascade');
                    });
                }
            }
        }
    }

    public function down()
    {
        foreach ($this->relationships as $tableName => $definitions) {
            $fkeys = $this->getFkeys($tableName);
            foreach ($definitions['relationships'] as $params) {
                $keyName = "{$tableName}_{$params[3]}_foreign";
                if(in_array($params[0], ['belongsTo', 'hasOne']) && in_array($keyName, $fkeys)) {
                    Schema::table($tableName, function($table) use ($keyName) {
                        $table->dropForeign($keyName);
                    });
                }
            }
        }
    }

    public function create($table, $configs)
    {
        $this->relationships[$table] = $configs;
        $this->saveRelationships();
    }

    public function remove($table)
    {
        if(isset($this->relationships[$table])) {
            $this->down();
            unset($this->relationships[$table]);
            $this->saveRelationships();
            $this->up();
        }
    }

    protected function saveRelationships()
    {
        file_put_contents(base_path($this->filePath), json_encode((object) $this->relationships));
    }

    protected function loadRelationships()
    {
        $this->relationships = json_decode(file_get_contents(base_path($this->filePath)), true);
    }

    public function __construct()
    {
        $this->loadRelationships();
    }

}