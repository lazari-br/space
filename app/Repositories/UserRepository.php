<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = User::orderBy('id', 'desc');
        if ($params) {
            $query = User::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): User
    {
        return User::create($data);
    }

    public function find($id): User
    {
        return User::findOrFail($id);
    }

    public function update($id, $data): User
    {
        $zipCode = User::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = User::findOrFail($id);
        return $zipCode->delete();
    }
}
