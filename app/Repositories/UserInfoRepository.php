<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\UserInfo;
use Illuminate\Pagination\LengthAwarePaginator;

class UserInfoRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = UserInfo::orderBy('id', 'desc');
        if ($params) {
            $query = UserInfo::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): UserInfo
    {
        return UserInfo::create($data);
    }

    public function find($id): UserInfo
    {
        return UserInfo::findOrFail($id);
    }

    public function update($id, $data): UserInfo
    {
        $zipCode = UserInfo::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = UserInfo::findOrFail($id);
        return $zipCode->delete();
    }
}
