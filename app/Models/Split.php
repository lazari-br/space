<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Split extends Model
{
    use HasFactory;

    protected $table = 'split';

    protected $fillable = [
        'bet_table_id',
        'payer_account_id',
        'receiver_account_id',
        'operation_id',
        'value',
    ];

    public function betTable(): BelongsTo
    {
        return $this->belongsTo(BetTable::class);
    }

    public function payerAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'payer_account_id', 'id');
    }

    public function receiverAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'receiver_account_id', 'id');
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(Operation::class);
    }
}
