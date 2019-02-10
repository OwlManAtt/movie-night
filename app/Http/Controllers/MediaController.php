<?php

namespace App\Http\Controllers;

use App\Events;
use App\Models\Media;
use Illuminate\Http\Request;
use App\DataTables\MediaDataTable;
use App\Repositories\MediaRepository;
use App\Http\Requests\CreateMediaRequest;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access');
    }

    public function index(Request $request, MediaDataTable $dataTable)
    {
        return $dataTable->render('media.index');
    } // end index

    public function store(CreateMediaRequest $request, MediaRepository $repo)
    {
        $data = $request->all();

        $media = $repo->addOrUpdateStub($data['imdbId'], $data['title'], $data['mediaType'], $data['posterUrl'], $data['releasedYear']);
        event(new Events\MediaChanged($media));

        return response()->json([
            'success' => true,
            'url' => route('media.show', [$media->id]),
            'media_id' => $media->id,
        ]);
    } // end store

    public function show($id)
    {
        $media = Media::with('content')->findOrFail($id);

        return view('media.show', [
            'type' => $media->content_type,
            'media' => $media,
        ]);
    }
} // end MediaController
