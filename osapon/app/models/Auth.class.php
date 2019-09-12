<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/18/19
	 * Time: 12:32 AM
	 */
	namespace app;

	class Auth {

		public function __construct() {
			if (!session_id()) {
				session_start();
			}
		}

		public function getAuthorized() {
			return $_SESSION["user"];
		}

		public function setAuthorized($user) {
			$_SESSION["user"] = $user;
		}
	}