<?php

namespace App\Services\Pagare;

use App\Traits\Curl;

class PixTransactionService
{
    use Curl;

    public function create(string $pixType, string $pixKey, int $value): array
    {
        $response = $this->post(env('PAGARE_BASE_URL'). 'pix/payment/pay/key', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getToken(),
            'UserPassword' => env('PAGARE_PWD')
        ], [
                'key' => $pixKey,
                'value' => $value,
                'keyType' => $pixType,
                'date' => now()->format('Y-m-d'),
                'description' => 'tarefa simples',
                'reference' => 'pagamento'
            ]
        );

        return json_decode($response, true);
    }
}
