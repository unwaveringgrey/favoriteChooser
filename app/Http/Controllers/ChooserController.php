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
        if($favorites==false)
        {
            return Redirect::route('home')->with('error', 'Not enough Favorites exist to play. Add more Favorites.');
        }

        return view('chooser.play', ['favorites' => $favorites]);
    }

    /**
     * handles a submitted favorite
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
        if($pair == false)
        {
            return false;
        }

        $favorites = $this->loadEndpointPair($pair);

        return $favorites;
    }

    /**
     * A helper function that generates a pair of favorites. These are DB results, and still need to be loaded
     * They're generated randomly but with a greater chance of selection as they have more of the total net_votes
     *
     * @return array
     */
    public function chooseEndpointPair()
    {
        $probability = $this->endpoints->generateEndpointProbability();

        if($probability->count() < 2)
        {
            return false;
        }

        $first_favorite = $this->getRandomEndpoint($probability);

        do{
            $second_favorite = $this->getRandomEndpoint($probability);
        } while($second_favorite->id == $first_favorite->id);

        return ["first_favorite"=>$first_favorite, "second_favorite"=>$second_favorite];
    }

    /**
     * A function that loads a pair of endpoints given in an array
     * It prepares all of the data necessary to display the endpoints
     *
     * @return array
     */
    public function loadEndpointPair($pair)
    {
        $pair['first_id'] = $pair['first_favorite']->id;
        $pair['second_id'] = $pair['second_favorite']->id;
        $pair['first_votes'] = $pair['first_favorite']->net_votes;
        $pair['second_votes'] = $pair['second_favorite']->net_votes;
        $pair['first_image_url'] = $pair['first_favorite']->image_url;
        $pair['second_image_url'] = $pair['second_favorite']->image_url;
        $pair['first_favorite'] = $this->endpoints->loadEndpoint($pair['first_favorite']->url);
        $pair['second_favorite'] = $this->endpoints->loadEndpoint($pair['second_favorite']->url);

        return $pair;
    }

    /**
     * A helper function that loads a random endpoint from the DB
     *
     * @return object
     */
    public function loadRandomEndpoint()
    {
        $endpoint = $this->endpoints->loadRandomEndpoint();
        return $endpoint;
    }

    /**
     * A helper function that chooses a random endpoint from the list of probabilities
     *
     * @return object
     */
    public function getRandomEndpoint($probabilities)
    {
        $prob = mt_rand()/mt_getrandmax();
        $endpoint = false;
        foreach ($probabilities as $probability)
        {
            if($probability->probability > $prob)
            {
                $endpoint = $probability;
                break;
            } else {
                $prob = $prob - $probability->probability;
            }

        }

        //If $endpoint == false then something weird happened. Get a new random endpoint.
        //This is likely a result of 1 being the chosen random number, but the probability not quite adding up to 1
        //thanks to rounding errors
        if($endpoint == false) {
            $endpoint = $this->getRandomEndpoint($probabilities);
        }

        return $endpoint;
    }

}
