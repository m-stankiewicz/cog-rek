<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiDataService
{
    const API_URL = 'https://jsonplaceholder.typicode.com/';

    private HttpClientInterface $client;

    /**
     * ApiDataService constructor.
     *
     * @param HttpClientInterface $client The HTTP client used to make requests.
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Fetches users from the API.
     *
     * @return array An array of user data.
     */
    public function fetchUsers(): array
    {
        $response = $this->client->request('GET', self::API_URL.'users');
        return $response->toArray();
    }

    /**
     * Fetches posts from the API.
     *
     * @return array An array of post data.
     */
    public function fetchPosts(): array
    {
        $response = $this->client->request('GET', self::API_URL.'posts');
        return $response->toArray();
    }
}