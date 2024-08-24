<?php

namespace App\Services\BigDataCorp;

use App\Repositories\BigDataCoroLogRepository;
use App\Traits\Curl;

class GetPersonalDataService
{
    use Curl;

    protected function __construct(protected BigDataCoroLogRepository $logRepository) {}
    public function getData(string $cpf)
    {
        $auth = Login::auth();
        $response = $this->post(env('BIG_DATA_CORP_BASE_URL'). 'pessoas', [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'AccessToken' => $auth['token'],
            'TokenId' => $auth['tokenId']
        ], [
            'Datasets' => 'basic_data{name,gender,birthDate,motherName,fatherName,birthCountry},phones_extended{professions,totalIncomeRange},occupation_data,addresses_extended{Addresses},emails_extended',
            'q' => "doc{{$cpf}}"
        ]);

        $responseAsArray = json_decode($response, true);
        $this->log($cpf, $responseAsArray);

        return $responseAsArray;
    }

    private function log(string $cpf, array $response): void
    {
        $this->logRepository->store([
            'cpf' => $cpf ,
            'response' => $response
        ]);
    }
}
