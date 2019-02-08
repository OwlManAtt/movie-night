<?php

namespace App\Services\IMDB;

interface ImdbApi
{
    public function findByQuery(array $params);

    public function findById(string $imdb_id);
} // end ImdbApiInterface
