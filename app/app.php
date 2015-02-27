<?php

use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/', function() {

    ob_start();
    require __DIR__ . '/../src/view/login.php';
    $response = ob_get_contents();
    ob_end_clean();

    return new Response($response);
});


$app->post('/login', function() {


    ob_start();
    require __DIR__ . '/../src/controller/login.php';
    $ctr = new login();
    $ctr_value = $ctr->login();
    require __DIR__ . '/../src/view/login.php';
    $response = ob_get_contents();
    ob_end_clean();

    return new Response($response);
});

return $app;