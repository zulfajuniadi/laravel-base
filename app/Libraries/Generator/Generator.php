<?php

namespace App\Libraries\Generator;

use Illuminate\Foundation\Composer;
use DiffMatchPatch\DiffMatchPatch;
use Illuminate\Support\Str;

class Generator
{
    protected $nesting = false;
    protected $relationships;
    protected $params = [];
    protected $tableName;
    protected $patcher;
    protected $fields;
    protected $fs;

    protected function substitute($source)
    {
        foreach ($this->params as $key => $value) {
            $source = str_replace($key, $value, $source);
        }
        return $source;
    }

    protected function makeBaseParams()
    {
        $this->params['model_names'] = $this->tableName;
        $this->params['model-names'] = str_replace('_', '-', $this->params['model_names']);
        $this->params['model names'] = str_replace('_', ' ', $this->params['model_names']);
        $this->params['Model Names'] = Str::title($this->params['model names']);
        $this->params['ModelNames']  = str_replace(' ', '', $this->params['Model Names']);
        $this->params['modelNames']  = lcfirst($this->params['ModelNames']);
        $this->params['model_name'] = Str::singular($this->tableName);
        $this->params['model-name'] = str_replace('_', '-', $this->params['model_name']);
        $this->params['model name'] = str_replace('_', ' ', $this->params['model_name']);
        $this->params['Model Name'] = Str::title($this->params['model name']);
        $this->params['ModelName']  = str_replace(' ', '', $this->params['Model Name']);
        $this->params['modelName']  = lcfirst($this->params['ModelName']);
        if($this->nesting) {
            $this->params['ParentName'] = $this->nesting[0];
            $this->params['parentName'] = lcfirst($this->params['ParentName']);
            $this->params['parent_id'] = $this->nesting[1];
            $this->params['parent-names'] = $this->nesting[2];
            $this->params['parent_names'] = str_replace('-', '_', $this->params['parent-names']);
            $this->params['Parent Names'] = ucwords(str_replace('-', ' ', $this->params['parent-names']));
        }
    }

    protected function create()
    {
        $timestamp = date('Y') . '_' . date('m') . '_' . date('d') . '_' .date('His');

        // Find existing migration and get its timestamp
        foreach ($this->fs->files(base_path('database/migrations')) as $file) {
            $file = basename($file);
            if(stristr($file, $this->params['ModelNames'] . 'Migration.php'))
                $timestamp = substr($file, 0, 17);
        }

        $templatePrefix = 'singular';
        if($this->nesting) {
            $templatePrefix = 'nesting';
        }
        $templates = [
            "{$templatePrefix}/views/create.php"    => base_path("resources/views/{$this->params['model-names']}/create.blade.php"),
            "{$templatePrefix}/views/edit.php"      => base_path("resources/views/{$this->params['model-names']}/edit.blade.php"),
            "{$templatePrefix}/views/form.php"      => base_path("resources/views/{$this->params['model-names']}/form.blade.php"),
            "{$templatePrefix}/views/index.php"     => base_path("resources/views/{$this->params['model-names']}/index.blade.php"),
            "{$templatePrefix}/views/revisions.php" => base_path("resources/views/{$this->params['model-names']}/revisions.blade.php"),
            "{$templatePrefix}/views/show.php"      => base_path("resources/views/{$this->params['model-names']}/show.blade.php"),
            "{$templatePrefix}/controller.php"      => base_path("app/Http/Controllers/{$this->params['ModelNames']}Controller.php"),
            "{$templatePrefix}/menus.php"           => base_path("app/Menus/{$this->params['ModelNames']}Menu.php"),
            "{$templatePrefix}/model.php"           => base_path("app/{$this->params['ModelName']}.php"),
            "{$templatePrefix}/policy.php"          => base_path("app/Policies/{$this->params['ModelNames']}Policy.php"),
            "{$templatePrefix}/provider.php"        => base_path("app/Providers/Modules/{$this->params['ModelNames']}Provider.php"),
            'repository.php'                        => base_path("app/Repositories/{$this->params['ModelNames']}Repository.php"),
            'validation.php'                        => base_path("app/Validators/{$this->params['ModelNames']}Validators.php"),
            'seeds.php'                             => base_path("database/seeds/{$this->params['ModelNames']}Seeder.php"),
            'migrations.php'                        => base_path("database/migrations/{$timestamp}_{$this->params['ModelNames']}Migration.php"),
        ];
        foreach ($this->fs->files(app_path('Libraries/Generator/stubs/langs')) as $value) {
            $value = 'langs/' . basename($value);
            $lang = substr($value, 6, -4);
            $templates[$value] = base_path("resources/lang/{$lang}/{$this->params['model-names']}.php");
        }
        if($this->isJuctionTable)
            $templates = ['migrations-junction-table.php' => $templates['migrations.php']];
        foreach ($templates as $source => $destination) {
            $content = $this->substitute(file_get_contents(base_path('app/Libraries/Generator/stubs/') . $source));
            if(!is_dir($basePath = dirname($destination))) {
                $this->fs->makeDirectory($basePath, 0755, true);
            }
            if(file_exists($destination) && ($originalContents = file_get_contents($destination)) != $content) {
                $parts = explode('/', $destination);
                $fileName = array_pop($parts);
                $parts[] = '_' . $fileName;
                $renameTo = implode('/', $parts);
                if(file_exists($renameTo))
                    unlink($renameTo);
                $this->fs->move($destination, $renameTo);
                $patch = $this->patcher->patch_make($originalContents, $content);
                $content = $this->patcher->patch_apply($patch, $originalContents)[0];
            }
            file_put_contents($destination, $content);
        }
    }

