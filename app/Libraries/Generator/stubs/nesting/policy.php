<?php

namespace App\Policies;

use App\ModelName;
use App\ParentName;
use App\Libraries\Policy\BasePolicy;

class ModelNamesPolicy extends BasePolicy
{
    public function index(ParentName $parentName)
    {
        return $this->user->ability(['Admin'], ['ModelName:List']);
    }

    public function data(ParentName $parentName)
    {
        return $this->index($parentName);
    }

    public function show(ParentName $parentName, ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Show']);
    }

    public function create(ParentName $parentName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Create']);
    }

    public function store(ParentName $parentName)
    {
        return $this->create($parentName);
    }

    public function edit(ParentName $parentName, ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Update']);
    }

    public function update(ParentName $parentName, ModelName $modelName)
    {
        return $this->edit($parentName, $modelName);
    }

    public function duplicate(ParentName $parentName, ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Duplicate']);
    }

    public function revisions(ParentName $parentName, ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Revisions']);
    }

    public function destroy(ParentName $parentName, ModelName $modelName)
    {
        return $this->user->ability(['Admin'], ['ModelName:Delete']);
    }

    public function delete(ParentName $parentName, ModelName $modelName)
    {
        return $this->destroy($parentName, $modelName);
    }
}