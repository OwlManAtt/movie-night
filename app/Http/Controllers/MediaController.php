<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\MediaDataTable;

class MediaController extends Controller
{
    public function index(MediaDataTable $dataTable)
    {
        return $dataTable->render('media.index');
    } // end index

} // end MediaController
