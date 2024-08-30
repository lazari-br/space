<?php

namespace App\Services\Pagare;

use App\Models\Account;
use App\Models\Operation;
use App\Repositories\OperationRepository;
use App\Traits\Curl;

class PagareQRCodeService
{
    use Curl;

    public function __construct(protected OperationRepository $operationRepository) {}

    public function create(Account $receiver, int $value): array
    {
        $response = $this->post(env('PAGARE_BASE_URL'). 'pix/qrcode/static', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getSpaceToken(),
            'QRCodeType' => 'URLBASE'
        ], [
                'value' => $value,
                'key' => $receiver->pix_key,
                'description' => 'activation qrcode',
                'identification' => $receiver->document
            ]
        );

        return json_decode($response, true);
    }
    public function consult(string $qrCode): array
    {
        $response = $this->post(env('PAGARE_BASE_URL'). 'pix/qrcode/consult', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getSpaceToken(),
            'UserPassword' => env('PAGARE_PWD')
        ], [
                'qrCodeType' => 'DEFAULT',
                'qrCode' => $qrCode
            ]
        );

        return json_decode($response, true);
    }
}
