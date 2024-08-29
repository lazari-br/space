<?php

namespace App\Observers;

use App\Jobs\CreatePagareAccountJob;
use App\Models\User;
use App\Services\PagareFeaturesService;

class UserObserver
{
    public function created(User $user): void
    {
        CreatePagareAccountJob::dispatch($user->info->document);
    }
}
