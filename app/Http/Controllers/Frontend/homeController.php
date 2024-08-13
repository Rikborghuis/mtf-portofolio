<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Post;

class homeController extends Controller
{
    public function index()
    {


        $nr = 1;

        $postsQuery = Post::with(['carinfo', 'condition', 'docu', 'looks', 'techinfo', 'images' => function ($query) use ($nr) {
            $query->where('nr', $nr);
        }]);

        $posts = $postsQuery->orderBy('id', 'desc')->take(8)->get();

        $posts->each(function ($post) use ($nr) {
            $post->images = $post->images->filter(function ($image) use ($nr) {
                return $image->nr == $nr;
            });
        });


        return Inertia::render('Show', [
            'posts' => $posts,
        ]);
    }
}
