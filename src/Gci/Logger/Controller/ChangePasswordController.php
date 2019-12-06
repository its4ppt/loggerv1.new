<?php

namespace Gci\Logger\Controller;

class ChangePasswordController {
    
    public function __construct($c) {
        $this -> container = $c;
    }
    
    public function indexActionGet($request, $response, $args) {
        
        // check if signined in
        $userId = $this->container->get('session')->get('userId');
        if(empty($userId)) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }

        $userFirstName = $this->container->get('session')->get('firstName');
        
        // Render index view
        return $this->container->get('renderer')->render($response, 'change-password/index.phtml', array(
            'currentPage' => 'change-password',
            'userFirstName' => $userFirstName
        ));
    }
    
    public function indexActionPost($request, $response, $args) {
        
        // check if signined in
        $userId = $this->container->get('session')->get('userId');
        if(empty($userId)) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }

        $args = array();
        $args['newPassword'] = $request->getParam('newPassword');
        $args['confirmNewPassword'] = $request->getParam('confirmNewPassword');
        
        $args['userFirstName'] = $this->container->get('session')->get('firstName');
        
        $error['error'] = true;
        if(empty(trim($args['newPassword']))) {
            $error = array(
                'error' => true,
                'message' => 'New password is required.'
            );
        } else if(strlen($args['newPassword']) <= 5) {
            $error = array(
                'error' => true,
                'message' => 'New password length must be more than 5 characters.'
            );
        } else if(empty(trim($args['confirmNewPassword']))) {
            $error = array(
                'error' => true,
                'message' => 'Confirm password is required.'
            );
        } else if(strlen($args['confirmNewPassword']) <= 5) {
            $error = array(
                'error' => true,
                'message' => 'Confirm password length must be more than 5 characters.'
            );
        } else if($args['newPassword'] !== $args['confirmNewPassword']) {
            $error = array(
                'error' => true,
                'message' => 'New Password and Confirm password must match.'
            );
        } else {
            $error = array(
                'error' => false
            );
        }
        
        if($error['error']) {
            $args['error'] = $error;
            return $this->container->get('renderer')->render($response, 'change-password/index.phtml', $args);
        }
        
        $pdo = $this->container->get('pdo');
        $statement = $pdo -> prepare(
                ' UPDATE `user` SET `password` = :newPassword WHERE id = :userId '
        );
        $statement -> bindValue('newPassword', md5($args['newPassword']));
        $statement -> bindValue('userId', $userId);
        $statement -> execute();
        
        $args['success'] = array(
            'success' => true,
            'message' => 'Successfully changed password.'
        );

        // Render index view
        return $this->container->get('renderer')->render($response, 'change-password/index.phtml', $args);
    }
}