    protected function remove()
    {
        $templates = [
            base_path("resources/views/{$this->params['model-names']}/create.blade.php"),
            base_path("resources/views/{$this->params['model-names']}/edit.blade.php"),
            base_path("resources/views/{$this->params['model-names']}/form.blade.php"),
            base_path("resources/views/{$this->params['model-names']}/index.blade.php"),
            base_path("resources/views/{$this->params['model-names']}/revisions.blade.php"),
            base_path("resources/views/{$this->params['model-names']}/show.blade.php"),
            base_path("app/Http/Controllers/{$this->params['ModelNames']}Controller.php"),
            base_path("app/Menus/{$this->params['ModelNames']}Menu.php"),
            base_path("app/{$this->params['ModelName']}.php"),
            base_path("app/Policies/{$this->params['ModelNames']}Policy.php"),
            base_path("app/Providers/Modules/{$this->params['ModelNames']}Provider.php"),
            base_path("app/Repositories/{$this->params['ModelNames']}Repository.php"),
            base_path("database/seeds/{$this->params['ModelNames']}Seeder.php"),
            base_path("app/Validators/{$this->params['ModelNames']}Validators.php"),
            base_path("resources/views/_{$this->params['model-names']}/create.blade.php"),
            base_path("resources/views/_{$this->params['model-names']}/edit.blade.php"),
            base_path("resources/views/_{$this->params['model-names']}/form.blade.php"),
            base_path("resources/views/_{$this->params['model-names']}/index.blade.php"),
            base_path("resources/views/_{$this->params['model-names']}/revisions.blade.php"),
            base_path("resources/views/_{$this->params['model-names']}/show.blade.php"),
            base_path("app/Http/Controllers/_{$this->params['ModelNames']}Controller.php"),
            base_path("app/Menus/_{$this->params['ModelNames']}Menu.php"),
            base_path("app/_{$this->params['ModelName']}.php"),
            base_path("app/Policies/_{$this->params['ModelNames']}Policy.php"),
            base_path("app/Providers/Modules/_{$this->params['ModelNames']}Provider.php"),
            base_path("app/Repositories/_{$this->params['ModelNames']}Repository.php"),
            base_path("database/seeds/_{$this->params['ModelNames']}Seeder.php"),
            base_path("app/Validators/_{$this->params['ModelNames']}Validators.php"),
        ];
        foreach ($this->fs->files(app_path('Libraries/Generator/stubs/langs')) as $value) {
            $value = basename($value);
            $lang = substr($value, 0, -4);
            $templates[] = base_path("resources/lang/{$lang}/{$this->params['model-names']}.php");
        }
        if(!$this->isJuctionTable) {
            foreach ($templates as $source) {
                if(file_exists($source))
                    unlink($source);
            }
            $this->fs->deleteDirectory(base_path("resources/views/{$this->params['model-names']}"));
        }
        foreach ($this->fs->files(base_path('database/migrations')) as $file) {
            if(stristr($file, $this->params['ModelNames'] . 'Migration.php')) {
                unlink($file);
            }
        }
    }

