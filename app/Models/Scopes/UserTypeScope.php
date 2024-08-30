<?php

namespace App\Models\Scopes;

use App\Models\UserType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserTypeScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $authUser = auth()->id()->load('type');

        if ($authUser->type->name !== UserType::MASTER) {
            $builder->where('hierarchy', '<', $authUser->type->hierarchy);
        }
    }
}
