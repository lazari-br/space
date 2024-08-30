<?php

namespace App\Services;

use App\Exceptions\PagareAccountWithoutEnoughBalanceException;
use App\Models\Account;
use App\Models\Operation;
use App\Repositories\AccountRateRepository;
use App\Repositories\AccountRepository;
use App\Repositories\OperationRepository;
use App\Services\BigDataCorp\BigDataCorpService;
use App\Services\Pagare\BalanceService;
use App\Services\Pagare\PagareAccountService;
use App\Services\Pagare\PagarePixService;
use App\Services\Pagare\PagareQRCodeService;
use App\Services\Pagare\PagareTransferService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PagareFeaturesService
{

    public function __construct(
        protected PagarePixService $pagarePixService,
        protected PagareQRCodeService $pagareQRCodeService,
        protected AccountRepository $accountRepository,
        protected OperationRepository $operationRepository,
        protected PagareAccountService $accountService,
        protected PagareTransferService $pagareTransferService,
        protected BalanceService $balanceService,
        protected BigDataCorpService $bigDataCorpService,
        protected PagareAccountService $pagareAccountService,
        protected AccountRateRepository $accountRateRepository
    ) {}

    public function createAccount(string $cpf, array $rates): Account
    {
        $password = $this->createRandomPassword();
        $userData = $this->bigDataCorpService->getData($cpf);
        $pagareAccount = $this->pagareAccountService->create($userData, $password);

        $account = $this->accountRepository->store([
            'name' => $userData['name'],
            'agency' => $pagareAccount['agencia'],
            'account' => $pagareAccount['conta'],
            'login' => $cpf,
            'password' => $password,
            'document' => $cpf,
            'status' => Account::PENDING,
        ]);

        $this->createAccountRates($account, $rates);
        return $account;
    }

    public function createPixKey(Account $account): void
    {
        $pagareResponse = $this->pagarePixService->createPixKey($account);
        $this->updateAccountPixKey($account, $pagareResponse);
    }

    public function makePixTransaction(Account $payer, Account $receiver, int $value): void
    {
        $operation = $this->createOperation($payer, $receiver, $value);

        try {
            $pagareResponse = $this->payOperation($operation);
            $this->updateOperation($operation, $pagareResponse);
        } catch (\Exception $exception) {
            $this->operationRepository->update($operation->id, ['status' => Operation::ERROR_AT_PAGARE]);
        }
    }

    public function payOperation(Operation $operation): array
    {
        if ($this->accountService->hasEnoughBalance($operation->payerAccount, $operation->value)) {
            $transfer = $this->pagareTransferService->transfer($operation);
            $this->balanceService->updateBalanceFromOperation($operation);
            return $transfer;
        } else {
            $this->operationRepository->update($operation->id, ['status' => Operation::NOT_ENOUGH_BALANCE]);
            throw new PagareAccountWithoutEnoughBalanceException("Saldo insuficiente para finalizacao da operacao {$operation->id}");
        }
    }

    public function createQrCode(Account|int $receiver, int $value): array
    {
        if (is_int($receiver)) {
            $receiver = $this->accountRepository->find($receiver);
        }

        $pagareResponse = $this->pagareQRCodeService->create($receiver, $value);
        $this->createQrCodeOperation($receiver, $value, $pagareResponse);
        return $pagareResponse;
    }

    public function reverseOperation(Operation $operation): void
    {
        $this->pagarePixService->reverse($operation);
        $this->balanceService->updateBalanceFromOperation($operation);
    }

    private function createRandomPassword(): string
    {
        return Str::password(8);
    }

    private function createOperation(Account $payerAccount, Account $receiver, int $value): Operation
    {
        return $this->operationRepository->store([
            'payer_account_id' => $payerAccount->id,
            'receiver_account_id' => $receiver->id,
            'operation_type' => Operation::PIX_TRANSACTION,
            'value' => $value,
            'status' => Operation::PENDING
        ]);
    }

    private function updateOperation(Operation $operation, $pagareResponse): void
    {
        $this->operationRepository->update($operation->id, [
            'pagare_id' => $pagareResponse['id'],
            'updated_by_pagare_at' => now(),
            'status' => Operation::SUCCESS
        ]);
    }

    private function updateAccountPixKey(Account $account, array $response): void
    {
        $this->accountRepository->update($account->id, [
            'pix_key' => $response['key'],
            'pix_type' => $response['keyType'],
            'status' => Account::ACTIVE_PIX_KEY,
            'pix_key_created_at' => Carbon::parse($response['createdDate']),
        ]);
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

    private function createAccountRates(Account $account, array $rates): void
    {
        array_map(fn($rate) => $this->accountRateRepository->store([
            'account_id' => $account->id,
            'description' => $rate['description'],
            'rate' => $rate['rate'],
        ]), $rates);
    }
}
