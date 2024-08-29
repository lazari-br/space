<?php

namespace App\Services\Pagare;

use App\Models\Operation;
use App\Repositories\BalanceRepository;

class BalanceService
{
    public function __construct(protected BalanceRepository $balanceRepository) {}

    public function updateBalanceFromOperation(Operation $operation): void
    {
        $this->updateBalance($operation->payerAccount, $operation->id, - $operation->value); // - value because account is paying
        $this->updateBalance($operation->receiverAccount, $operation->id, $operation->value);
    }

    private function updateBalance(Account $account, int $operationId, int $value): void
    {
        $lastBalance = $this->balanceRepository->paginate(1, ['account_id' => $account->id])->first();
        $this->balanceRepository->store([
            'account_id' => $account->id,
            'current_balance' => $lastBalance ? $lastBalance->current_balance + $value : $value,
            'previous_balance' => $lastBalance ? $lastBalance->current_balance : 0,
            'movement' => $value,
            'operation_id' => $operationId,
        ]);
    }
}
