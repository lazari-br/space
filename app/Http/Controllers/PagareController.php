<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQrcodeRequest;
use App\Http\Requests\PixWebhookRequest;
use App\Services\PagareFeaturesService;
use App\Services\PagareWebhookService;
use Illuminate\Http\JsonResponse;

class PagareController extends Controller
{
    public function __construct(
        protected PagareWebhookService $pagareWebhookService,
        protected PagareFeaturesService $pagareFeaturesService
    ) {}

    public function pixWebhook(PixWebhookRequest $request): JsonResponse
    {
        $data = $request->all();
        $log = $this->pagareWebhookService->logRequest($data);
        $this->pagareWebhookService->getPixResult($data, $log);

        return response()->json(); #todo : alinhar response
    }

    public function createQrCode(CreateQrcodeRequest $request): JsonResponse
    {
        $qrcode = $this->pagareFeaturesService->createQrCode($request->get('account_id'), $request->get('value'));
        return response()->json($qrcode);
    }
}
