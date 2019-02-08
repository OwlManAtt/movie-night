<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IMDB\ImdbApi;

class ImdbSearchController extends Controller
{
    public function __invoke(Request $request, ImdbApi $api)
    {
        $data = $request->validate([
            'title' => 'required|string',
        ]);

        $search_results = $api->findByQuery(['search' => $data['title']]);

        return response()->json($this->typeaheadJson($search_results));
    } // end __invoke

    private function typeaheadJson($data = [])
    {
        return [
            'status' => (count($data) > 0),
            'error' => null,
            'data' => [
                'imdb' => $data,
            ],
        ];
    } // end typeaheadJson
} // end ImdbSearchController
