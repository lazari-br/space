<?php

namespace App\Services;

use App\Models\UserType;
use App\Repositories\UserTypeRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserTypeService
{
    public function __construct(protected UserTypeRepository $userRepository){}

    public function store(array $data): UserType
    {
        return $this->userRepository->store($data);
    }

    public function update(int $id, array $data): UserType
    {
        return $this->userRepository->update($id, $data);
    }

    public function show(int $id): UserType
    {
        return $this->userRepository->find($id);
    }

    public function list(?array $params = [], ?int $paginate = 10): LengthAwarePaginator
    {
        return $this->userRepository->paginate($paginate, $params);
    }
}
