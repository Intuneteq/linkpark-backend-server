<?php

namespace App\Services;

use Sanity\Client as SanityClient;

class SanityService
{
    protected $client;

    public function __construct()
    {
        $this->client = new SanityClient([
            'projectId' => env('SANITY_PROJECT_ID'),
            'dataset' => env('SANITY_DATA_SET'),
            'apiVersion' => env('SANITY_API_VERSION'),
            'token' => env('SANITY_API_TOKEN')
        ]);
    }

    public function fetchData(string $query)
    {
        var_dump('SANITY_PROJECT_ID');
        return $this->client->fetch($query);
    }
}
