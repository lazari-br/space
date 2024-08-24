<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = Account::orderBy('id', 'desc');
        if ($params) {
            $query = Account::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): Account
    {
        return Account::create($data);
    }

    public function find($id): Account
    {
        return Account::findOrFail($id);
    }

    public function update($id, $data): Account
    {
        $zipCode = Account::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = Account::findOrFail($id);
        return $zipCode->delete();
    }
}
