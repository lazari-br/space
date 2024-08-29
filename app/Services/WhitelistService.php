<?php

namespace App\Services;

use App\Repositories\WhitelistBankRepository;

class WhitelistService
{
    public function __construct(protected WhitelistBankRepository $whitelistBankRepository) {}

    public function isWhitelisted(): bool
    {
        return $this->whitelistBankRepository->paginate(1, ['' => ''])->isEmpty();
    }
}
