<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BetTable extends Model
{
    use HasFactory;

    protected $table = 'bet_tables';

    protected $fillable = [
        'name',
        'franchisee_user_id',
        'bet_value',
        'has_won',
        'winner_account_id'
    ];

    public function franchiseeUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'franchisee_user_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(BetTableMember::class, 'bet_table_id');
    }

    public function winnerAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'winner_account_id');
    }
}
