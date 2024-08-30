<?php

namespace App\Services\Pagare;

use App\Models\Operation;
use App\Traits\Curl;

class PagareTransferService
{
    use Curl;

    public function transfer(Operation $operation): array
    {
        $request = $this->post(env('PAGARE_BASE_URL') . 'digitalaccount/tef', [
            'Content-Type' => 'application/json',
            'AccessToken' => PagareAuth::getUserToken($operation->payerAccount),
            'UserPassword' => $operation->payerAccount->password
        ], [
            'value' => $operation->value,
            'description' => 'transferencia',
            'date' => null,
            'toAccount' => [
                'bank' => '633',
                'agency' => $operation->receiverAccount->agency,
                'account' => $operation->receiverAccount->account,
                'name' => $operation->receiverAccount->name,
                'document' => $operation->receiverAccount->document
            ]
        ]);

        return json_decode($request, true);
    }
}
