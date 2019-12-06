<?php

namespace Gci\Logger\Controller;

class SignupController {
    
    public function __construct($c) {
        $this->container = $c;
    }
    
    public function indexActionGet($request, $response, $args) {
        
        $userId = $this->container->get('session')->get('userId');
        if(!empty($userId)) {
            $userRoleCode = $this->container->get('session')->get('roleCode');
            return $response->withStatus(302)->withHeader('Location', '/dashboard');
        }

        // Render index view
        return $this->container->get('renderer')->render($response, 'signup/index.phtml', $args);
    }
    
    public function indexActionPost($request, $response, $args) {

        $args = array();
        $args['firstName'] = $request->getParam('firstName');
        $args['email'] = $request->getParam('email');
        $args['password'] = $request->getParam('password');
        $args['confirmPassword'] = $request->getParam('confirmPassword');
        
        $pdo = $this->container->get('pdo');
        $statement = $pdo -> prepare(
                ' SELECT id AS userId FROM `user` WHERE `email` = :email'
        );
        $statement -> bindValue('email', $args['email']);
        $statement -> execute();
        $rowUserInfo = $statement -> fetch();
        $userId = intval($rowUserInfo['userId']);
        if(!empty($userId)) {
            $args['error'] = array('error' => true, 'message' => 'User already exists.');
            return $this->container->get('renderer')->render($response, 'signup/index.phtml', $args);
        }
        
        $error['error'] = true;
        if(empty($args['firstName'])) {
            $error = array(
                'error' => true,
                'message' => 'First name is required.'
            );
        } else if(empty($args['email'])) {
            $error = array(
                'error' => true,
                'message' => 'Email is required.'
            );
        } else if(empty($args['password'])) {
            $error = array(
                'error' => true,
                'message' => 'Password is required.'
            );
        } else if(strlen($args['password']) <= 5) {
            $error = array(
                'error' => true,
                'message' => 'Password length should be more than 6 characters.'
            );
        } else {
            $error = array(
                'error' => false
            );
        }
        
        if($error['error']) {
            $args['error'] = $error;
            return $this->container->get('renderer')->render($response, 'signup/index.phtml', $args);
        }
        
        $statement = $pdo -> prepare(
                ' INSERT INTO `user` (`email`, `password`, `createdAt`, '.
                ' `firstName`, `lastName`, `roleCode`, `isApproved`) '.
                ' VALUES (:email, :password, NOW(),'.
                ' :firstName, NULL, "admin", TRUE);'
        );

        $statement -> bindValue('email', $args['email']);
        $statement -> bindValue('password', md5($args['password']));
        $statement -> bindValue('firstName', $args['firstName']);
        $statement -> execute();
        $userId = $pdo -> lastInsertId();

        if(empty($userId)) {
            $args['error'] = array('error' => true, 'message' => 'Cannot signup.');
        } else {
            $args['error'] = array('error' => false, 'message' => 'Signup successful. Pending approval.');
        }

        // Render index view
        return $this->container->get('renderer')->render($response, 'signup/index.phtml', $args);
    }
}