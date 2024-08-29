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
        $response = $this->post(env('PAGARE_BASE_URL'). 'onboarding/pixaccount', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getSpaceToken(),
            'Password' => env('PAGARE_PWD')
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
            'password' => $password,

            'document' => $data['document'],
            'birthDate' => $data['birthday'],
            'occupation' => $data['occupation'],
            'income' => $data['income'] ?? 0,
            'ddd' => $data['ddd'],
            'phone' => $data['phone'],
            'motherName' => $data['mother_name'] ?? 'desconhecida',
            'fatherName' => $data['father_name'] ?? 'desconhecido',
            'birthLocal' => $data['birth_local'],
            'gender' => $data['gender'] ?? 'M',

            'zipCode' => $data['zipcode'] ?? '01000000',
            'street' => $data['street'] ?? 'Desconhecido',
            'number' => $data['number'] ?? 'S/N',
            'complement' => $data['complement'] ?? '-',
            'neighborhood' => $data['neighborhood'] ?? 'Desconhecido',
            'city' => $data['city'] ?? 'Desconhecido',
            'state' => $data['state'] ?? 'Desconhecido',

            'ipSignature' => request()->ip(),
            'dateTimeSignature' => now()->format('Y-m-d\Th:i\Z'), //'2024-08-09T22:16:00Z'
            'pep' => false,
            'acceptTerms' => true,
            'sendEMail' => false,
            'sendNotification' => false
        ];
    }

    public function hasEnoughBalance(Account $account, int $value): bool
    {
        $payerBalance = $this->getBalance($account);
        return ($payerBalance['value'] > $value);
    }
}
