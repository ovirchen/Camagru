<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/22/19
	 * Time: 10:39 AM
	 */

	namespace app;


	use controllers\UserController;

	class Web {

		private $mainPage = __DIR__."/../public/index.html";
		private $profilePage = __DIR__."/../public/profile.html";
		private $unknownPage = __DIR__."/../public/404.html";

		public function getView($request) {
			if (strpos( $request[0], "?") != false) $request = explode("?", $request[0]);
			switch ($request[0]) {
			case "":
				return $this->mainPage;
			case "verification":
				if (isset($_GET["code"])) (new UserController)->changeAccess($_GET["code"]);
				return $this->mainPage;
			case "profile":
				return $this->profilePage;
			default:
				return $this->unknownPage;
			}
		}
	}