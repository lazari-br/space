<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operation extends Model
{
    use HasFactory;

    const PENDING = 'PENDING';
    const NOT_ENOUGH_BALANCE = 'NOT_ENOUGH_BALANCE';

    protected $table = 'operations';

    protected $fillable = [
        'payer_account_id',
        'receiver_account_id',
        'operation_type',
        'value',
        'status',
        'pagare_id',
        'updated_by_pagare_at'
    ];

    public function payerAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'payer_account_id', 'id');
    }

    public function receiverAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'receiver_account_id', 'id');
    }
}
