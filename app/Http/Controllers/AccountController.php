<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountActivationQrCodeRequest;
use App\Http\Requests\CreateAccountRequest;
use App\Jobs\CreatePagareAccountJob;
use App\Repositories\AccountRepository;
use App\Services\Pagare\PagareQRCodeService;
use App\Services\PagareFeaturesService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    public function __construct(
        protected PagareFeaturesService $pagareFeaturesService,
        protected PagareQRCodeService $pagareQRCodeService,
        protected AccountRepository $accountRepository
    ) {}

    public function createAccount(CreateAccountRequest $request): JsonResponse
    {
        CreatePagareAccountJob::dispatch($request->get('cpf'), $request->get('rates'));
        return response()->json(['message' => 'sucesso']);
    }

    public function createAccountActivationQrCode(AccountActivationQrCodeRequest $request): JsonResponse
    {
        $account = $this->accountRepository->find($request->get('account_id'));
        $qrCode = $this->pagareQRCodeService->create($account, $request->get('value'));
        return response()->json($qrCode);
    }
}
