<?php

namespace App\Services\IMDB;

use Faker\Generator as Faker;

/**
 * Mocked IMDB API implementation for feature testing.
 */
class MockImdbApi implements ImdbApi
{
    private $faker;
    private $type;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    } // end Faker

    public function setTestType($type)
    {
        $this->type = $type;
    } // end

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
        $type = $this->type;
        if ($type === null) {
            $type = $faker->randomElement(['movie', 'series', 'episode']);
        }

        return [
            'Title' => $this->faker->movieTitle,
            'Year' => $this->faker->year,
            'Rated' => 'N/A',
            'Released' => '26 Dec 1990',
            'Season' => '1',
            'Episode' => '1',
            'Runtime' => '60 min',
            'Plot' => $this->faker->paragraph,
            'Poster' => $this->faker->imageUrl(400, 400, 'cats'),
            'imdbRating' =>  $this->faker->randomFloat(1, 1, 10),
            'imdbID' => $this->faker->imdbId,
            'Type' => $type,
            'totalSeasons' => '1',
        ];
    } // end findById

    public function findByIdAndSeason(string $imdb_id, string $season)
    {
        return [
            'Title' => $this->faker->movieTitle,
            'Season' => '1',
            'totalSeasons' => '1',
            'Episodes' => [
                [
                    'Title' => $this->faker->movieTitle,
                    'Released' => $this->faker->date,
                    'Episode' => '1',
                    'imdbRating' => $this->faker->randomFloat(1, 1, 10),
                    'imdbID' => $this->faker->imdbId,
                ],
            ],
        ];
    }
} // end MockImdbApi
