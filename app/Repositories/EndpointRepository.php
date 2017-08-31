<?php

namespace App\Repositories;

use App\Models\Endpoint;
use App\Repositories\Interfaces\EndpointRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class EndpointRepository implements EndpointRepositoryInterface
{

    protected $endpoint;

    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function findBy($arg1, $arg2)
    {
        return $this->endpoint->where($arg1, $arg2)->get();
    }

    public function findById($id)
    {
        return $this->endpoint->find($id);
    }

    public function getRandomEndpoint()
    {
        $endpoints = $this->endpoint->all();

        $endpoint = $endpoints->random();

        return $endpoint;
    }

    public function loadRandomEndpoint()
    {
        $endpoint = $this->getRandomEndpoint();
        $json = $this->loadEndpoint($endpoint->url);
        return $json;
    }

    public function loadEndpoint($url)
    {
        $client = new Client();
        $request = new Request('GET', $url);
        $response = $client->send($request, ['timeout' => 8]);
        $json = \GuzzleHttp\json_decode($response->getBody()->getContents());
        return $json;
    }

}

?>