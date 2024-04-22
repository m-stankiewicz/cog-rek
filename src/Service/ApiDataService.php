<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiDataService
{
    const API_URL = 'https://jsonplaceholder.typicode.com/';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchUsers(): array
    {
        $response = $this->client->request('GET', self::API_URL.'users');
        return $response->toArray();
    }

    public function fetchPosts(): array
    {
        $response = $this->client->request('GET', self::API_URL.'posts');
        return $response->toArray();
    }
}