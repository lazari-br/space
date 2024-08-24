<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance extends Model
{
    use HasFactory;

    protected $table = 'balances';

    protected $fillable = [
        'account_id',
        'current_balance',
        'previous_balance',
        'movement',
        'operation_id',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(Operation::class);
    }
}
