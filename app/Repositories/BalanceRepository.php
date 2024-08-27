<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Balance;
use Illuminate\Pagination\LengthAwarePaginator;

class BalanceRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = Balance::orderBy('id', 'desc');
        if ($params) {
            $query = Balance::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): Balance
    {
        return Balance::create($data);
    }

    public function find($id): Balance
    {
        return Balance::findOrFail($id);
    }

    public function update($id, $data): Balance
    {
        $zipCode = Balance::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = Balance::findOrFail($id);
        return $zipCode->delete();
    }
}
