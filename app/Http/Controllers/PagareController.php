<?php

namespace App\Http\Controllers;

use App\Http\Requests\PixWebhookRequest;
use App\Services\PagareWebhookService;
use Illuminate\Http\JsonResponse;

class PagareController extends Controller
{
    public function __construct(protected PagareWebhookService $pagareWebhookService) {}

    public function pixWebhook(PixWebhookRequest $request): JsonResponse
    {
        $data = $request->all();
        $log = $this->pagareWebhookService->logRequest($data);
        $this->pagareWebhookService->getPixResult($data, $log);

        return response()->json(); #todo : alinhar response
    }
}
