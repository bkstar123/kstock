<?php
/**
 * Base service
 *
 * @author: tuanha
 * @date: 27-July-2022
 */
namespace App\Services;

use GuzzleHttp\Client;

class Base
{
    /**
     * @var GuzzleHttp\Client $client
     */
    protected $client;

    /**
     * Create instance
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('settings.api_endpoint'),
            'headers' => [
                'Authorization' => 'Bearer ' . config('settings.api_token'),
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}
