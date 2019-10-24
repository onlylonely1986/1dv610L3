<?php

namespace view;

require_once("Messages.php");

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $message = '';
	private $valueName = '';
	private $valuePwd = '';

	public function tryToLogin() : bool {
		if (isset($_POST[self::$login])) {
			$this->valueName = $_POST[self::$name];
			if (empty($_POST[self::$name]) || (empty($_POST[self::$name]) && empty($_POST[self::$password]))) {
				$this->message .= Messages::$missName;
				return false;
			} else if (isset($_POST[self::$name]) && empty($_POST[self::$password])) {
				$this->message .= Messages::$missPass;
				return false;
			}
			return true;
		}
		return false;
	}

	public function registerNewMessage(string $user) {
		$this->message = Messages::$registerNew;
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
			$this->message = Messages::$welcomeCookie;
			return true;
		}
		return false;
	}

	public function loggedIn() {
		$this->message =  Messages::$welcome;
		$this->valueName = $_POST[self::$name];
		if(isset($_POST[self::$login]) && isset($_POST[self::$keep])) {
			$this->saveCookie();
		}
	}

	public function setLoggedinState($user) {
		self::$name = $user;
	  }

	private function saveCookie() {
		setcookie(self::$cookieName, self::$cookiePassword, time()+3600);
	}

	public function loggedInReload() {
		$this->message = '';
	}

	public function loggedOut($sessionLoggedIn) : bool {
		if (isset($_POST[self::$logout]) && $sessionLoggedIn) {
			setcookie(self::$cookieName, "", time()-3600);
			$this->message = Messages::$bye;
			return true;
		}
		return false;
	}

	public function wrongNameOrPass() {
		$this->message = Messages::$wrongNameOrPass;
	}

    /**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function echoHTML($sessionLoggedin) {
		if ($sessionLoggedin) {
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
		return '
			<form method="POST" > 
				<fieldset>
					<legend>Login - enter username and password</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>
					
					<label for="' . self::$name . '">Username:</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->valueName . '" />

					<label for="' . self::$password . '">Passwword:</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="' . $this->valuePwd . '" />

					<label for="' . self::$keep . '">Keep me logged in:</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					<input type="submit" name="' . self::$login . '" value="login " />
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
				<p id="' . self::$messageId . '">' . $this->message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
}
