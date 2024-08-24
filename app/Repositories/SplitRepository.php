<?php

namespace App\Repositories;

use App\Models\Split;
use Illuminate\Pagination\LengthAwarePaginator;

class SplitRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = Split::orderBy('id', 'desc');
        if ($params) {
            $query = Split::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): Split
    {
        return Split::create($data);
    }

    public function find($id): Split
    {
        return Split::findOrFail($id);
    }

    public function update($id, $data): Split
    {
        $zipCode = Split::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = Split::findOrFail($id);
        return $zipCode->delete();
    }
}
