<?php

namespace App\Providers;

use App\Interfaces\BaseRepositoryInterface;
use App\Repositories\AccountRepository;
use App\Repositories\BalanceRepository;
use App\Repositories\BetTableMemberRepository;
use App\Repositories\BetTableRepository;
use App\Repositories\BigDataCorpLogRepository;
use App\Repositories\OperationRepository;
use App\Repositories\PagareWebhookLogRepository;
use App\Repositories\SplitRepository;
use App\Repositories\UserAddressRepository;
use App\Repositories\UserInfoRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserTypeRepository;
use Illuminate\Support\ServiceProvider;

class AppRepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, AccountRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, BalanceRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, BetTableMemberRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, BetTableRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, BigDataCorpLogRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, OperationRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, PagareWebhookLogRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, SplitRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, UserAddressRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, UserInfoRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, UserRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, UserTypeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
