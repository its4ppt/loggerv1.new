<?php

namespace Gci\Logger\Controller;

class SigninController {
    
    public function __construct($c) {
        $this->container = $c;
    }
    
    public function indexActionGet($request, $response, $args) {
        //check if sign in
        $userId = $this->container->get('session')->get('userId');
        if(!empty($userId)) {
            return $response->withStatus(302)->withHeader('Location', '/dashboard');
        }

        // Render index view
        return $this->container->get('renderer')->render($response, 'signin/index.phtml', $args);
    }
    
    public function indexActionPost($request, $response, $args) {
        
        $args = array();
        $args['email'] = $request->getParam('email');
        $args['password'] = $request->getParam('password');
        
        $pdo = $this->container->get('pdo');
        $statement = $pdo -> prepare(
                ' SELECT id, password, firstName, lastName, roleCode '.
                ' FROM `user` WHERE `email` = :email'
        );
        $statement -> bindValue('email', $args['email']);
        $statement -> execute();
        $rowUserInfo = $statement -> fetch();
        if(empty($rowUserInfo)) {
            $args['error'] = true;
            $args['message'] = 'Invalid credentials.';
        } else {
            if($rowUserInfo['password'] == md5($args['password'])) {
                $this->container->get('session')->set('userId', $rowUserInfo['id']);
                $this->container->get('session')->set('firstName', $rowUserInfo['firstName']);
                $this->container->get('session')->set('lastName', $rowUserInfo['lastName']);
                $this->container->get('session')->set('roleCode', $rowUserInfo['roleCode']);
                return $response->withStatus(302)->withHeader('Location', '/dashboard');
            } else {
                $args['error'] = true;
                $args['message'] = 'Invalid credentials.';
            }
        }

        // Render index view
        return $this->container->get('renderer')->render($response, 'signin/index.phtml', $args);
    }
}