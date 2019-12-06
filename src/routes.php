<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    
    $container = $app->getContainer();

    // Signin
    $app->get('/', 'SigninController:indexActionGet');
    $app->post('/', 'SigninController:indexActionPost');
    
    // Signup
    $app->get('/signup', 'SignupController:indexActionGet');
    $app->post('/signup', 'SignupController:indexActionPost');

    // Dashboard
    $app->get('/dashboard', 'DashboardController:indexActionGet');
    $app->get('/dashboard/super', 'DashboardController:indexActionGet');
    
    // request page
    $app->get('/request', 'RequestController:listActionGet');
    $app->get('/request/view/{requestId}', 'RequestController:viewActionGet');
   
    
    // Change Password
    $app->get('/change-password', 'ChangePasswordController:indexActionGet');
    $app->post('/change-password', 'ChangePasswordController:indexActionPost');
    
    // ping
    $app->get('/ping', 'PingController:indexActionGet');
    
    
    // Logout
    $app->get('/logout', 'LogoutController:indexActionGet');
    
    //search
    $app->get('/search', 'SearchController:indexActionGet');
    $app->post('/search', 'SearchController:indexActionPost');
    
    //date
    $app->get('/date', 'DateController:indexActionGet');
    $app->post('/date', 'DateController:indexActionPost');
    
     //testing
    $app->get('/testing', 'TestingController:indexActionGet');
    $app->post('/testing', 'TestingController:indexActionPost');
};