<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\AccountRate;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountRateRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = AccountRate::orderBy('id', 'desc');
        if ($params) {
            $query = AccountRate::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): AccountRate
    {
        return AccountRate::create($data);
    }

    public function find($id): AccountRate
    {
        return AccountRate::findOrFail($id);
    }

    public function update($id, $data): AccountRate
    {
        $zipCode = AccountRate::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = AccountRate::findOrFail($id);
        return $zipCode->delete();
    }
}
