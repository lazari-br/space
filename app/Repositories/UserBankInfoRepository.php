<?php

namespace App\Repositories;

use App\Models\UserBankInfo;
use Illuminate\Pagination\LengthAwarePaginator;

class UserBankInfoRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = UserBankInfo::orderBy('id', 'desc');
        if ($params) {
            $query = UserBankInfo::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): UserBankInfo
    {
        return UserBankInfo::create($data);
    }

    public function find($id): UserBankInfo
    {
        return UserBankInfo::findOrFail($id);
    }

    public function update($id, $data): UserBankInfo
    {
        $zipCode = UserBankInfo::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = UserBankInfo::findOrFail($id);
        return $zipCode->delete();
    }
}
