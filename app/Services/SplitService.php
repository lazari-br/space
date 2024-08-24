<?php

namespace App\Services;

use App\Models\BetTable;
use App\Models\BetTableMember;
use App\Models\Operation;
use App\Repositories\OperationRepository;
use App\Repositories\SplitRepository;

class SplitService
{
    public function __construct(
        protected SplitRepository $splitRepository,
        protected OperationRepository $operationRepository,
    ) {}
    public function makeSplit(BetTable $betTable)
    {
        $betTable->members->map(fn($member) => $this->splitMemberPayment($betTable, $member));
    }

    private function splitMemberPayment(BetTable $betTable, BetTableMember $member): void
    {
        $memberValue = $betTable->betValue * $member->account_income_rate;
        $operation = $this->createOperation($memberValue, $member, $betTable->winnerAccount->id);
        $this->splitRepository->store([
            'bet_table_id' => $member->bet_table_id,
            'payer_account_id' => $betTable->winnerAccount->id,
            'receiver_account_id' => $member->account->id,
            'operation_id' => $operation,
            'value' => $memberValue,
        ]);
    }

    private function createOperation(int $memberValue, BetTableMember $member, int $winnerAccountId): Operation
    {
        return $this->operationRepository->store([
            'payer_account_id' => $winnerAccountId,
            'receiver_account_id' => $member->account->id,
            'operation_type' => 'SPLIT',
            'value' => $memberValue,
            'status',
        ]);
    }
}
