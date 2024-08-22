<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserInfo;
use App\Repositories\UserRepository;
use App\Services\BigDataCorp\GetPersonalDataService;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(protected UserRepository $userRepository, protected GetPersonalDataService $getPersonalDataService){}

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
        $user->address = UserAddress::create([
            'user_id' => $user->id,
            'street' => $data['street'],
            'number' => $data['number'],
            'zipcode' => $data['zipcode'],
            'complement' => $data['complement'],
            'neighborhood' => $data['neighborhood'],
            'city' => $data['city'],
            'state' => $data['state'],
        ]);

        $user->info = UserInfo::create([
            'user_id' => $user->id,
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

        return $user;
    }
}
