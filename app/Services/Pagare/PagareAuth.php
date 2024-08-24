<?php

namespace App\Services\Pagare;

use App\Models\Account;
use App\Models\User;
use App\Traits\Curl;
use Illuminate\Support\Facades\Cache;

class PagareAuth
{
    use Curl;
    public static function getSpaceToken(): string
    {
        $expirationTime = 36000;
        return Cache::remember('pagare_token', $expirationTime, function () use ($expirationTime) {
            $response = (new self)->post(env('PAGARE_BASE_URL'). 'api/user/auth', [
                'Content-Type' => 'application/json',
                'TenantKey' => env('PAGARE_TENANT_KEY'),
            ], [
                'login' => env('PAGARE_LOGIN'),
                'password' => env('PAGARE_PWD'),
                'expiration' => $expirationTime
            ]);

            return json_decode($response, true)['accessKey'];
        });
    }
    public static function getUserToken(Account $account): string
    {
        $expirationTime = 36000;
        return Cache::remember('pagare_token-account:'. $account->id, $expirationTime, function () use ($expirationTime, $account) {
            $response = (new self)->post(env('PAGARE_BASE_URL'). 'api/user/auth', [
                'Content-Type' => 'application/json',
                'TenantKey' => env('PAGARE_TENANT_KEY'),
            ], [
                'login' => $account->login,
                'password' => $account->password,
                'expiration' => $expirationTime
            ]);

            return json_decode($response, true)['accessKey'];
        });
    }
}
