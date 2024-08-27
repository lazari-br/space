<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Integrations\PagareWebhookLog;
use Illuminate\Pagination\LengthAwarePaginator;

class PagareWebhookLogRepository implements BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator
    {
        $query = PagareWebhookLog::orderBy('id', 'desc');
        if ($params) {
            $query = PagareWebhookLog::where($params);
        }
        if ($with) {
            $query = $query->with($with);
        }

        return $query->paginate($paginate);
    }

    public function store($data): PagareWebhookLog
    {
        return PagareWebhookLog::create($data);
    }

    public function find($id): PagareWebhookLog
    {
        return PagareWebhookLog::findOrFail($id);
    }

    public function update($id, $data): PagareWebhookLog
    {
        $zipCode = PagareWebhookLog::findOrFail($id);
        $zipCode->update($data);
        return $zipCode;
    }

    public function delete($id): bool
    {
        $zipCode = PagareWebhookLog::findOrFail($id);
        return $zipCode->delete();
    }
}
