<?php
namespace App\Service;

use GuzzleHttp\Client;

class Provider2 implements TodoProviderInterface
{
    private $client;
    private $url;

    public function __construct(string $url)
    {
        $this->client = new Client();
        $this->url = $url;
    }

    public function fetchTasks(): array
    {
        $response = $this->client->get($this->url);
        return json_decode($response->getBody(), true);
    }
}
