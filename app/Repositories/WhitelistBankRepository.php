<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\WhitelistBank;
use Illuminate\Pagination\LengthAwarePaginator;

class WhitelistBankRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = WhitelistBank::orderBy('id', 'desc');
        if ($params) {
            $query = WhitelistBank::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): WhitelistBank
    {
        return WhitelistBank::create($data);
    }

    public function find($id): WhitelistBank
    {
        return WhitelistBank::findOrFail($id);
    }

    public function update($id, $data): WhitelistBank
    {
        $zipCode = WhitelistBank::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = WhitelistBank::findOrFail($id);
        return $zipCode->delete();
    }
}
