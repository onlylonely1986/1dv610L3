<?php

namespace view;

require_once("Messages.php");

class RegisterView {
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';
    private static $message = '';
    private static $testName = '';
    private static $register = 'RegisterView::Register';
    private static $minCharPass = 7;
    private static $minCharName = 4;

    public function wantsToRegister() : bool {
        if (isset($_GET['register'])) {
            return true;
        }
        return false;
    }

    public function hitButton() :bool {
        if (isset($_POST[self::$register])) {
            return true;
        }
        return false;
    }

    public function isAllFieldsFilled() : bool {
        if (isset($_POST[self::$register])) {
            if (empty($_POST[self::$passwordRepeat])) {
                self::$message .= Messages::$toShortPass;
            }
            if ((empty($_POST[self::$name]) && empty($_POST[self::$password])) || empty($_POST[self::$name])) {
                self::$message .= Messages::$toShortName;
                return false;
            }
            if (empty($_POST[self::$password]) || empty($_POST[self::$passwordRepeat])) {
                self::$message .= Messages::$toShortPass;
                return false;
            }
            if ($_POST[self::$name] == self::$testName && empty($_POST[self::$password])) {
                self::$message = Messages::$toShortPass;
                return false;
            } 
            return true;
		}
		else return false;
    }

    public function validateInputs() : bool {
        self::$testName = $_POST[self::$name];
        if(strlen($_POST[self::$name]) < self::$minCharName) {
            self::$message = Messages::$toShortName;
            return false;
        }
        if(strlen($_POST[self::$password]) < self::$minCharPass || strlen($_POST[self::$passwordRepeat]) < self::$minCharPass ) {
            self::$message .= Messages::$toShortPass;
            return false;
        }
        if($_POST[self::$password] != $_POST[self::$passwordRepeat]) {
            self::$message .= Messages::$passNotMatch;
            return false;
        }

        if(preg_match('/[^\w -!?@#$%^&*()]/', $_POST[self::$name])) {
            self::$message .= Messages::$invalidChars;
            self::$testName = strip_tags ($_POST[self::$name]);
            return false;
        }
        return true;
    }

    public function wasNotPossibleToCreate() {
        self::$message .= Messages::$userExists;
    }

    public function returnNewUserName() {
        return $_POST[self::$name];
    }

    public function returnNewPassword() {
        return $_POST[self::$password];
    }
    
    /** 
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
    public function echoHTML() {
		return '
			<form action="?register" enctype="multipart/form-data" method="POST" > 
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id="' . self::$messageId. '">' . self::$message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
                    <input type="text" id="' . self::$name . '" name="' . self::$name . '" size="20" value="' . self::$testName . '" />
                    <br/>

                    <label for="' . self::$password . '">Password :</label>
                    <input type="password" id="' . self::$password . '" name="' . self::$password . '" size="20" value="" />
                    <br/>

                    <label for="' . self::$passwordRepeat . '">Repeat password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" size="20" value="" />
                    <br/>

					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
    }
}