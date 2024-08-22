<?php

namespace App\Services\BigDataCorp;

use App\Traits\Curl;

class GetPersonalDataService
{
    use Curl;
    public function getData(string $cpf)
    {
        $auth = Login::auth();
        $response = (new self)->post(env('BIG_DATA_CORP_BASE_URL'). 'pessoas', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'AccessToken' => $auth['token'],
            'TokenId' => $auth['tokenId']
        ], [
            'Datasets' => 'basic_data{name,gender,birthDate,motherName,fatherName,birthCountry},phones_extended{professions,totalIncomeRange},occupation_data,addresses_extended{Addresses},emails_extended',
            'q' => "doc{{$cpf}}"
        ]);

        return json_decode($response, true);
    }
}
