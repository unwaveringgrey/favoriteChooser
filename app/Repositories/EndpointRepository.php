<?php

namespace App\Repositories;

use App\Models\Endpoint;
use App\Repositories\Interfaces\EndpointRepositoryInterface;

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

    public function getRandomEndpoint($id)
    {
        $endpoints = $this->endpoint->all();

        $endpoint = $endpoints->random();

        return $endpoint;
    }


    public function newEndpoint()
    {
        return new Endpoint();
    }

}

?>