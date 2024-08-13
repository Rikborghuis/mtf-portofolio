<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImageController extends Controller
{
    public function getImage(Request $request)
    {
        $imgNr = $request->input('nr');

        $imagequery = Image::with('post');


        if ($imgNr) {
            $imagequery->where('nr', $imgNr);
        }

        $images = $imagequery->get();

        return response()->json(['images' => $images]);
    }
}
