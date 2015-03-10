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
            $app['session']->set('user', array('nome' => $username));

            return $app->redirect('/projects', 302);
        }

        return $app->redirect('/');
    }

    public function projectsAction(Application $app) {

        return $app['twig']->render('/projects.php', array('user' => $app['session']->get('user')));
    }
}