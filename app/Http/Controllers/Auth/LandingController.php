<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user() === null) {
            return view('landing.guest');
        }

        // Authorized users should not be here, they shuld be in the app!
        if ($request->user()->app_access_enabled === true) {
            return redirect('/');
        }

        return response()->view('landing.not-authorized', [], 403);
    }
}
