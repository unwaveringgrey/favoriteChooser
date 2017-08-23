<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
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
    public function __construct(EndpointsRepository $endpoints)
    {
        $this->middleware('auth');

        $this->endpoints = $endpoints;
    }

    /**
     * Serves a page containing two possible favorites
     *
     * @return view
     */
    public function play()
    {
        $favorites = $this->generateFavoritePair();

        return view('chooser.play', ['favorites' => $favorites]);
    }

    /**
     * handles a submitted 
     *
     * @return null
     */
    public function submit()
    {
        $favorites = $this->generateFavoritePair();

        return view('chooser.play', ['favorites' => $favorites]);
    }

    /**
     * A helper function that generates a pair of favorites
     *
     * @return array
     */
    public function generateFavoritePair()
    {
        $first_favorite = $this->generateFavorite();

        $second_favorite = false;
        do{
            $second_favorite = $this->generateFavorite();
        } while($second_favorite == $first_favorite);

        return ["first_favorite"=>$first_favorite, "second_favorite"=>$second_favorite];

    }

    /**
     * A helper function that generates a favorite
     *
     * @return array
     */
    public function generateFavorite()
    {
        $random = rand(0,99);

        if($random < 69) {
            $favorite = $this->randomFavorite();
        } else {
            $favorite = $this->generateNewFavorite(3);
        }

        return $favorite;

    }


    /**
     * A helper function that searches through the connected APIs for a new favorite
     *
     * @return array
     */
    public function generateNewFavorite($max_attempts)
    {
        $attempts = 0;
        $favorite = false;

        while($max_attempts<$attempts && $this->favoriteExists($favorite) == false)
        {
            $endpoint = $this->randomEndpoint();

            $favorite = $endpoint->randomData();
        }

        return $favorite;

    }

    /**
     * A helper function that checks if a potential favorite already exists in the database
     *
     * @return bool
     */
    public function favoriteExists($favorite)
    {
        if($favorite == false) {
            return false;
        }
//implement this check
        return false;
    }

    /**
     * A helper function that pulls a random favorite from the database
     *
     * @return array
     */
    public function randomFavorite()
    {
//yeah, implement this too
    }

    /**
     * A helper function that generates a random enpoint from the DB
     *
     * @return array
     */
    public function randomEndpoint()
    {
        $endpoint = $this->endpoints->getRandomEndpoint();
        return $endpoint;
    }


}
