<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;


$app->get('/', function() {
    require 'src/controller/login.php';
    $ctr = new login();

    require_once 'src/view/login.php';
    return $ctr->login();
});


$app->run();