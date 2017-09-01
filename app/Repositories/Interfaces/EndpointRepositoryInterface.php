<?php

  namespace App\Repositories\Interfaces;

  interface EndpointRepositoryInterface
  {
      public function findBy($arg1, $arg2);

      public function findById($id);

      public function getRandomEndpoint();

      public function loadRandomEndpoint();

      public function loadEndpoint($url);

      public function generateEndpointProbability();
  }

  ?>