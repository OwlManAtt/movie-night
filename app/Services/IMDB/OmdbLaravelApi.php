<?php

namespace App\Services\IMDB;

use TopherTk\OmdbLaravel;

class OmdbLaravelApi implements ImdbApi
{
    public function findByQuery(array $params)
    {
        $client = new OmdbLaravel\Service\OmdbClient(new OmdbLaravelSearchQuery($params));
        $data = $client->getMediaInformation();

        if (array_key_exists('Response', $data) === true && $data['Response'] === 'False') {
            return [];
        }

        return $data['Search'];
    } // end findByQuery

    public function findById(string $imdb_id)
    {
        if (array_key_exists('plot', $params) === false) {
            $params['plot'] = 'full';
        }

        $client = new OmdbLaravel\Service\OmdbClient(new OmdbLaravel\Entities\Query($params));
        $data = $client->getMediaInformation();

        if (array_key_exists('Response', $data) === true && $data['Response'] === 'False') {
            return null;
        }

        return $result;
    } // end findById
} // end OmdbLaravelApi
