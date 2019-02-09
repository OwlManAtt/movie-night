<?php

namespace App\Services\IMDB;

use TopherTk\OmdbLaravel;

class OmdbLaravelApi implements ImdbApi
{
    public function findByQuery(array $params)
    {
        $data = $this->query(OmdbLaravelSearchQuery::class, $params);
        if ($data === null) {
            return $data;
        }

        return $data['Search'];
    } // end findByQuery

    public function findById(string $imdb_id)
    {
        return $this->query(OmdbLaravel\Entities\Query::class, [
            'imdb_id' => $imdb_id,
            'plot' => 'full',
        ]);
    } // end findById

    public function findByIdAndSeason(string $imdb_id, string $season)
    {
        return $this->query(OmdbLaravel\Entities\Query::class, [
            'imdb_id' => $imdb_id,
            'season' => $season,
            'plot' => 'full',
        ]);
    }

    private function query($query_entity, $params)
    {
        $client = new OmdbLaravel\Service\OmdbClient(new $query_entity($params));
        $data = $client->getMediaInformation();

        if (array_key_exists('Response', $data) === true && $data['Response'] === 'False') {
            return null;
        }

        return $data;
    }
} // end OmdbLaravelApi
