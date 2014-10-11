<?php

class TestSeeder extends Seeder {

    public $tables = [];

    private function seedTestDB()
    {
        Artisan::call('db:seed', ['--database' => 'sqlite']);
    }

    private function createTablesInTestDB()
    {
        foreach ($this->tables as $tableName => $columns) {
            Schema::connection('sqlite')->create($tableName, function ($table) use ($columns) {
                $timestamps = false;
                foreach ($columns as $column) {
                    if($column['inc']) {
                        $table->increments('id')->unsigned();
                    } else if (in_array($column['name'], ['created_at', 'updated_at']) && !$timestamps) {
                        $timestamps = true;
                        $table->timestamp('created_at')->nullable();
                        $table->timestamp('updated_at')->nullable();
                    } else {
                        switch ($column['type']) {
                            case 'int':
                                $table->integer($column['name'])
                                    ->nullable()
                                    ->default($column['default']);
                                break;
                            case 'varchar':
                                $table->string($column['name'])
                                    ->nullable()
                                    ->default($column['default']);
                                break;
                            default:
                                break;
                        }
                    }
                }
            });
        }
    }

    private function cleanupType($type)
    {
        $mapped = '';

        $type = str_replace([' unsigned'], '', $type);
        $type = str_replace(['tinyint'], 'int', $type);
        $type = str_replace(['tinyint'], 'int', $type);
        $type = preg_replace('/\([0-9]+\)/', '', $type);

        return $type;
    }

    public function getCurrentSchema()
    {
        foreach (DB::connection('mysql')->select('show tables') as $table) {
            $table = (array) $table;
            $tableName = array_pop($table);
            $this->tables[$tableName] = [];
            foreach (DB::connection('mysql')->select("describe $tableName") as $column) {
                $columnData = [
                    'name'    => $column->Field,
                    'type'    => $this->cleanupType($column->Type),
                    'inc'     => $column->Extra === 'auto_increment' ? true : false,
                    'default' => $column->Default,
                    'is_null' => $column->Null === 'NO' ? false : true,
                ];
                $this->tables[$tableName][] = $columnData;
            }
        }
    }

    public function truncateTestDB()
    {
        unlink(app_path() . '/database/dev.sqlite');
        file_put_contents(app_path() . '/database/dev.sqlite', '');
    }

    public function run() {
        $this->truncateTestDB();
        $this->getCurrentSchema();
        $this->createTablesInTestDB();
        $this->seedTestDB();
    }

}
