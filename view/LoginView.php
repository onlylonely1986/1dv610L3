<?php

namespace view;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $message = '';
	private $valueName = '';
	private $valuePwd = '';


	public function tryToLogin() : bool {
		if (isset($_POST[self::$login])) {
			$this->valueName = $_POST[self::$name];
			if (empty($_POST[self::$name]) || (empty($_POST[self::$name]) && empty($_POST[self::$password]))) {
				// TODO obs string dependecies!
				self::$message .= 'Username is missing';
				return false;
			} else if (isset($_POST[self::$name]) && empty($_POST[self::$password])) {
				self::$message .= 'Password is missing';
				return false;
			}
			return true;
		}
		return false;
	}

	public function setMessage(string $user) {
		self::$message = "Registered new user.";
		$this->valueName = $user;
	}

	public function bothFieldsFilled() : bool {
		if (isset($_POST[self::$login])) {
			if (isset($_POST[self::$name]) && isset($_POST[self::$password])) {
				return true;
			}
		}
		else return false;
	}

	public function getUsername() : string {
		if (isset($_POST[self::$name]) && isset($_POST[self::$password])) {
			return $_POST[self::$name];
		}
	}

	public function getPassword() : string {
		if (isset($_POST[self::$name]) && isset($_POST[self::$password])) {
			return $_POST[self::$password];
		}
	}

	public function loginWithCookies($isSessionWelcome) : bool {
		if(isset($_COOKIE[self::$cookieName]) && !$isSessionWelcome) {
			self::$message = "Welcome back with cookie";
			return true;
		}
		return false;
	}

	public function loggedIn() {
		self::$message = 'Welcome';
		$this->valueName = $_POST[self::$name];
		if(isset($_POST[self::$login]) && isset($_POST[self::$keep])) {
			$this->saveCookie();
		}
	}

	private function saveCookie() {
		self::$cookieName = $this->valueName;
		setcookie(self::$cookieName, self::$cookiePassword, time()+3600);
	}

	public function loggedInReload() {
		self::$message = '';
	}

	public function loggedOut($sessionLoggedIn) : bool {
		if (isset($_POST[self::$logout]) && $sessionLoggedIn) {
			self::$message = 'Bye bye!';
			return true;
		}
		return false;
	}

	public function wrongNameOrPass() {
		self::$message = 'Wrong name or password';
	}

    /**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function echoHTML($sessionLoggedIn) {
		if ($sessionLoggedIn) {
			$response = $this->generateLogoutButtonHTML();
		} else {
			$response = $this->generateLoginFormHTML();
		}
        return $response;
	}

    /** 
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML() {
        $message = "";
		return '
			<form method="POST" > 
				<fieldset>
					<legend>Logga in - ange användarnamn och lösenord</legend>
					<p id="' . self::$messageId . '">' . self::$message . '</p>
					
					<label for="' . self::$name . '">Användarnamn:</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->valueName . '" />

					<label for="' . self::$password . '">Lösenord:</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="' . $this->valuePwd . '" />

					<label for="' . self::$keep . '">Håll mig inloggad :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					<input type="submit" name="' . self::$login . '" value="Logga in " />
				</fieldset>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML() {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . self::$message .'</p>
				<input type="submit" name="' . self::$logout . '" value="Logga ut"/>
			</form>
		';
	}
}
