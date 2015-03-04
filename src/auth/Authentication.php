<?php

namespace Pomodoro\Auth;

class Authentication {

    public function __construct() {
        //
    }


    public function loginOrRegister($user, $mail) {

        if($user !== 'Nicole' && $mail === 'nicole@example.com') {
            return false;
        }

        return true;

    }
}