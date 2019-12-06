<?php

namespace Gci\Logger\Controller;

class DashboardController
{

    private $container;

    public function __construct($c) {
        $this -> container = $c;
    }
    public function indexActionGet($request, $response, array $args) {

        // check if signined in
echo json_encode($result);
        $pdo = $this->container->get('pdo');
        $statement = null;
        $sql = ' SELECT DAYNAME(createdAt) AS x , COUNT(*) AS y FROM `request` GROUP BY DAYNAME(createdAt); ';
        $statement = $pdo -> prepare($sql);

        $statement -> execute();
        $result = $statement -> fetchAll();



        $statement = null;
        $sql = ' SELECT DATE(`createdAt`) AS aa ,COUNT(*) AS bb,
                    SUM(IF(`status`=200,1,0)) cc , SUM(IF(`status`>=400,1,0)) dd
                    FROM `request`
                    GROUP BY DATE(`createdAt`) DESC; ';
        $statement = $pdo -> prepare($sql);

        $statement -> execute();
        $result2 = $statement -> fetchAll();

       // echo json_encode($TestApi);
       // var_dump($TestApi);
          
      

        
       
        // Render index view
        return $this->container->get('renderer')->render($response, 'dashboard/index.phtml', array(
            'result' => $result,
            'result2' => $result2
          ));
    }
    }
