<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class uitgebreidzoekenController extends Controller
{
    public function index()
    {
        return Inertia::render('Uitgebreid-zoeken', []);
    }
}
