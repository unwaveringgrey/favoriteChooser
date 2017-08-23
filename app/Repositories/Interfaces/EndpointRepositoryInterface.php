<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function findBy($arg1, $arg2);

    public function findById($id);

}

?>