<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountActivationQrCodeRequest;
use App\Http\Requests\CreateAccountRequest;
use App\Repositories\AccountRepository;
use App\Services\Pagare\CreatePagareAccountService;
use App\Services\Pagare\PagareQRCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        protected CreatePagareAccountService $service,
        protected PagareQRCodeService $pagareQRCodeService,
        protected AccountRepository $accountRepository
    ) {}

    public function createAccount(CreateAccountRequest $request): JsonResponse
    {
        $account = $this->service->createAccount($request);
        return response()->json($account);
    }

    public function createAccountActivationQrCode(AccountActivationQrCodeRequest $request): JsonResponse
    {
        $account = $this->accountRepository->find($request->get('account_id'));
        $qrCode = $this->pagareQRCodeService->create($account, $request->get('value'));
        return response()->json($qrCode);
    }
}
