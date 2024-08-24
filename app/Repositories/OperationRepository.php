<?php

namespace App\Repositories;

use App\Models\Operation;
use Illuminate\Pagination\LengthAwarePaginator;

class OperationRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = Operation::orderBy('id', 'desc');
        if ($params) {
            $query = Operation::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): Operation
    {
        return Operation::create($data);
    }

    public function find($id): Operation
    {
        return Operation::findOrFail($id);
    }

    public function update($id, $data): Operation
    {
        $zipCode = Operation::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = Operation::findOrFail($id);
        return $zipCode->delete();
    }
}
