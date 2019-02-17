<?php

namespace App\Http\Controllers;

use App\DataTables\EpisodeDataTable;
use App\DataTables\Scopes\SeriesScope;

class EpisodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access');
    }


    public function index(EpisodeDataTable $datatable, $series_media_id)
    {
        $datatable->addScope(new SeriesScope($series_media_id));

        return $datatable->ajax();
    }
}