    protected function makeFieldsParams()
    {
        $this->params = $this->params + [
            'FORMFIELDS' => app('laravel-base-generator.form')->make($this->fields, $this->params, $this->relationships),
            'SHOWFIELDS' => app('laravel-base-generator.show')->make($this->fields, $this->params, $this->relationships),
            'REVISIONABLENAME' => app('laravel-base-generator.revisionablename')->make($this->fields, $this->params, $this->relationships),
            'REVISIONABLEVALUE' => app('laravel-base-generator.revisionablevalue')->make($this->fields, $this->params, $this->relationships),
            'LANGENFIELDS' => app('laravel-base-generator.lang')->make($this->fields, $this->params, $this->relationships),
            'INDEXCOLUMNS' => app('laravel-base-generator.index')->make($this->fields, $this->params, $this->relationships),
            'MIGRATIONFIELDS' => app('laravel-base-generator.migration')->make($this->fields, $this->params, $this->relationships),
            'FILLABLECOLUMN' => app('laravel-base-generator.fillable')->make($this->fields, $this->params, $this->relationships),
            'FKMODELMETHODS' => app('laravel-base-generator.modelfkmethods')->make($this->fields, $this->params, $this->relationships),
            'VALIDATIONS' => app('laravel-base-generator.validation')->make($this->fields, $this->params, $this->relationships),
        ];
    }

    public function dumpAutoload()
    {
        (new Composer($this->fs))->dumpAutoloads();
    }

    public function make($tableName, $fields = [], $relationships = [], $isJuctionTable = false, $nesting = false)
    {
        $this->patcher = new DiffMatchPatch();
        $this->isJuctionTable = $isJuctionTable;
        $this->tableName = $tableName;
        $this->fs = app('files');
        $this->fields = $fields;
        $this->nesting = $nesting;
        $this->relationships = $relationships;
        $this->makeBaseParams();
        $this->makeFieldsParams();
        $this->create();
        $this->dumpAutoload();
        if(count($this->relationships) > 0) {
            app('fkmigrator')->create($this->tableName, [
                'params' => $this->params,
                'relationships' => $this->relationships
            ]);
        }
    }

    public function erase($tableName, $isJuctionTable = false)
    {
        $this->isJuctionTable = $isJuctionTable;
        $this->tableName = $tableName;
        $this->fs = app('files');
        $this->makeBaseParams();
        app('fkmigrator')->remove($this->tableName);
        // run down migrations
        foreach ($this->fs->files(base_path('database/migrations')) as $file) {
            if(stristr($file, $this->params['ModelNames'] . 'Migration.php')) {
                $fileName = substr(basename($file), 0, -4);
                $record = app('db')
                    ->table('migrations')
                    ->where('migration', $fileName)
                    ->first();
                if($record)
                    app('db')
                        ->table('migrations')
                        ->where('migration', $fileName)
                        ->take(1)
                        ->delete();
                app($this->params['ModelNames'] . 'Migration')->down();
            }
        }
        $this->remove();
        $this->dumpAutoload();

    }
}
