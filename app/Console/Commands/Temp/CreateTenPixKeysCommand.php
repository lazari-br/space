<?php

namespace App\Console\Commands\Temp;

use App\Repositories\AccountRepository;
use App\Services\Pagare\PagarePixService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CreateTenPixKeysCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-ten-pix-keys-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected AccountRepository $accountRepository,
        protected PagarePixService $pagarePixService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $accounts = $this->getAccounts();
        $accounts->map(fn($account) => $this->pagarePixService->createPixKey($account));
    }

    private function getAccounts(): Collection
    {
        return collect($this->accountRepository->paginate(10)->items());
    }
}
