<?php

namespace App\Services;

use App\Services\Interfaces\RestInterface;
use GuzzleHttp\Client;

class RestService implements RestInterface
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function get()
    {
        return 'test weather from rest service with client:' . get_class($this->client);
    }

    public function post()
    {
        // TODO: Implement post() method.
    }

    public function put()
    {
        // TODO: Implement put() method.
    }
}
