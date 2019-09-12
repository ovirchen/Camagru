<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/20/19
	 * Time: 9:52 PM
	 */
	namespace app;
	use app\models\Favourite;
	use controllers\AuthController;
	use controllers\EmailController;
	use controllers\UserController;
	use controllers\PhotoController;
	use models\User;

	require __DIR__."/../app/controllers/UserController.php";
	require __DIR__."/../app/controllers/AuthController.php";
	require __DIR__."/../app/controllers/PhotoController.php";
	require __DIR__."/../CONSTANT_NAMES.php";

	class Api {

		private $methodsArray = [
			0 => "checkAuthorize",
			1 => "login",
			2 => "logout",
			3 => "registration",
			4 => "upload_img",
			5 => "getPosts",
			6 => "setLike",
			7 => "favourite",
			8 => "whoProfile",
			9 => "change_ava",
			10 => "del_image",
			11 => "comment",
			12 => "restore_pass",
			13 => "update_user"
		];
		protected $method = [];
		protected $data;
		private $auth;

		public function __construct($method, $data = null) {
			if (!in_array($method[0], $this->methodsArray)) {
				return null;
			}
			$this->method = $method;
			$this->data = $data;
			$this->auth = new AuthController();
		}

		public function getMethod() {
			if (!$this->auth) {
				$this->auth = new AuthController();
			}
			$user = $this->auth->getAuthorized();
			if (isset($_GET["code"])) {
				(new UserController)->changeAccess($_GET["code"]);
			}
			switch ($this->method[0]) {
				case "checkAuthorize":
					$tmp = $this->auth->isAuthorize($user);
					return ($user)
						? json_encode(["status" => SUCCESS, "data" => $tmp["data"], "photos" => $tmp["photos"], "saved" => $tmp["saved"]])
						: json_encode(["status" => NOT_AUTHORIZED]);
				case "whoProfile":
					$url = explode("/", $this->data);
					if ((isset($url[2]) && $url[2] == $user["id"]) || !isset($url[2])) {
						$status = 200;
						$tmp = $this->auth->isAuthorize($user);
//						$tmp[] = $user;
					} else {
						$status = 201;
						$userModel = new User();
						$tmp = $userModel->getUser($url[2], "id");
						$tmp = $this->auth->isAuthorize($tmp[0]);
						unset($tmp[0]);
					}
					return json_encode(["status" => $status, "data" => $tmp]);
				case "login":
					return $this->auth->authorization($this->data);
				case "registration":
					$userController = new UserController();
					return $userController->registration($this->data);
				case "logout":
					return $this->auth->logoutAuthorized();
				case "upload_img":
					$photo = new PhotoController();
					return $photo->saveUploadImage($this->data);
				case "change_ava":
					$photo = new UserController();
					$result = $photo->saveAvatar();
					$user["avatar"] = $result["path"];
					$this->auth->setAuthorized($user);
					return json_encode($result);
				case "getPosts":
//				    var_dump("lol");
//				    die();
					$photo = new PhotoController();
					return json_encode(["status" => 200, "posts" => $photo->getPhotos()]);
				case "setLike":
					$likes = new PhotoController();
					return (!$user)
						? json_encode(["status" => NOT_FOUND])
						: $likes->likes($this->data, $user);
				case "favourite":
					$favourite = new PhotoController();
					return (!$user)
						? json_encode(["status" => 404])
						: $favourite->favourite($this->data, $user);
				case "del_image":
					$photo = new Photo();
					$photo->deletePhoto($this->data, $user["id"]);
					$favouriteModel = new Favourite();
					$likesModel = new Likes();
					$isLiked = $likesModel->isLiked($this->data, $user['id']);
					$isFavourite = $favouriteModel->isFavourite($this->data, $user["id"]);
					if (count($isFavourite) > 0) {
						$favouriteModel->deleteFavourite($this->data, $user["id"]);
					}
					if (count($isLiked) > 0) {
						$likesModel->deleteLike($this->data, $user["id"]);
					}
					return json_encode($this->data);
				case "comment":
					$photo = new Photo();
					$comment = $photo->comment($user["id"], $user["login"], $this->data["id"], $this->data["comment"]);
					$photoModel = new Photo();
					$emailPhoto = $photoModel->getAllWhere("photo", "id", $this->data["id"]);
					$userModel = new User();
					$userEmail = $userModel->getUser($emailPhoto[0]["user_id"], "id");
					if ($userEmail["notification"] == 1) {
						$email = new EmailController();
						$email->sendLike($userEmail[0]["email"], $user["login"], $emailPhoto[0]["path"]);
					}
					return json_encode(["status" => 200, "user" => $comment]);
				case "restore_pass":
					$userController = new UserController();
					return $userController->restorePassword($this->data);
				case "update_user":
					$userController = new UserController();
					$userController->updateUser($this->data);
					return json_encode(SUCCESS);
				default:
					return json_encode(NOT_FOUND);
			}
		}
	}