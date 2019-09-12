<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/22/19
	 * Time: 12:02 PM
	 */

	namespace controllers;
	use app\Auth;
	use app\models\Favourite;
	use app\Photo;

	require __DIR__."/../models/Auth.class.php";


	class AuthController extends Auth {

		public function __construct() {
			parent::__construct();
		}
		public function isAuthorize($user) {
			if (!$user) return null;
			$photoModel = new Photo();
			$favouriteModel = new Favourite();
			$photos = $photoModel->getAllPhotosByUserID($user["id"]);
			$favourite = $favouriteModel->getAllPhotosByUserID($user["id"]);
			$saved = [];
			foreach ($favourite as $item) {
				$saved[] = $photoModel->getPhoto($item["photo_id"]);
			}
			return ["data" => $user, "photos" => $photos, "saved" => $saved];
		}

		public function authorization($data) {
			$userController = new UserController();
			$user = $userController->login($data);
			if (count($user) != 0) {
				if (!password_verify($data['password'], $user[0]['password']) || $user[0]['verified'] == 0) {
					return json_encode(FRONT_ERROR);
				}
			}
			$this->setAuthorized($user[0]);

			return json_encode(SUCCESS);
		}

		public function logoutAuthorized() {
			$this->setAuthorized("");
			return json_encode(SUCCESS);
		}
	}