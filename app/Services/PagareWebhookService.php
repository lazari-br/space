<?php

namespace App\Services;

use App\Models\Integrations\PagareWebhookLog;
use App\Models\Operation;
use App\Repositories\OperationRepository;
use App\Repositories\PagareWebhookLogRepository;

class PagareWebhookService
{
    public function __construct(
        protected OperationRepository $operationRepository,
        protected PagareWebhookLogRepository $logRepository
    ) {}
    public function getPixResult(array $data, PagareWebhookLog $log): void
    {
        $operation = $this->findOperation($data['movementId']);
        $this->logRepository->update($log->id, ['model_id' => $operation->id]);

        #todo : atualizar operation de acordo com request da pagare
    }

    private function findOperation(string $pagareId): Operation
    {
        $operation = $this->operationRepository->paginate(
            1,
            ['pagare_id' => $pagareId],
            ['payerAccount', 'receiverAccount']
        )
            ->first();

        if (!$operation) {
            throw new \Exception('Movement not found', 404);
        }
        return $operation;
    }

    public function logRequest($request, ?Operation $operation = null): PagareWebhookLog
    {
        return $this->logRepository->store([
            'url' => request()->fullUrl(),
            'model' => Operation::class,
            'model_id' => $operation?->id,
            'request' => $request
        ]);
    }
}
