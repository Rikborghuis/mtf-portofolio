<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;



class overonsController extends Controller
{
    public function index()
    {
        $fb = new \JoelButcher\Facebook\Facebook([
            'app_id' => '{app-id}',
            'app_secret' => '7a7db09305dc870a5d9a5df41f031af0',
            'default_graph_version' => 'v20.0',
        ]);

        try {
            $response = $fb->get('347759191750648/posts?fields=full_picture,message&access_token=EAAEnfIBsHWEBO4PSUoFvR7xNah6zZC5dZBZCFBAhXvmDe3p7DjR0EbJnHluW8fWbb7eak1EgvAumJM7c52zH4cuFo4ydhMXjFIXsTUbuJe0KvZCxGCZC4LzsqkTFh69odTgBosKjEZBZBkrHoCZBFiJOhIZBhtKnbUKzZBfw6pSnbxXbJq7W8enXFDlv4smHiaJaw5bt7stSyZBcYDWwdIj3sae3mh4ll90U96CP34TdIm4');
        } catch (\Facebook\Exception\ResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exception\SDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }


        $posts = $response->getGraphEdge();

        $postsArray = [];
        foreach ($posts as $post) {
            $postArray = $post->asArray();
            $postsArray[] = [
                'message' => $postArray['message'] ?? '',
                'full_picture' => $postArray['full_picture'] ?? ''
            ];
        }


        //log::info('dit zijn de params ', $user);

        return Inertia::render('Overons', ['posts' => $postsArray]);
    }
}
