<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class GuestController extends Controller
{
    public function reception()
    {
        return Inertia::render('Guest/Reception');
    }
}
