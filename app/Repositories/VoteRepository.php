<?php

namespace App\Repositories;

use App\Models\Vote;
use App\Repositories\Interfaces\VoteRepositoryInterface;

class VoteRepository implements VoteRepositoryInterface
{

    protected $vote;

    public function __construct(Vote $vote)
    {
        $this->vote = $vote;
    }

    public function newVote()
    {
        return new Vote();
    }

    public function findBy($arg1, $arg2)
    {
        return $this->vote->where($arg1, $arg2)->get();
    }

    public function findById($id)
    {
        return $this->vote->find($id);
    }
}

?>