<?php 

namespace model;

class SessionModel {
    private static $welcome = "SessionModel::welcome";
    private static $register = "SessionModel::register";
    private static $isLoggedIn = "SessionModel::isLoggedin";
    private static $username = "SessionModel::username";

    public function setWelcomeSession () {
        $_SESSION[self::$welcome] = true;
    }

    public function setUserSession ($user) {
        $_SESSION[self::$isLoggedIn] = true;
        $_SESSION[self::$username] = $user;
    }

    public function setRegisterSession () {
        $_SESSION[self::$register] = true;
    }

    public function unsetUserSession () {
        unset($_SESSION[self::$isLoggedIn]);
        unset($_SESSION[self::$username]);
    }

    public function unsetWelcomeSession () {
        unset($_SESSION[self::$welcome]);
    }

    public function unsetRegisterSession () {
        unset($_SESSION[self::$register]);
    }

    public function getUserName () {
        if (isset($_SESSION[self::$username])) {
            return $_SESSION[self::$username];
        }
    }

    public function checkReloadSession () : bool {
       if(isset($_SESSION[self::$isLoggedIn]) && isset($_SESSION[self::$welcome])) {
           return true;
       }
       return false;
    }

    public function checkLoggedinSession() : bool {
        if (isset($_SESSION[self::$isLoggedIn])) {
            return true;
        }
        return false;
    }

    public function checkWelcomeSession() : bool {
        if (isset($_SESSION[self::$welcome])) {
            return true;
        }
        return false;
    }

    public function checkRegisterSession() : bool {
        if (isset($_SESSION[self::$register])) {
            return true;
        }
        return false;
    }
}