<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagareWebhookLog extends Model
{
    use HasFactory;

    protected $table = 'pagare_webhook_logs';

    protected $fillable = [
        'url',
        'model',
        'model_id',
        'request'
    ];

    protected $casts = [
        'response' => 'array'
    ];

    public function setRequestAttribute($value): void
    {
        $this->attributes['response'] = is_array($value) ? json_encode($value) : $value;
    }
}
