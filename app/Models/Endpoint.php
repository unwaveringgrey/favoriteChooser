<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'url'
    ];

    /**
     * Get the votes for the endpoint.
     */
    public function vote()
    {
        return $this->hasOne('App\Models\Vote')->first();
    }

    /**
     * Increment the votes for this endpoint.
     */
    public function incrementVotes()
    {
        $vote = $this->vote();
        $vote->positive_votes = $vote->positive_votes+1;
        $vote->save();
    }

    /**
     * Decrement the votes for this endpoint.
     */
    public function decrementVotes()
    {
        $vote = $this->vote();
        $vote->negative_votes = $vote->negative_votes+1;
        $vote->save();

    }

}
