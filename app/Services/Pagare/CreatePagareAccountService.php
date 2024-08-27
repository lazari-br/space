<?php

namespace App\Services\Pagare;

use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Services\BigDataCorp\BigDataCorpService;
use Illuminate\Support\Str;

class CreatePagareAccountService
{
    public function __construct(
        protected BigDataCorpService $bigDataCorpService,
        protected PagareAccountService $pagareAccountService,
        protected AccountRepository $accountRepository
    ) {}

    public function createAccount(string $cpf): Account
    {
        $password = $this->createRandomPassword();
        $userData = $this->bigDataCorpService->getData($cpf);
        $pagareAccount = $this->pagareAccountService->create($userData, $password);

        return $this->accountRepository->store([
            'name' => $userData['name'],
            'agency' => $pagareAccount['agencia'],
            'account' => $pagareAccount['conta'],
            'login' => $cpf,
            'password' => $password,
            'document' => $cpf,
            'status' => Account::PENDING,
        ]);
    }

    private function createRandomPassword(): string
    {
        return Str::password(8);
    }
}
