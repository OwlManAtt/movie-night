<?php

namespace App\Services\IMDB;

use TopherTk\OmdbLaravel\Entities\Query;

class OmdbLaravelSearchQuery extends Query
{
    private $parameters = [
        'search'        => 's',
        'media_type'    => 'type',
        'release_year'  => 'y',
        'page'          => 'page',
    ];

    /**
     * @var string
     */
    private $queryString;

    /**
     * @var array
     */
    private $userParams;

    public function __construct(array $userParams)
    {
        $this->userParams = $userParams;
        $this->mapParameters();
    }

    private function mapParameters()
    {
        if (empty($this->userParams)) {
            throw InvalidQueryParameters::emptyQueryParameters(count($this->userParams));
        }
        $i = 0;
        foreach ($this->userParams as $key => $value) {
            $i++;
            if (array_key_exists($key, $this->parameters) && !empty($value)) {
                $this->queryString .= $this->parameters[$key].'='.$value . $this->isElementLastInArray($i);
            }
        }
    }

    /**
     * @param int $arrayPosValue
     * @return string
     */
    private function isElementLastInArray(int $arrayPosValue) : string
    {
        return $arrayPosValue == count($this->userParams) ? '' : '&';
    }

    /**
     * @return string
     */
    public function getMappedParameters() : string
    {
        return $this->queryString;
    }

}
