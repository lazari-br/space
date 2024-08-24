<?php

namespace App\Jobs;

use App\Models\Operation;
use App\Services\Pagare\PagarePixService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected  Operation $operation) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (app(PagarePixService::class))->pay($this->operation->payerAccount->load('payerAccount', 'receiverAccount'));
    }
}
