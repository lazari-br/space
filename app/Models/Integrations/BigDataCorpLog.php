<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigDataCorpLog extends Model
{
    use HasFactory;

    protected $table = 'big_data_corp_logs';

    protected $fillable = [
        'cpf',
        'response'
    ];

    protected $casts = [
        'response' => 'array'
    ];

    public function setResponseAttribute($value): void
    {
        $this->attributes['response'] = is_array($value) ? json_encode($value) : $value;
    }

}
