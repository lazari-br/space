<?php

namespace App\Repositories;

use App\Models\BetTable;
use Illuminate\Pagination\LengthAwarePaginator;

class BetTableRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = BetTable::orderBy('id', 'desc');
        if ($params) {
            $query = BetTable::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): BetTable
    {
        return BetTable::create($data);
    }

    public function find($id): BetTable
    {
        return BetTable::findOrFail($id);
    }

    public function update($id, $data): BetTable
    {
        $zipCode = BetTable::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = BetTable::findOrFail($id);
        return $zipCode->delete();
    }
}
