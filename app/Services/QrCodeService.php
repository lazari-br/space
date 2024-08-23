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
        protected PagarePixService $pixService,
        protected PagareAccountService $accountService
    ) {}
    public function pay(User $payer, string $qrCode)
    {
        $qrCodeInfo = $this->qRCodeService->consult($qrCode);
        $payerBalance = $this->accountService->getBalance($payer);
        if ($payerBalance['value'] < $qrCodeInfo['value']) {
            throw new PagareAccountWithoutEnoughBalanceException("Saldo {$payerBalance['value']} é insuficiente para o pagamento do valor {$qrCodeInfo['value']}. Erro ocorrido com usuario {$payer->id}");
        }

        $this->pixService->pay($payer->bankInfo->pix_type, $payer->bankInfo->pix_key, $qrCodeInfo['value']);
    }
}
