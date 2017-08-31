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
    protected $fillable = [];

    /**
     * Get the endpoint that this belongs to
     */
    public function endpoint()
    {
        return $this->belongsTo('App\Models\Endpoint');
    }

}
