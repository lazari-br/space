<?php

namespace App\Console\Commands\Temp;

use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Services\Pagare\PagareAccountService;
use App\Services\Pagare\PagarePixService;
use App\Services\PagareFeaturesService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class MakeTenOperationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-ten-operations-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected AccountRepository $accountRepository,
        protected PagareFeaturesService $pagareFeaturesService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $accounts = $this->getAccounts();
        $accounts->map(function($payer) use ($accounts) {
            $this->pagareFeaturesService->makePixTransaction($this->getFirstAccount(), $payer, 2);

            $this->pagareFeaturesService->makePixTransaction(
                $payer, $accounts->where('id', '<>', $payer->id)->random(1)->first(), 1
            );
        });
    }

    private function getFirstAccount(): Account
    {
        return $this->accountRepository->paginate(1, ['document' => '05058877627'])->first();
    }

    private function getAccounts(): Collection
    {
        return collect($this->accountRepository->paginate(10, [['pix_key', '<>', null]])->items());
    }
}
