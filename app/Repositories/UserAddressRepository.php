<?php

namespace App\Repositories;

use App\Models\UserAddress;
use Illuminate\Pagination\LengthAwarePaginator;

class UserAddressRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = UserAddress::orderBy('id', 'desc');
        if ($params) {
            $query = UserAddress::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): UserAddress
    {
        return UserAddress::create($data);
    }

    public function find($id): UserAddress
    {
        return UserAddress::findOrFail($id);
    }

    public function update($id, $data): UserAddress
    {
        $zipCode = UserAddress::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = UserAddress::findOrFail($id);
        return $zipCode->delete();
    }
}
