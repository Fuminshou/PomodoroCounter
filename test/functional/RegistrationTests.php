<?php

require '../../vendor/autoload.php';

use Silex\WebTestCase;

class RegistrationTests extends WebTestCase
{
    public function createApplication()
    {
        return require '../../index.php';
    }

    public function testAnonimousUserRegistration ()
    {
        $this->assertEquals('3', 3);

    }
}