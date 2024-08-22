<?php

namespace App\Services\Pagare;

use App\Models\User;
use App\Traits\Curl;

class CreateAccountService
{
    use Curl;

    public function create(User $user, string $password): array
    {
//dump($this->getBody($user, $password));
        $user = $user->load(['info', 'address']);
        $response = $this->post(env('PAGARE_BASE_URL'). 'onboarding/pixaccount', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getToken(),
            'UserPassword' => env('PAGARE_PWD')
        ],
            $this->getBody($user, $password)
        );

        return json_decode($response, true);
    }
    private function getBody(User $user, string $password): array
    {
        return [
            'name' => $user->name,
            'email' => $user->email,

            'document' => $user->info->document,
            'birthDate' => $user->info->birthday,
            'occupation' => $user->info->occupation,
            'income' => $this->getIncome($user->info->income),
            'ddd' => $user->info->ddd,
            'phone' => $user->info->phone,
            'motherName' => $user->info->motherName,
            'fatherName' => $user->info->fatherName,
            'birthLocal' => $user->info->birth_local,
            'gender' => $user->info->gender,

            'zipCode' => $user->address->zipCode,
            'street' => $user->address->street,
            'number' => $user->address->number,
            'complement' => $user->address->complement,
            'neighborhood' => $user->address->neighborhood,
            'city' => $user->address->city,
            'state' => $user->address->state,

            'ipSignature' => '',
            'dateTimeSignature' => '', //'2024-08-09T22:16:00Z'
            'pep' => false,

            'acceptTerms' => true,
            'password' => $password,
            'sendEMail' => false,
            'sendNotification' => false
        ];
    }

    private function getIncome($income): float
    {
        if ($income == '4 A 10 SM') {
            $response = 6 * 1640;
        } elseif ($income == '1 A 4 SM') {
            $response = 2 * 1640;
        } else {
            $response = $income;
        }

        return $response;
    }
}
