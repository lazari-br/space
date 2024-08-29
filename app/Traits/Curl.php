<?php

namespace App\Traits;

use App\Models\CurlLog;
use App\Repositories\CurlLogRepository;
use GuzzleHttp\Client;

trait Curl {

    private function client(): Client
    {
        return new Client();
    }

    protected function post(string $endpoint, array $headers = [], array $body = []): string
    {
        $options = [
            'headers' => $headers,
            'body' => json_encode($body),
            'http_errors' => false,
        ];

        $log = $this->logCurl($endpoint, 'POST', $headers, $body);
        $response = $this->client()->post($endpoint, $options);
        $responseAsArray = $response->getBody()->getContents();

        $httpCode = $response->getStatusCode();
        $this->updateLog($log, $httpCode, $responseAsArray);

        if ($httpCode !== 200) {
            throw new \Exception($responseAsArray);
        }

        return $responseAsArray;
    }

    protected function get(string $endpoint, array $headers = []): string
    {
        $options = [
            'headers' => $headers,
            'http_errors' => false,
        ];

        $log = $this->logCurl($endpoint, 'GET', $headers);
        $response = $this->client()->get($endpoint, $options);
        $responseAsArray = $response->getBody()->getContents();

        $httpCode = $response->getStatusCode();
        $this->updateLog($log, $httpCode, $responseAsArray);

        if ($httpCode !== 200) {
            throw new \Exception($responseAsArray);
        }
        return $responseAsArray;
    }

    private function logCurl(string $url, string $method, mixed $headers = [], mixed $body = []): CurlLog
    {
        return $this->getCurlLogRepository()->store([
            'url' => $url,
            'method' => $method,
            'headers' => $headers,
            'body' => $body,
        ]);
    }

    private function updateLog(CurlLog $log, int $httpCode, mixed $response): void
    {
        $this->getCurlLogRepository()->update($log->id, [
            'http_code' => $httpCode,
            'response' => $response
        ]);
    }

    private function getCurlLogRepository(): CurlLogRepository
    {
        return  app(CurlLogRepository::class);
    }
}
