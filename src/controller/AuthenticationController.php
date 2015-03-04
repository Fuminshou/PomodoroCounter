<?php

namespace Pomodoro\Controller;

use Pomodoro\Auth\Authentication;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class AuthenticationController
{
    public function __construct() {
        //
    }

    public function indexAction(Application $app) {

        return $app['twig']->render('/authentication.php');
    }

    public function loginAction(Request $request, Application $app) {

        $authentication = new Authentication();
        $username = $request->get('nome');
        $email = $request->get('email');

        $result = $authentication->loginOrRegister($username, $email);

        if($result) {
            return $app->redirect('/web/projects');
        }

        return $app->redirect('/web/');

    }

    public function projectsAction(Request $request, Application $app) {

        return $app['twig']->render('/projects.php', array('username' => $request->get('nome')));
    }
}