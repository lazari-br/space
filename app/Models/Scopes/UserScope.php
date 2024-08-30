<?php

namespace App\Models\Scopes;

use App\Models\UserType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $authUser = auth()->id()->load(['relatedUsers', 'type']);

        if ($authUser->type->name !== UserType::MASTER) {
            $builder->whereIn('id', $authUser->relatedUsers->where('is_superior', true)->pluck('id'));
        }
    }
}
