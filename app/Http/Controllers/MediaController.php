<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\MediaDataTable;
use App\Repositories\MediaRepository;
use App\Http\Requests\CreateMediaRequest;

class MediaController extends Controller
{
    public function index(Request $request, MediaDataTable $dataTable)
    {
        return $dataTable->render('media.index');
    } // end index

    public function store(CreateMediaRequest $request, MediaRepository $repo)
    {
        $data = $request->all();

        $media = $repo->addOrUpdateStub($data['imdbId'], $data['title'], $data['mediaType'], $data['posterUrl'], $data['releasedYear']);

        return response()->json([
            'success' => true,
            'url' => route('media.show', [$media->id]),
            'media_id' => $media->id,
        ]);
    } // end store
} // end MediaController
