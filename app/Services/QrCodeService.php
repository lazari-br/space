<?php

namespace App\Services;

use App\Exceptions\PagareAccountWithoutEnoughBalanceException;
use App\Models\User;
use App\Services\Pagare\PagareAccountService;
use App\Services\Pagare\PagarePixService;
use App\Services\Pagare\PagareQRCodeService;

class QrCodeService
{
    public function __construct(
        protected PagareQRCodeService $qRCodeService,
        protected PagareAccountService $accountService,
        protected PagareFeaturesService $pagareFeaturesService
    ) {}

    public function pay(User $payer, string $qrCode)
    {
        $qrCodeInfo = $this->qRCodeService->consult($qrCode);
        $payerBalance = $this->accountService->getBalance($payer->account);
        if ($payerBalance['value'] < $qrCodeInfo['value']) {
            throw new PagareAccountWithoutEnoughBalanceException("Saldo {$payerBalance['value']} é insuficiente para o pagamento do valor {$qrCodeInfo['value']}. Erro ocorrido com usuario {$payer->id}");
        }

        $this->pagareFeaturesService->makePixTransaction($payer, );
    }
}
