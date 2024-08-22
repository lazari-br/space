<?php

namespace App\Services\Pagare;

use App\Traits\Curl;

class AccountBalanceService
{
    use Curl;

    public function getBalance(): array
    {
        $response = $this->get(env('PAGARE_BASE_URL'). 'digitalaccount/balance', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getToken(),
            'UserPassword' => env('PAGARE_PWD')
        ]);

        return json_decode($response, true);
    }
}
