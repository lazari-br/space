<?php

namespace App\Observers;

use App\Jobs\PaymentJob;
use App\Models\Operation;

class OperationObserver
{
    public function created(Operation $operation): void
    {
        PaymentJob::dispatch($operation);
    }
}
