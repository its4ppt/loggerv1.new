<?php

use Slim\App;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);
    
    $app = new \Slim\App;
    $app->add(new \Slim\Middleware\Session([
        'name' => 'session',
        'autorefresh' => true,
        'lifetime' => '1 hour'
    ]));
};
