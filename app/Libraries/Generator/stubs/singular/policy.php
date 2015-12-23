<?php

namespace App\Policies;

use App\ModelName;
use App\Libraries\Policy\BasePolicy;

class ModelNamesPolicy extends BasePolicy
{
    public function index()
    {
        return $this->user->ability(['Admin'], ['ModelName:List']);
    }

    public function data()
    {
        return $this->index();
    }

    public function show(ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Show']);
    }

    public function create()
    {
        return $this->user->ability(['Admin'], ['ModelName:Create']);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit(ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Update']);
    }

    public function update(ModelName $modelName)
    {
        return $this->edit($modelName);
    }

    public function duplicate(ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Duplicate']);
    }

    public function revisions(ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Revisions']);
    }

    public function destroy(ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Delete']);
    }

    public function delete(ModelName $modelName)
    {
        return $this->destroy($modelName);
    }
}