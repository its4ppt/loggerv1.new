<?php


use Slim\App;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\DBAL\Types\Type;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };
    
    // pdo
    $container['pdo'] = function ($c) {
        $settings = $c->get('settings')['app_database'];
        $pdo = new \PDO($settings['connection'], $settings['username'], $settings['password'], $settings['init']);
        return $pdo;
    };
    
    // entity manager
    $container[EntityManager::class] = function ($c) {
        
        $settings = $c->get('settings')['doctrine'];
        
        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['dev_mode']
        );

        $config->setMetadataDriverImpl(
            new AnnotationDriver(
                new AnnotationReader,
                $settings['metadata_dirs']
            )
        );

        $config->setMetadataCacheImpl(
            new FilesystemCache(
                $settings['cache_dir']
            )
        );
        
        Type::addType(\Gci\Logger\Datatype\Timestamp::TIMESTAMP, 'Gci\Logger\Datatype\Timestamp');

        return EntityManager::create(
            $settings['connection'],
            $config
        );
    };
    
    // Register globally to app
    $container['session'] = function ($c) {
        return new \SlimSession\Helper;
    };
    
    $container['SigninController'] = function ($c) {
        return new \Gci\Logger\Controller\SigninController($c);
    };
    
    $container['DashboardController'] = function ($c) {
        return new \Gci\Logger\Controller\DashboardController($c);
    };
    
    $container['ChangePasswordController'] = function ($c) {
        return new \Gci\Logger\Controller\ChangePasswordController($c);
    };
    
    $container['LogoutController'] = function ($c) {
        return new \Gci\Logger\Controller\LogoutController($c);
    };
    
    $container['SignupController'] = function ($c) {
        return new \Gci\Logger\Controller\SignupController($c);
    };
    
    $container['RequestController'] = function ($c) {
        return new \Gci\Logger\Controller\RequestController($c);
    };
    
    $container['flash'] = function($c) {
        return new \Slim\Flash\Messages();
    };
    $container['PingController'] = function ($c) {
        return new \Gci\Logger\Controller\PingController($c);
    };
    $container['SearchController'] = function ($c) {
        return new \Gci\Logger\Controller\SearchController($c);
    };
    
    $container['DateController'] = function ($c) {
        return new \Gci\Logger\Controller\DateController($c);
    };
    
    $container['TestingController'] = function ($c) {
        return new \Gci\Logger\Controller\TestingController($c);
    };
    
    return $container;
};