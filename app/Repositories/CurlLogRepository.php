<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\CurlLog;
use Illuminate\Pagination\LengthAwarePaginator;

class CurlLogRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = CurlLog::orderBy('id', 'desc');
        if ($params) {
            $query = CurlLog::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): CurlLog
    {
        return CurlLog::create($data);
    }

    public function find($id): CurlLog
    {
        return CurlLog::findOrFail($id);
    }

    public function update($id, $data): CurlLog
    {
        $zipCode = CurlLog::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = CurlLog::findOrFail($id);
        return $zipCode->delete();
    }
}
