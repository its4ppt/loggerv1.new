<?php

namespace Gci\Logger\Controller;

class TestingController 
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
         $pdo = $this->container->get('pdo');
        $statement = null;
        $sql = ' SELECT DAYNAME(createdAt) AS x , COUNT(*) AS y FROM `request` GROUP BY DAYNAME(createdAt); ';
        $statement = $pdo -> prepare($sql);
              
        $statement -> execute();        
        $something = $statement -> fetchAll();
      
        echo json_encode($something);
                                    // Render index view
        return $this->container->get('renderer')->render($response, 'testing/testing.php', array()
                                                        );
    }
}