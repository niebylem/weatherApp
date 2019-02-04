<?php

namespace App\Services;

use App\Services\Interfaces\RestInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class RestService implements RestInterface
{
    private $client;
    private $lastReponse;
    private $lastReponseJson;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function delete()
    {
        // TODO: Implement delete() method.
        return false;
    }

    public function get(string $requestString)
    {
        try {
            $this->lastReponse = $this->client->request('GET', $requestString, []);
        } catch (ConnectException $ex) {
            return false;
        }

        if ($this->lastReponse->getStatusCode() !== 200) {
            return false;
        }
        $this->lastReponseJson = json_decode($this->lastReponse->getBody(), true);

        return $this->lastReponseJson;
    }

    public function post()
    {
        // TODO: Implement post() method.
        return false;
    }

    public function put()
    {
        // TODO: Implement put() method.
        return false;
    }
}
