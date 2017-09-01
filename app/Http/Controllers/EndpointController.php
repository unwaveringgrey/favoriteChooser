<?php

namespace App\Http\Controllers;

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
     * This serves the "add_endpoint" page
     * @return view
     */
    public function add()
    {
        return view('endpoint.add', []);
    }

    /**
     * Handles saving the endpoint
     * @return null
     */
    public function submit(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:endpoints|max:255',
            'url' => 'required|unique:endpoints|max:255',
            'image_url' => 'max:255'
        ]);

        $endpoint = $this->endpoints->newEndpoint();
        $endpoint->fill($request->all());
        $endpoint->slug = str_slug($endpoint->title);
        $endpoint->save();

        return redirect()->route('home');
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
