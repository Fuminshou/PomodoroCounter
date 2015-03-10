<?php

namespace Pomodoro\Auth;

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

        return $this->insertNewUserInDB($user, $mail);  //registrazione ok
    }


    public function checkIfEmailExistInDB($mail) {

        $stmt = $this->conn->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindParam(':email', $mail);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_NUM);

        if($result[0] > 0) return true;

        return false;
    }


    public function checkIfUsernameMatchEmail($user, $mail) {

        if($mail === 'nicole@example.com' && $user === 'Nicole') return true;

        return false;
    }


    public function insertNewUserInDB($user, $mail) {

        if($user && $mail) return true;

        return false;
    }
}