<?php

return [
    'app_id' => env('324890660707681'),
    'app_secret' => env('7a7db09305dc870a5d9a5df41f031af0'),
    'redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
    'graph_version' => env('FACEBOOK_GRAPH_VERSION', 'v22.0'),
    'beta_mode' => env('FACEBOOK_ENABLE_BETA', false),
];
