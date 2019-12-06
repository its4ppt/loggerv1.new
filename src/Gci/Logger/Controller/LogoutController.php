<?php

namespace Gci\Logger\Controller;

class LogoutController {
    
    public function __construct($c) {
        $this -> container = $c;
    }
    
    public function indexActionGet($request, $response, $args) {
        
        // check if signined in
        $userId = $this->container->get('session')->get('userId');
        if(empty($userId)) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }

        // reset session
        $this->container->get('session')->set('userId', null);
        
        // Render index view
        return $response->withStatus(302)->withHeader('Location', '/');
    }
}