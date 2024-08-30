<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    const PENDING = 'PENDING';
    const ACTIVE_PIX_KEY = 'ACTIVE_PIX_KEY';

    protected $table = 'accounts';

    protected $fillable = [
        'name',
        'agency',
        'account',
        'login',
        'password',
        'document',
        'pix_key',
        'pix_type',
        'status',
        'pix_key_created_at',
        'pix_key_deleted_at',
    ];
}
