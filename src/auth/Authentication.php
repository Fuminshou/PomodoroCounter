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

        $dataExist = $this->checkIfEmailExistInDB($mail);

        if(!empty($dataExist)) {
            if($dataExist['name'] !== $user) return false;   //wrong username for this email

            return true;    //data are correct, proceed to login user
        }

        return $this->insertNewUserInDB($user, $mail);  //data doesn't exist, proceed with a new user registration
    }


    public function checkIfEmailExistInDB($mail) {

        $stmt = $this->conn->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindParam(':email', $mail);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($result) return $result;

        return false;
    }


    public function insertNewUserInDB($user, $mail) {
        try {
            $sql = "INSERT INTO User VALUES (NULL, '".$user."','".$mail."')";
            $this->conn->exec($sql);

            return true;
        }
        catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();

            return false;
        }
    }
}