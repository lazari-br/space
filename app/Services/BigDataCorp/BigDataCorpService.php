<?php

namespace App\Services\BigDataCorp;

use App\Repositories\BigDataCoroLogRepository;
use App\Traits\Curl;

class BigDataCorpService
{
    use Curl;

    protected function __construct(protected BigDataCoroLogRepository $logRepository) {}

    public function getData(string $cpf): array
    {
        $data = $this->makeRequest($cpf);
        return $this->translateData($cpf, $data);
    }

    private function makeRequest(string $cpf)
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

    private function translateData(string $cpf, array $info): array
    {
        return [
            'document' => $cpf,
            //basic_data
            'name' => $info['BasicData']['Name'] ?? null,
            'gender' => $info['BasicData']['Gender'] ?? null,
            'birthday' => $info['BasicData']['BirthDate'] ?? null,
            'mother_name' => $info['BasicData']['MotherName'] ?? null,
            'father_name' => $info['BasicData']['FatherName'] ?? null,
            'birth_local' => $info['BasicData']['BirthCountry'] ?? null,
            //occupation_data
            'occupation' => $info['ProfessionData']['Professions'][0]['Level'] ?? null,
            'income' => $info['ProfessionData']['TotalIncomeRange'] ?? null,
            //addresses_extended
            'zipcode' => $info['ExtendedAddresses']['Addresses'][0]['ZipCode'] ?? null,
            'street' => $info['ExtendedAddresses']['Addresses'][0]['Typology'] . $info['ExtendedAddresses']['Addresses'][0]['AddressMain'] ?? null,
            'number' => $info['ExtendedAddresses']['Addresses'][0]['Number'] ?? null,
            'complement' => $info['ExtendedAddresses']['Addresses'][0]['Complement'] ?? null,
            'neighborhood' => $info['ExtendedAddresses']['Addresses'][0]['Neighborhood'] ?? null,
            'city' => $info['ExtendedAddresses']['Addresses'][0]['City'] ?? null,
            'state' => $info['ExtendedAddresses']['Addresses'][0]['State'] ?? null,
            //phones_extended
            'ddd' => $info[''] ?? '11',
            'phone' => $info[''] ?? '999998888',
            //emails_extended
            'email' => $info['ExtendedEmails']['Emails'][0]['EmailAddress'] ?? 'contato@i9pay.com.br',
        ];
    }
}
