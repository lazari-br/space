<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBankInfo extends Model
{
    use HasFactory;

    protected $table = 'user_bank_infos';

    protected $fillable = [
        'user_id',
        'pix_type',
        'pix_key',
        'pagare_login',
        'pagare_password'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
