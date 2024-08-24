<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BetTableMember extends Model
{
    use HasFactory;

    protected $table = 'bet_table_members';

    protected $fillable = [
        'bet_table_id',
        'account_id',
        'account_income_rate'
    ];

    public function betTable(): BelongsTo
    {
        return $this->belongsTo(BetTable::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
