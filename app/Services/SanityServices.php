<?php

namespace App\Services;

use Sanity\Client as SanityClient;

class SanityServices
{
    protected $client;

    public function __construct()
    {
        $this->client = new SanityClient([
            'projectId' => 'your-project-id',
            'dataset' => 'your-dataset',
            'token' => 'your-token', // Optional, if authentication is required
        ]);
    }
}
