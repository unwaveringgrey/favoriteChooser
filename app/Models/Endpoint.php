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
     * Get the ratings for the endpoint.
     */
    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }
}
