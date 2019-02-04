<?php

namespace App\Services\IMDB;

use Faker\Generator as Faker;

/**
 * Mocked IMDB API implementation for feature testing.
 */
class MockImdbApi implements ImdbApi
{
    private $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    } // end Faker

    public function findByQuery(array $params)
    {
        if ($params['search'] === 'None') {
            return [];
        }

        return [
            [
                'Poster' => $this->faker->imageUrl(400, 400, 'cats'),
                'Title' => $this->faker->movieTitle,
                'Type' => $this->faker->randomElement(['movie', 'series']),
                'Year' => $this->faker->year(),
                'imdbID' => $this->faker->imdbId,
            ],
        ];
    } // end findByQuery

    public function findById(string $imdb_id)
    {
        throw new \Exception('Not Yet Implemented');
    } // end findById
} // end MockImdbApi
