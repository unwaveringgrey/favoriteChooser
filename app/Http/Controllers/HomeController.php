<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use App\Repositories\EndpointRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Serves the home page
     *
     * @return view
     */
    public function home()
    {
        $top_favorites = $this->generateTopFavorites(6);

        return view('chooser.home', ['top_favorites' => $top_favorites]);
    }

    /**
     * Serves the home page, minus the top favorites
     *
     * @return view
     */
    public function simple_home()
    {
        $top_favorites = array();

        return view('chooser.home', ['top_favorites' => $top_favorites]);
    }


    /**
     * Serves a page containing a single random favorite
     *
     * @return view
     */
    public function random()
    {
        $favorite = $this->endpoints->getRandomEndpoint();
        $net_votes = $favorite->vote()->net_votes();
        $favorite = $this->endpoints->loadEndpoint($favorite->url);

        return view('chooser.random', ['favorite' => $favorite, 'net_votes' => $net_votes]);
    }

    /**
     * A helper function that gets and preps the X most popular endpoints
     *
     * @return array
     */
    public function generateTopFavorites($x)
    {
        $top = $this->getTopEndpoints($x);

        $top_favorites = $this->loadTopEndpoints($top);

        return $top_favorites;
    }

    /**
     * A function that loads the data from the top endpoints
     *
     * @return array
     */
    public function loadTopEndpoints($top)
    {
        $loaded_top = array();
        foreach ($top as $current)
        {
            $loaded_top[] = array('data'=>$this->endpoints->loadEndpoint($current->url), 'net_votes'=>$current->net_votes, 'image_url'=>$current->image_url);
        }
        return $loaded_top;
    }

    /**
     * A function that gets the top voted endpoints
     *
     * @return Collection
     */
    public function getTopEndpoints($x)
    {

        $endpoints = DB::table('endpoints')
            ->join('votes', 'endpoints.id', '=', 'votes.endpoint_id')
            ->select('endpoints.*', DB::raw("(SELECT votes.positive_votes - votes.negative_votes) as net_votes"))
            ->orderBy('net_votes', 'DESC')
            ->limit($x)
            ->get();

        return $endpoints;
    }

}
