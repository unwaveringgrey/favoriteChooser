<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['positive_votes', 'negative_votes'];

    /**
     * Get the endpoint that this belongs to
     */
    public function endpoint()
    {
        return $this->belongsTo('App\Models\Endpoint');
    }

    /**
     * Returns positive_votes minus negative_votes
     */
    public function net_votes()
    {
        return $this->positive_votes - $this->negative_votes;
    }

}
