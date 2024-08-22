<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'user_infos';

    protected $fillable = [
        'user_id',
        'document',
        'birthday',
        'occupation',
        'income',
        'ddd',
        'phone',
        'mother_name',
        'father_name',
        'birth_local',
        'gender',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = now()->parse($value);
    }
}
