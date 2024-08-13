<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;

class TestController extends Controller
{

    public function index()

    {

        $posts = Post::with(['carinfo', 'condition', 'docu', 'looks', 'fuel', 'techinfo'])->get();






        return Inertia::render('Test', ['posts' => $posts]);
    }
}
