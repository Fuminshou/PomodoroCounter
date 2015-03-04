<?php

use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../src/View'
));

$app->get('/',          'Pomodoro\Controller\AuthenticationController::indexAction');
$app->post('/login',    'Pomodoro\Controller\AuthenticationController::loginAction');
$app->get('/projects',  'Pomodoro\Controller\AuthenticationController::projectsAction');

return $app;