<?php

namespace Gci\Logger\Controller;

class PingController 
{
    public function __construct($c) {
        $this -> container = $c;
    }
    
    public function indexActionGet($request, $response ) 
    {
       
                // check if signined in
        $userId = $this->container->get('session')->get('userId');
        if(empty($userId)) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }
        // Render index view
        return $this->container->get('renderer')->render($response, 'ping/index.phtml', array()
                                                        );
    }
}