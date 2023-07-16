<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class GetLatestDataScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy('id', 'desc');
    }
}