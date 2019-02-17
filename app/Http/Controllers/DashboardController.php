<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access');
    }

    public function index()
    {
        // @TODO when events are ready
        $up_next = Media::inRandomOrder()->first();
        $upcoming = Media::inRandomOrder()->limit(3)->get();

        return view('welcome', [
            'next' => $up_next,
            'future' => $upcoming,
        ]);
    } // end index
}
