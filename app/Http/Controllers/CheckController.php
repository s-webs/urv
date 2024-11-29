<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CheckController extends Controller
{
    public function check()
    {
        $user = Auth::user();

        return Inertia::render('Guest/Check');
    }
}
