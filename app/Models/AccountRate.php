<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountRate extends Model
{
    use HasFactory;

    protected $table = 'account_rates';

    protected $fillable = [
        'account_id',
        'description',
        'rate'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
