<?php

namespace Pomodoro\Auth;
use \PDO;

class Authentication {

    public $conn;

    public function __construct() {

        $dsn = 'mysql:dbname=PomodoroCounter;host=localhost';
        $user = 'root';
        $password = '123456ciao';

        try {
            $this->conn = new \PDO($dsn, $user, $password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            $this->conn = NULL;
        }

        return $this->conn;
    }


    public function loginOrRegister($user, $mail) {

        $emailExist = $this->checkIfEmailExistInDB($mail);

        if($emailExist) {
            $usernameMatch = $this->checkIfUsernameMatchEmail($user, $mail);

            if(!$usernameMatch) {
                return false;   //email esistente ma username sbagliato
            }

            return true;    //login ok
        }

        return $this->insertNewUserInDB($user, $mail);  //login o registrazione ok
    }


    public function checkIfEmailExistInDB($mail) {

        if($mail === 'nicole@example.com') return true;

        return false;
    }


    public function insertNewUserInDB($user, $mail) {

        return true;
    }


    public function checkIfUsernameMatchEmail($user, $mail) {

        if($mail === 'nicole@example.com' && $user === 'Nicole') return true;

        return false;
    }
}