<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMediaRequest extends FormRequest
{
    public function all($keys = NULL)
    {
        $data = parent::all($keys);

        // Year can be "1992-" instead of an int, and all I want is the int.
        if (array_key_exists('releasedYear', $data) === true) {
            $data['releasedYear'] = (int)preg_replace('/[^0-9]*/', '', $data['releasedYear']);
        }

        return $data;
    } // end all

    public function rules()
    {
        return [
            'title' => 'required|string',
            'imdbId' => 'required|string|unique:media,imdb_id',
            'mediaType' => 'required|string|in:movie,series',
            'releasedYear' => 'nullable|integer',
            'posterUrl' => 'nullable|string|url',
        ];
    } // end rules

} // end CreateMediaRequest
