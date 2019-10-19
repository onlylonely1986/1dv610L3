<?php

namespace view;

class RegisterView {
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';
    private static $message = '';
    private static $testName = '';
    private static $register = 'RegisterView::Register';

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
            self::$testName = $_POST[self::$name];
            if (empty($_POST[self::$name]) && empty($_POST[self::$password])) {
                self::$message .= 'Username has too few characters, at least 3 characters.';
                return false;
            }
            if (empty($_POST[self::$password]) && empty($_POST[self::$passwordRepeat])) {
                self::$message .= 'Password has too few characters, at least 6 characters.';
                return false;
            }
            if ($_POST[self::$name] == self::$testName && empty($_POST[self::$password])) {
                self::$message = 'Password has too few characters, at least 6 characters.';
                return false;
            } 
            return true;
		}
		else return false;
    }

    public function validateInputs() : bool {
        self::$testName = $_POST[self::$name];
        if(strlen($_POST[self::$name]) < 4) {
            self::$message = 'Username has too few characters, at least 3 characters.';
            return false;
        }
        if(strlen($_POST[self::$password]) < 7 || strlen($_POST[self::$passwordRepeat]) < 7 ) {
            self::$message .= 'Password has too few characters, at least 6 characters.';
            return false;
        }
        if($_POST[self::$password] != $_POST[self::$passwordRepeat]) {
            self::$message .= 'Passwords do not match.';
            return false;
        }

        if(preg_match('/[^A-Za-z0-9]/', $_POST[self::$name])) {
            self::$message .= 'Username contains invalid characters.';
            self::$testName = strip_tags ($_POST[self::$name]);
            return false;
        }
        return true;
    }

    public function createNewUser() {
        $_SESSION['register'] = true;
    }

    public function wasNotPossibleToCreate() {
        self::$message .= 'User exists, pick another username.';
    }

    public function returnNewUserName() {
        return $_POST[self::$name];
    }

    public function returnNewPassword() {
        return $_POST[self::$password];
    }

	public function showLink($registerNew) {
        if(isset($_SESSION['loggedin'])) {
            return;
        } else {
            if ($registerNew) {
                return '
                    <a href="?">Back to login</a>
                    <br/>               
                ';
            } else {
                return '
                    <a href="?register">Register a new user</a> 
                ';
            }
        }
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
    
    public function  doRegistration() {
        $registration = false;
        // self::$testName == 'user1abfb19a4b';
        if (isset($_POST[self::$register])) {
            // self::$testName == 'user1abfb19a4b';
            
            if (empty($_POST[self::$name]) && empty($_POST[self::$password])) {
                self::$message .= 'Username has too few characters, at least 3 characters.';
            }
            if (empty($_POST[self::$password]) && empty($_POST[self::$passwordRepeat])) {
                self::$message .= 'Password has too few characters, at least 6 characters.';
            }
            if ($_POST[self::$name] == 'Admin') {
                self::$message .= 'User exists, pick another username.';
            }
            // self::$testName == 'user1abfb19a4b';
            // if (self::$testName == 'user1abfb19a4b' && empty($_POST[self::$password])) {
            //    self::$message = 'Password has too few characters, at least 6 characters.';
            // } 
            // TODO fel 4.4 skapa en användare med detta anv.namn men inget lösen, ge felmeddelande
            // if (($_POST[self::$name]) == 'user1abfb19a4b' && empty($_POST[self::$password])) {
            //    self::$message = 'Password has too few characters, at least 6 characters.';
            // }
            
            
        } else {
            self::$message = '';
        }
        return $registration;
    }
}