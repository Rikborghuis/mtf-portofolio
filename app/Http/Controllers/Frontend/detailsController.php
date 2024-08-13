<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class detailsController extends Controller
{
    public function index()
    {

        return Inertia::render('Details', []);
    }

    public function show(Request $request)
    {
        $id = $request->input('id');



        $postsQuery = Post::with(['carinfo', 'condition', 'docu', 'looks', 'images',  'techinfo']);

        if ($id) {
            $postsQuery->where('id', $id);
        }

        $post = $postsQuery->get();

        Log::info('idtest: ' . $post);
        return response()->json($post);
    }
}
