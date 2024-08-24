<?php

namespace App\Services\Pagare;

use App\Exceptions\PagareAccountWithoutEnoughBalanceException;
use App\Models\Operation;
use App\Repositories\OperationRepository;
use App\Traits\Curl;

class PagarePixService
{
    use Curl;

    public function __construct(
        protected PagareAccountService $accountService,
        protected OperationRepository $operationRepository
    ) {}

    public function pay(Operation $operation): array
    {
        if ($this->accountService->hasEnoughBalance($operation->payerAccount, $operation->value)) {
            $response = $this->post(env('PAGARE_BASE_URL') . 'pix/payment/pay/key', [
                'Content-Type' => 'application/json',
                'AccessToken' => PagareAuth::getUserToken($operation->payerAccount),
                'UserPassword' => env('PAGARE_PWD')
            ], [
                    'key' => $operation->receiverAccount->pix_key,
                    'value' => $operation->value,
                    'keyType' => $operation->receiverAccount->pix_type,
                    'date' => now()->format('Y-m-d'),
                    'description' => 'tarefa simples',
                    'reference' => 'pagamento'
                ]
            );

            return json_decode($response, true);

        } else {
            $this->operationRepository->update($operation->id, ['status' => Operation::NOT_ENOUGH_BALANCE]);
            throw new PagareAccountWithoutEnoughBalanceException("Saldo insuficiente para finalizacao da operacao {$operation->id}");
        }
    }
}
