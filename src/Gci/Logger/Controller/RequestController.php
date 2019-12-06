<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Gci\Logger\Controller;

class RequestController {
    
    public function __construct($c) {
        $this->container = $c;
    }
    
    public function listActionGet($request, $response, array $args) {
        
        // check if signined in
        $userId = $this->container->get('session')->get('userId');
        if(empty($userId)) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }
        
        $page = abs(intval($request -> getParam('page')));
        $page = empty($page) ? 1 : $page;
        $limit = 100;
        $start = $page === 1 ? 0 : $page * $limit - $limit;
        
        $pdo = $this->container->get('pdo');
        $statement = null;
        $statement = $pdo -> prepare(' SELECT * FROM `request` ORDER BY id DESC LIMIT ' . $start . ',' . $limit . ';');
        $statement -> execute();
        $requests = $statement -> fetchAll();
        $statement = null;
        
        // total
        $statement = $pdo -> prepare(' SELECT COUNT(0) AS total FROM `request` ');
        $statement -> execute();
        $total = $statement -> fetch();
        $total = intval($total['total']);
        $statement = null;
        
        // Render index view
        return $this->container->get('renderer')->render($response, 'request/index.phtml', array(
            'requests' => $requests,
            'page' => $page,
            'total' => $total,
            'limit' => $limit));
    }
    
    public function viewActionGet($request, $response, $args) {
        
        // check if signined in
        $userId = $this->container->get('session')->get('userId');
        if(empty($userId)) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }
        
        $requestId = abs(intval($args['requestId']));
        $error['error'] = true;
        if(false) {
            $error = array(
                'error' => true,
                'message' => 'Request id is required.'
            );
        } else {
            $error = array(
                'error' => false
            );
        }
        
        if($error['error']) {
            $this -> container -> get('flash') -> addMessage('error', $error['message']);
            return $response->withStatus(302)->withHeader('Location', '/request');
        }
        
        $args['userFirstName'] = $this->container->get('session')->get('firstName');
        
        $pdo = $this->container->get('pdo');
        $sqlQuery = 'SELECT r1.id AS requestId, r1.requestUuid, r1.source, '.
                ' r1.status, r1.createdAt, r1.requestUrl, r1.requestMethod, '.
                ' r1.params '.
                ' FROM `request` r1 '.
                ' WHERE r1.`id` = :id ';
        $statement = $pdo -> prepare($sqlQuery);
        $statement -> bindValue('id', $requestId);
        $statement -> execute();
        $rowUserInfo = $statement -> fetch();
        $args['request'] = $rowUserInfo;
        $requestId = intval($rowUserInfo['requestId']);
        if(empty($requestId)) {
            $this -> container -> get('flash') -> addMessage('error', 'Request is not valid.');
            return $response->withStatus(302)->withHeader('Location', '/request');
        }
        
        $statement = $pdo -> prepare('SELECT * FROM `log` l1 WHERE l1.request_id = :requestId ORDER BY l1.id ASC ');
        $statement -> bindValue('requestId', $requestId);
        $statement -> execute();
        $logs = $statement -> fetchAll();
        $args['logs'] = $logs;

        // Render index view
        return $this->container->get('renderer')->render($response, 'request/view.phtml', $args);
        // Render index email
        return $this->container->get('renderer')->render($response, 'request/email.php', $args);
    }
       
}