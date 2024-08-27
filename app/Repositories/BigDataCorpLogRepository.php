<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Integrations\BigDataCorpLog;
use Illuminate\Pagination\LengthAwarePaginator;

class BigDataCorpLogRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = BigDataCorpLog::orderBy('id', 'desc');
        if ($params) {
            $query = BigDataCorpLog::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): BigDataCorpLog
    {
        return BigDataCorpLog::create($data);
    }

    public function find($id): BigDataCorpLog
    {
        return BigDataCorpLog::findOrFail($id);
    }

    public function update($id, $data): BigDataCorpLog
    {
        $zipCode = BigDataCorpLog::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = BigDataCorpLog::findOrFail($id);
        return $zipCode->delete();
    }
}
