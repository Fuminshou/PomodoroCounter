<?php

use Pomodoro\Auth\Authentication;
use Pomodoro\Test\MyWebAndDBTestCase;

class AuthenticationTest extends MyWebAndDBTestCase
{
    public $auth;
    public $user;
    public $mail;


    public function setUpDatas($user, $mail) {

        $this->auth = new Authentication();
        $this->user = $user;
        $this->mail = $mail;

        $this->getConnection()->createDataSet();
    }


    public function testCheckIfEmailExistInDBReturnTrue() {

        $this->setUpDatas('Nicole', 'nicole@example.com');

        $result = $this->auth->checkIfEmailExistInDB($this->mail);
        $this->assertEquals(true, $result);
    }


    public function testCheckIfEmailExistInDBReturnFalse() {

        $this->setUpDatas('Nicolas', 'nicolas@example.com');

        $result = $this->auth->checkIfEmailExistInDB($this->mail);
        $this->assertEquals(false, $result);
    }


    public function testCheckIfUsernameMatchEmailReturnTrue() {

        $this->setUpDatas('Nicole', 'nicole@example.com');

        $result = $this->auth->checkIfUsernameMatchEmail($this->user, $this->mail);
        $this->assertEquals(true, $result);
    }


    public function testCheckIfUsernameMatchEmailReturnFalse() {

        $this->setUpDatas('Nicolas', 'nicole@example.com');

        $result = $this->auth->checkIfUsernameMatchEmail($this->user, $this->mail);
        $this->assertEquals(false, $result);
    }


    public function testInsertNewUserInDBReturnTrue() {

        $this->setUpDatas('Nicolas', 'nicolas@example.com');

        $result = $this->auth->insertNewUserInDB($this->user, $this->mail);
        $this->assertEquals(true, $result);
    }
}