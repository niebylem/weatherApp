<?php declare(strict_types = 1);

namespace App\Services;

use App\Services\Interfaces\RestInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;

class RestService implements RestInterface
{
    private $client;
    private $lastResponse;
    private $lastResponseJson;

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
            $this->lastResponse = $this->client->request('GET', $requestString, []);
        } catch (ConnectException $ex) {
            return false;
        } catch (GuzzleException $e) {
            return false;
        }

        if ($this->lastResponse->getStatusCode() !== 200) {
            return false;
        }
        $this->lastResponseJson = json_decode($this->lastResponse->getBody()->getContents(), true);

        return $this->lastResponseJson;
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
