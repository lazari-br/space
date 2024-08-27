<?php

namespace App\Traits;

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

        $request = $this->client()->post($endpoint, $options);
        $response = $request->getBody()->getContents();

        if ($request->getStatusCode() !== 200) {
            throw new \Exception($response);
        }
        return $response;
    }

    protected function get(string $endpoint, array $headers = []): string
    {
        $response = $this->client()->get($endpoint, $headers);
        return $response->getBody()->getContents();
    }
}
