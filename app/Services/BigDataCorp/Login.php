<?php

namespace App\Services\BigDataCorp;

use App\Traits\Curl;
use Illuminate\Support\Facades\Cache;

class Login
{
    use Curl;
    public static function auth(): array
    {
        return Cache::remember('big_data_corp_login', 36000, function () {
            $request = (new self)->post(env('BIG_DATA_CORP_BASE_URL'). 'tokens/gerar', [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ], [
                'login' => env('BIG_DATA_CORP_LOGIN'),
                'password' => env('BIG_DATA_CORP_PWD'),
                'expires' => 24
            ]);

            $response = json_decode($request, true);
            return [
                'token' => $response['token'],
                'tokenId' => $response['tokenID'],
            ];
        });
    }
}
