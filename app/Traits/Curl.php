<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

trait Curl {

    public function client(): Client
    {
        return new Client();
    }

    public function post(string $endpoint, array $headers = [], array $body = []): string
    {
        $options = [
            'headers' => $headers,
            'body' => json_encode($body),
            'http_errors' => false,
        ];

        $response = $this->client()->post($endpoint, $options);
        return $response->getBody()->getContents();
    }

    public function get(string $endpoint, array $headers = []): string
    {
        $response = $this->client()->get($endpoint, $headers);
        return $response->getBody()->getContents();
    }
}
