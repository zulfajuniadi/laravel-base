<?php

namespace App\Libraries\Generator;

use Illuminate\Support\Str;

class Generator
{
    protected $params = [];
    protected $relationships;
    protected $tableName;
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

        $templates = [
            'views/create.php'    => base_path("resources/views/{$this->params['model-names']}/create.blade.php"),
            'views/edit.php'      => base_path("resources/views/{$this->params['model-names']}/edit.blade.php"),
            'views/form.php'      => base_path("resources/views/{$this->params['model-names']}/form.blade.php"),
            'views/index.php'     => base_path("resources/views/{$this->params['model-names']}/index.blade.php"),
            'views/revisions.php' => base_path("resources/views/{$this->params['model-names']}/revisions.blade.php"),
            'views/show.php'      => base_path("resources/views/{$this->params['model-names']}/show.blade.php"),
            'controller.php'      => base_path("app/Http/Controllers/{$this->params['ModelNames']}Controller.php"),
            'menus.php'           => base_path("app/Menus/{$this->params['ModelNames']}Menu.php"),
            'policy.php'          => base_path("app/Policies/{$this->params['ModelNames']}Policy.php"),
            'provider.php'        => base_path("app/Providers/Modules/{$this->params['ModelNames']}Provider.php"),
            'repository.php'      => base_path("app/Repositories/{$this->params['ModelNames']}Repository.php"),
            'validation.php'      => base_path("app/Validators/{$this->params['ModelNames']}Validators.php"),
            'seeds.php'           => base_path("database/seeds/{$this->params['ModelNames']}Seeder.php"),
            'migrations.php'      => base_path("database/migrations/{$timestamp}_{$this->params['ModelNames']}Migration.php"),
            'model.php'           => base_path("app/{$this->params['ModelName']}.php"),
        ];
        foreach ($this->fs->files(app_path('Libraries/Generator/stubs/langs')) as $value) {
            $value = 'langs/' . basename($value);
            $lang = substr($value, 6, -4);
            $templates[$value] = base_path("resources/lang/{$lang}/{$this->params['model-names']}.php");
        }
        if($this->isJuctionTable)
            $templates = ['migrations.php' => $templates['migrations.php']];
        foreach ($templates as $source => $destination) {
            $content = $this->substitute(file_get_contents(base_path('app/Libraries/Generator/stubs/') . $source));
            if(!is_dir($basePath = dirname($destination))) {
                $this->fs->makeDirectory($basePath, 0755, true);
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
            'MIGRATIONUPFK' => app('laravel-base-generator.migrationfkup')->make($this->fields, $this->params, $this->relationships),
            'MIGRATIONDOWNFK' => app('laravel-base-generator.migrationfkdown')->make($this->fields, $this->params, $this->relationships),
            'FKMODELMETHODS' => app('laravel-base-generator.modelfkmethods')->make($this->fields, $this->params, $this->relationships),
            'VALIDATIONS' => app('laravel-base-generator.validation')->make($this->fields, $this->params, $this->relationships),
            'MIGRATIONMANYTOMANYUP' => app('laravel-base-generator.migrationmanytomanyup')->make($this->fields, $this->params, $this->relationships),
            'MIGRATIONMANYTOMANYDOWN' => app('laravel-base-generator.migrationmanytomanydown')->make($this->fields, $this->params, $this->relationships),
        ];
    }

    public function make($tableName, $fields = [], $relationships = [], $isJuctionTable = false)
    {
        $this->isJuctionTable = $isJuctionTable;
        $this->tableName = $tableName;
        $this->fs = app('files');
        $this->fields = $fields;
        $this->relationships = $relationships;
        $this->makeBaseParams();
        $this->makeFieldsParams();
        $this->create();
    }

    public function erase($tableName, $isJuctionTable = false)
    {
        $this->isJuctionTable = $isJuctionTable;
        $this->tableName = $tableName;
        $this->fs = app('files');
        $this->makeBaseParams();
        $this->remove();
    }
}
