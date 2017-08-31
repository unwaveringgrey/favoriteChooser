<?php

namespace App\Http\Controllers\EndpointsAPI;

use App\Http\Controllers\Controller;
use App\Repositories\EndpointRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class EndpointController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Endpoints Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles serving, creating, updating, and deleting endpoints
    |
    */
    protected $endpoints;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EndpointRepository $endpoints)
    {
        $this->endpoints = $endpoints;
    }

    /**
     * Query and return a list of the endpoints
     * @return collection
     */
    public function getEndpoints()
    {
        $endpointList = $this->endpoints->all();

        return $endpointList;
    }

    /**
     * Return a particular endpoint
     * @return endpoint
     */
    public function getEndpoint($id)
    {
        $endpoint = $this->endpoints->findById($id);

        return $endpoint;
    }

    /**
     * Delete an endpoint
     * @param int $id
     */
    public function deleteEndpoint($id)
    {
        $endpoint = $this->endpoints->findById($id);

        $endpoint->delete();
    }

    /**
     * Returns a JSON representation of all endpoints
     * @return JSON
     */
    public function getEndpointsJSON()
    {
        $endpoints = $this->getEndpoints();

        return $endpoints->toJson();
    }

    /**
     * Returns a JSON representation of a specific endpoint
     * @param int $id
     * @return JSON
     */
    public function getEndpointJSON($id)
    {
        $endpoint = $this->getEndpoint($id);

        return $endpoint->toJson();
    }



}
