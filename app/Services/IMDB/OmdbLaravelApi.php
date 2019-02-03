<?php

namespace App\Services\IMDB;

use TopherTk\OmdbLaravel;

class OmdbLaravelApi implements ImdbApi
{
    public function findByQuery(array $params)
    {
        $client = new OmdbLaravel\Service\OmdbClient($this->makeQuery($params));

        return $client->getMediaInformation();
    } // end findByQuery

    public function findById(string $imdb_id)
    {
        $client = new OmdbLaravel\Service\OmdbClient($this->makeQuery(['imdb_id']));

        return $client->getMediaInformation();
    } // end findById

    private function makeQuery(array $params)
    {
        if (array_key_exists('plot', $params) === false) {
            $params['plot'] = 'full';
        }

        return new OmdbLaravel\Entities\Query($params);
    } // end makeQuery

} // end OmdbLaravelApi
