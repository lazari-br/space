<?php

namespace App\Services\Pagare;

use App\Models\Account;
use App\Models\User;
use App\Traits\Curl;

class PagareAccountService
{
    use Curl;

    public function create(array $data, string $password): array
    {
//dump($this->getBody($user, $password));
        $response = $this->post(env('PAGARE_BASE_URL'). 'onboarding/pixaccount', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getSpaceToken(),
            'UserPassword' => env('PAGARE_PWD')
        ],
            $this->getBody($data, $password)
        );

        return json_decode($response, true);
    }

    public function getBalance(Account $account): array
    {
        $response = $this->get(env('PAGARE_BASE_URL'). 'digitalaccount/balance', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getUserToken($account),
            'UserPassword' => env('PAGARE_PWD')
        ]);

        return json_decode($response, true);
    }

    private function getBody(array $data, string $password): array
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],

            'document' => $data['document'],
            'birthDate' => $data['birthday'],
            'occupation' => $data['occupation'],
            'income' => $this->getIncome($data['income']),
            'ddd' => $data['ddd'],
            'phone' => $data['phone'],
            'motherName' => $data['motherName'],
            'fatherName' => $data['fatherName'],
            'birthLocal' => $data['birth_local'],
            'gender' => $data['gender'],

            'zipCode' => $data['zipCode'],
            'street' => $data['street'],
            'number' => $data['number'],
            'complement' => $data['complement'],
            'neighborhood' => $data['neighborhood'],
            'city' => $data['city'],
            'state' => $data['state'],

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

    public function hasEnoughBalance(Account $account, int $value): bool
    {
        $payerBalance = $this->getBalance($account);
        return ($payerBalance['value'] > $value);
    }
}
