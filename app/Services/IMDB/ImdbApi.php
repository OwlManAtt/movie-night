<?php

namespace App\Services\IMDB;

interface ImdbApi
{
    public function findByQuery(array $params);

    public function findById(string $imdb_id);

    public function findByIdAndSeason(string $imdb_id, string $season);
} // end ImdbApiInterface
