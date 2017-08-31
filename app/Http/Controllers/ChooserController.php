<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use App\Repositories\EndpointRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class ChooserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Chooser Controller
    |--------------------------------------------------------------------------
    |
    | This serves the favoritesChooser pages
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
     * Serves a page containing two possible favorites
     *
     * @return view
     */
    public function play()
    {
        $favorites = $this->generateEndpointPair();

        return view('chooser.play', ['favorites' => $favorites]);
    }

    /**
     * Serves a page containing a single random favorite
     *
     * @return view
     */
    public function random()
    {
        $favorite = $this->randomEndpoint();

        return view('chooser.random', ['favorite' => $favorite]);
    }

    /**
     * handles a submitted 
     *
     * @return null
     */
    public function submit(Request $request)
    {
        $lesser_favorite = ($request->selected_favorite ==$request->first_favorite?$request->second_favorite:$request->first_favorite);
        $this->endpoints->findById($request->selected_favorite)->incrementVotes();
        $this->endpoints->findById($lesser_favorite)->decrementVotes();

        return redirect()->route('favorite_select');
    }

    /**
     * A helper function that generates a pair of favorites. These are DB results, and still need to be loaded
     *
     * @return array
     */
    public function generateEndpointPair()
    {
        $pair = $this->chooseEndpointPair();

        $favorites = $this->loadEndpointPair($pair);

        return $favorites;
    }

    /**
     * A helper function that generates a pair of favorites. These are DB results, and still need to be loaded
     *
     * @return array
     */
    public function chooseEndpointPair()
    {
        $first_favorite = $this->getRandomEndpoint();

        do{
            $second_favorite = $this->getRandomEndpoint();
        } while($second_favorite->id == $first_favorite->id);

        return ["first_favorite"=>$first_favorite, "second_favorite"=>$second_favorite];
    }

    /**
     * A function that loads a pair of endpoints given in an array
     *
     * @return array
     */
    public function loadEndpointPair($pair)
    {
        //["first_favorite"=>$first_favorite, "second_favorite"=>$second_favorite]
        $pair['first_id'] = $pair['first_favorite']->id;
        $pair['second_id'] = $pair['second_favorite']->id;
        $pair['first_favorite'] = $this->endpoints->loadEndpoint($pair['first_favorite']->url);
        $pair['second_favorite'] = $this->endpoints->loadEndpoint($pair['second_favorite']->url);

        return $pair;
    }

    /**
     * A helper function that generates a random endpoint from the DB
     *
     * @return array
     */
    public function loadRandomEndpoint()
    {
        $endpoint = $this->endpoints->loadRandomEndpoint();
        return $endpoint;
    }

    /**
     * A helper function that generates a random endpoint from the DB
     *
     * @return array
     */
    public function getRandomEndpoint()
    {
        $endpoint = $this->endpoints->getRandomEndpoint();
        return $endpoint;
    }

}
