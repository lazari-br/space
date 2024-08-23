<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserBankInfo;
use App\Models\UserInfo;
use App\Repositories\UserRepository;
use App\Services\BigDataCorp\GetPersonalDataService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected GetPersonalDataService $getPersonalDataService,
        protected UserInfo $userInfoRepository,
        protected UserBankInfo $userBankInfoRepository,
        protected UserAddress $userAddressRepository,
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

    public function getUserData(string $cpf): array
    {
        $info = $this->getPersonalDataService->getData($cpf)['Result'][0];

        return [
            'document' => $cpf,
            //basic_data
            'name' => $info['BasicData']['Name'] ?? '',
            'gender' => $info['BasicData']['Gender'] ?? '',
            'birthday' => $info['BasicData']['BirthDate'] ?? '',
            'mother_name' => $info['BasicData']['MotherName'] ?? '',
            'father_name' => $info['BasicData']['FatherName'] ?? '',
            'birth_local' => $info['BasicData']['BirthCountry'] ?? '',
            //occupation_data
            'occupation' => $info['ProfessionData']['Professions'][0]['Level'] ?? '',
            'income' => $info['ProfessionData']['TotalIncomeRange'] ?? '',
            //addresses_extended
            'zipcode' => $info['ExtendedAddresses']['Addresses'][0]['ZipCode'] ?? '',
            'street' => $info['ExtendedAddresses']['Addresses'][0]['Typology'] . $info['ExtendedAddresses']['Addresses'][0]['AddressMain'] ?? '',
            'number' => $info['ExtendedAddresses']['Addresses'][0]['Number'] ?? '',
            'complement' => $info['ExtendedAddresses']['Addresses'][0]['Complement'] ?? '',
            'neighborhood' => $info['ExtendedAddresses']['Addresses'][0]['Neighborhood'] ?? '',
            'city' => $info['ExtendedAddresses']['Addresses'][0]['City'] ?? '',
            'state' => $info['ExtendedAddresses']['Addresses'][0]['State'] ?? '',
            //phones_extended
            'ddd' => $info[''] ?? 0,
            'phone' => $info[''] ?? 0,
            //emails_extended
            'email' => $info['ExtendedEmails']['Emails'][0]['EmailAddress'] ?? '',
        ];
    }

    public function createUserRelations(User $user, array $data): User
    {
        $user->address = $this->createUserAddress($user->id, $data);
        $user->info =  $this->createUserInfo($user->id, $data);
        $user->bankInfo =  $this->createUserBankInfo($user->id, $data);

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

    private function createUserBankInfo(int $userId, array $data): UserInfo
    {
        return $this->userBankInfoRepository->store([
            'user_id' => $userId,
            'pix_type' => 'email',
            'pix_key' => "email_{$userId}@mail.com",
            'pagare_login' => $data['document1'],
            'pagare_password' => Str::password(8)
        ]);
    }
}
