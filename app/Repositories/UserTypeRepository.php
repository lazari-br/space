<?php

namespace App\Repositories;

use App\Models\UserType;
use Illuminate\Pagination\LengthAwarePaginator;

class UserTypeRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = UserType::orderBy('id', 'desc');
        if ($params) {
            $query = UserType::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): UserType
    {
        return UserType::create($data);
    }

    public function find($id): UserType
    {
        return UserType::findOrFail($id);
    }

    public function update($id, $data): UserType
    {
        $zipCode = UserType::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = UserType::findOrFail($id);
        return $zipCode->delete();
    }
}
