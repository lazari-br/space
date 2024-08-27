<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function paginate($paginate = 10, array $params = [], array|string $with = ''): LengthAwarePaginator;

    public function store($data): Model;

    public function find($id): Model;

    public function update($id, $data): Model;

    public function delete($id): bool;
}
