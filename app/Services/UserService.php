<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserInfo;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected UserInfo $userInfoRepository,
        protected UserAddress $userAddressRepository
    ) {}

    public function store(array $data): User
    {
        return $this->userRepository->store($data);
    }

    public function update(int $id, array $data): User
    {
        return $this->userRepository->update($id, $data);
    }

    public function show(int $id): User
    {
        return $this->userRepository->find($id);
    }

    public function list(?array $params = [], ?int $paginate = 10): LengthAwarePaginator
    {
        return $this->userRepository->paginate($paginate, $params);
    }

    public function createUserRelations(User $user, array $data): User
    {
        $user->address = $this->createUserAddress($user->id, $data);
        $user->info =  $this->createUserInfo($user->id, $data);

        return $user;
    }

    private function createUserAddress(int $userId, array $data): UserAddress
    {
        return  $this->userAddressRepository->store([
            'user_id' => $userId,
            'street' => $data['street'],
            'number' => $data['number'],
            'zipcode' => $data['zipcode'],
            'complement' => $data['complement'],
            'neighborhood' => $data['neighborhood'],
            'city' => $data['city'],
            'state' => $data['state'],
        ]);
    }

    private function createUserInfo(int $userId, array $data): UserInfo
    {
        return $this->userInfoRepository->store([
            'user_id' => $userId,
            'document' => $data['document'],
            'birthday' => $data['birthday'],
            'occupation' => $data['occupation'],
            'income' => $data['income'],
            'ddd' => $data['ddd'],
            'phone' => $data['phone'],
            'mother_name' => $data['mother_name'],
            'father_name' => $data['father_name'],
            'birth_local' => $data['birth_local'],
            'gender' => $data['gender'],
        ]);
    }
}
