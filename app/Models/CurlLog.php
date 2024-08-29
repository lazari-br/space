<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurlLog extends Model
{
    use HasFactory;

    protected $table = 'curl_logs';

    protected $fillable = [
        'url',
        'method',
        'http_code',
        'headers',
        'body',
        'response'
    ];

    protected $casts = [
        'headers' => 'array',
        'body' => 'array',
        'response' => 'array'
    ];

    public function setHeaders($value): void
    {
        $this->attributes['headers'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setBody($value): void
    {
        $this->attributes['body'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setResponse($value): void
    {
        $this->attributes['response'] = is_array($value) ? json_encode($value) : $value;
    }
}
