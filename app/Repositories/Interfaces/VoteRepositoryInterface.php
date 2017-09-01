<?php

namespace App\Repositories\Interfaces;

interface VoteRepositoryInterface
{
    public function findBy($arg1, $arg2);

    public function findById($id);
}

?>