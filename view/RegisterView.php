<?php

namespace view;

class RegisterView {
	private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';
    private static $message = '';
    private static $register = 'RegisterView::Register';

    public function wantsToRegister() : bool {
        if (isset($_GET['register'])) {
            return true;
        }
        return false;
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
                    <input type="text" id="' . self::$name . '" name="' . self::$name . '" size="20" value="user1abfb19a4b" />
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