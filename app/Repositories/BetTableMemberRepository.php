<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\BetTableMember;
use Illuminate\Pagination\LengthAwarePaginator;

class BetTableMemberRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = BetTableMember::orderBy('id', 'desc');
        if ($params) {
            $query = BetTableMember::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): BetTableMember
    {
        return BetTableMember::create($data);
    }

    public function find($id): BetTableMember
    {
        return BetTableMember::findOrFail($id);
    }

    public function update($id, $data): BetTableMember
    {
        $zipCode = BetTableMember::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = BetTableMember::findOrFail($id);
        return $zipCode->delete();
    }
}
