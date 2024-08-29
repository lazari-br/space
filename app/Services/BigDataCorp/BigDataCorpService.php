<?php

namespace App\Services\BigDataCorp;

use App\Traits\Curl;
use Illuminate\Support\Facades\Cache;

class BigDataCorpService
{
    use Curl;

    public function getData(string $cpf): array
    {
        $data = $this->makeRequest($cpf);
        $translatedData = $this->translateData($cpf, $data['Result'][0]);

        return empty($translatedData) ? [] : Cache::remember('bigDataCorp_cpf:' . $cpf, 36000, fn() => $translatedData); //cache de 10 dias
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
            'Datasets' => 'basic_data{name,gender,birthDate,motherName,fatherName,birthCountry},phones_extended{phones},occupation_data{professions,totalIncome},addresses_extended{Addresses},emails_extended',
            'q' => "doc{{$cpf}}"
        ]);

        return json_decode($response, true);
    }

    private function translateData(string $cpf, array $info): array
    {
        return [
            'document' => $cpf,
            //basic_data
            'name' => !empty($info['BasicData']['Name']) ? $info['BasicData']['Name'] : null,
            'gender' => !empty($info['BasicData']['Gender']) ? $info['BasicData']['Gender'] : null,
            'birthday' => !empty($info['BasicData']['BirthDate']) ? $info['BasicData']['BirthDate'] : null,
            'mother_name' => !empty($info['BasicData']['MotherName']) ? $info['BasicData']['MotherName'] : null,
            'father_name' => !empty($info['BasicData']['FatherName']) ? $info['BasicData']['FatherName'] : null,
            'birth_local' => !empty($info['BasicData']['BirthCountry']) ? $info['BasicData']['BirthCountry'] : null,
            //occupation_data
            'occupation' => !empty($info['ProfessionData']['Professions'][0]['Level']) ? $info['ProfessionData']['Professions'][0]['Level'] : null,
            'income' => !empty($info['ProfessionData']['TotalIncome']) ? $info['ProfessionData']['TotalIncome'] : null,
            //addresses_extended
            'zipcode' => !empty($info['ExtendedAddresses']['Addresses'][0]['ZipCode']) ? $info['ExtendedAddresses']['Addresses'][0]['ZipCode'] : null,
            'street' => $info['ExtendedAddresses']['Addresses'][0]['AddressMain'] ?? null,
            'number' => !empty($info['ExtendedAddresses']['Addresses'][0]['Number']) ? $info['ExtendedAddresses']['Addresses'][0]['Number'] : null,
            'complement' => !empty($info['ExtendedAddresses']['Addresses'][0]['Complement']) ? $info['ExtendedAddresses']['Addresses'][0]['Complement'] : null,
            'neighborhood' => !empty($info['ExtendedAddresses']['Addresses'][0]['Neighborhood']) ? $info['ExtendedAddresses']['Addresses'][0]['Neighborhood'] : null,
            'city' => !empty($info['ExtendedAddresses']['Addresses'][0]['City']) ? $info['ExtendedAddresses']['Addresses'][0]['City'] : null,
            'state' => !empty($info['ExtendedAddresses']['Addresses'][0]['State']) ? $info['ExtendedAddresses']['Addresses'][0]['State'] : null,
            //phones_extended
            'ddd' => !empty($info['ExtendedPhones']['Phones']['AreaCode']) ? $info['ExtendedPhones']['Phones']['AreaCode'] : '11',
            'phone' => !empty($info['ExtendedPhones']['Phones']['Number']) ? $info['ExtendedPhones']['Phones']['Number'] : '999998888',
            //emails_extended
            'email' => !empty($info['ExtendedEmails']['Emails'][0]['EmailAddress']) ? $info['ExtendedEmails']['Emails'][0]['EmailAddress'] : 'contato@i9pay.com.br',
        ];
    }
}
