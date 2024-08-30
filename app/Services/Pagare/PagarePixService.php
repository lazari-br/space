<?php

namespace App\Services\Pagare;

use App\Models\Account;
use App\Models\Operation;
use App\Repositories\OperationRepository;
use App\Traits\Curl;

class PagarePixService
{
    use Curl;

    public function __construct(
        protected OperationRepository $operationRepository
    ) {}

    public function createPixKey(Account $account): array
    {
        $request = $this->post(env('PAGARE_BASE_URL') . 'pix/addressing/create', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getUserToken($account),
            'KeyType' => 'EVP'
        ]);

        return json_decode($request, true);
    }

    public function pay(Operation $operation): array
    {
        $response = $this->post(env('PAGARE_BASE_URL') . 'pix/payment/pay/key', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getUserToken($operation->payerAccount),
            'UserPassword' => $operation->payerAccount->password,
        ], [
                'key' => $operation->receiverAccount->pix_key,
                'value' => $operation->value,
                'keyType' => $operation->receiverAccount->pix_type,
                'date' => now()->format('Y-m-d'),
                'description' => 'pix',
                'reference' => false
            ]
        );

        return json_decode($response, true);
    }

    public function reverse(Operation $operation): array
    {
        $response = $this->post(env('PAGARE_BASE_URL') . 'pix/payment/reversal', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getUserToken($operation->payerAccount),
            'EndToEnd' => $operation->payerAccount->password,
        ], [
                'key' => $operation->receiverAccount->pix_key,
                'value' => $operation->value,
                'keyType' => $operation->receiverAccount->pix_type,
                'date' => now()->format('Y-m-d'),
                'description' => 'pix',
                'reference' => false
            ]
        );

        return json_decode($response, true);
    }
}
