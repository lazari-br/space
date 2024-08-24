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

        $responseAsArray = json_decode($response, true);
        $this->createQrCodeOperation($payer, $value, $responseAsArray);

        return $responseAsArray;
    }

    public function consult(string $qrCode): array
    {
        $response = $this->post(env('PAGARE_BASE_URL'). 'pix/payment/pay/key', [
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

    private function createQrCodeOperation(Account $payer, int $value, array $response): void
    {
        $this->operationRepository->store([
            'receiver_account_id' => $payer->id,
            'operation_type' => 'QR_CODE',
            'value' => $value,
            'status' => Operation::PENDING,
            'pagare_id' => $response['identification'],
        ]);
    }
}
