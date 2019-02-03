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

        // @TODO shit, this API doesn't implement the omdb search method.
        // Hack on a wrapping array so this controller is giving the "right"
        // data and I'll write an omdb lib in a bit...
        $results = $api->findByQuery($data);

        if (array_key_exists('Response', $results) === true && $results['Response'] === "False") {
            return response()->json([
                'status' => false,
                'error' => null,
                'data' => [
                    'imdb' => [],
                ],
            ])->setStatusCode(204);
        }

        return response()->json([
            'status' => true,
            'error' => null,
            'data' => [
                'imdb' => [$results],
            ]
        ]);
    } // end __invoke

} // end ImdbSearchController
