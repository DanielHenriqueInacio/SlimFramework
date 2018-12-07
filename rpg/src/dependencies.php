<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
//Database
$container['db'] = function($c) {
    $params = $c->get('settings')['db'];
    $conn = new PDO ("mysql:host={$params['host']};dbname={$params['db']}", $params['user'], $params['pass']);
    $conn->exec("set names utf8");
    return $conn;
};
$container['flash'] = function($c) {
    return new \Plasticbrain\FlashMessages\FlashMessages();
    
};