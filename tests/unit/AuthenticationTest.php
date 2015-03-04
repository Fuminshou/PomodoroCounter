<?php

use Pomodoro\Auth\Authentication;

class AuthenticationTest extends \PHPUnit_Framework_TestCase
{
    public function testAnonymousUserRegistrationShouldSuccess()
    {
        $authentication = new Authentication();

        $username = 'Nicolas';
        $email = 'nicolas@example.com';

        $result = $authentication->loginOrRegister($username, $email);

        $this->assertEquals(true, $result);
    }

    public function testRegisteredUserLoginShouldSuccess()
    {
        $authentication = new Authentication();

        $username = 'Nicole';
        $email = 'nicole@example.com';

        $result = $authentication->loginOrRegister($username, $email);

        $this->assertEquals(true, $result);
    }

    public function testLoginOrRegistrationShouldFail()
    {
        $authentication = new Authentication();

        $username = 'Nicolas';
        $email = 'nicole@example.com';

        $result = $authentication->loginOrRegister($username, $email);

        $this->assertEquals(false, $result);
    }
}