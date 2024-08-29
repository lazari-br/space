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

    public function create(Account $payer, int $value): array
    {
        $response = $this->post(env('PAGARE_BASE_URL'). 'pix/payment/pay/key', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getSpaceToken(),
            'UserPassword' => env('PAGARE_PWD')
        ], [
                'expirationSeconds' => 0,
                'validDaysAfterExpiration' => 0,
                'dueDate' => now()->format('Y-m-d'),
                'payerDocument' => $payer->document,
                'payerName' => $payer->name,
                'value' => $value,
                'interestValue' => 0,
                'indentification' => $payer->document,
                'fineValue' => 0,
                'discoutValue' => 0,
                'reductionValue' => 0,
                'key' => $payer->document,
                'description' => 'Pagamento de serviços',
                'reuse' => true
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
