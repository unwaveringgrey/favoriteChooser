<?php

namespace App\Repositories;

use App\Models\Endpoint;
use App\Repositories\Interfaces\EndpointRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class EndpointRepository implements EndpointRepositoryInterface
{

    protected $endpoint;

    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function newEndpoint()
    {
        return new Endpoint();
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
        $endpoint = $this->endpoint->all()->random(1)->first();

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

    public function generateEndpointProbability()
    {


        $endpoints = DB::table('endpoints')
            ->join('votes', 'endpoints.id', '=', 'votes.endpoint_id')
            ->select('endpoints.*', DB::raw("(SELECT votes.positive_votes - votes.negative_votes) as net_votes")
                , DB::raw("(SELECT Case When net_votes > 0 then net_votes+1 else 1 end  ) as probability"))
            ->orderBy('probability', 'DESC')
            ->get();
        $count = 0;
        foreach ($endpoints as $endpoint) {
            $count = $count+$endpoint->probability;
        }
        foreach ($endpoints as $endpoint) {
            $endpoint->probability = $endpoint->probability/$count;
        }

        return $endpoints;

    }

}

?>