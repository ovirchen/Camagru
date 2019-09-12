<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/24/19
	 * Time: 11:06 PM
	 */

	namespace controllers;
	require __DIR__."/../models/Photo.class.php";
	require __DIR__."/../models/Comment.class.php";
	require __DIR__."/../models/Likes.class.php";
	require __DIR__."/../models/Favourite.class.php";

	use app\Comment;
	use app\Likes;
	use app\models\Favourite;
	use app\Photo;
	use models\User;

	class PhotoController {
		private $status = NOT_AUTHORIZED;

		public function getPhotos() {
			$photoModel = new Photo();
			$photos = $photoModel->getAllPhotos();
			$authUser = new AuthController();
			$authUser = $authUser->getAuthorized();
			$isLiked = null;
			foreach ($photos as $key => $photo) {
				if (isset($photo["id"])) {
					$userModel = new User();
					$commentModel = new Comment();
					$likes = new Likes();
					$favourite = new Favourite();
					$user = $userModel->getUser($photo["user_id"], "id");
					$likes = $likes->getAmountOfLikes($photo["id"]);
					$isLiked = false;
					if (!$authUser) {
						$isFavourite = false;
					} else {
						$data = $favourite->isFavourite($photo["id"], $authUser["id"]);
						$isFavourite = (!$data) ? false : true;
					}
					foreach ($likes as $like) {
						if ($authUser && count($authUser) > 0 && $authUser["id"] == $like["user_id"]) {
							$isLiked = true;
							break;
						}
					}
					$posts[] = [
						"profile" => $user[0],
						"post" => $photo,
						"comments" => $commentModel->getCommentFromPhoto($photo['id']),
						"likes" => count($likes),
						"liked" => $isLiked,
						"favourite" => $isFavourite
					];
				}
			}
			return $posts;
		}

		public function saveUploadImage($data) {
			$img = str_replace('data:image/png;base64,', '', $data);
			$img = str_replace(' ', '+', $img);
			$fileData = base64_decode($img);
			$auth = new AuthController();
			$user = $auth->getAuthorized();
			if (!file_exists(BASE_PATH.'/resources/img/'.$user["login"])) {
				mkdir(BASE_PATH.'/resources/img/'.$user["login"], 0777);
			}
			$fileName = BASE_PATH.'/resources/img/'.$user["login"].'/'.$user["login"].time().".png";
			file_put_contents($fileName, $fileData);
			$pathToDB = 'http://localhost:8080/resources/img/'.$user["login"].'/'.$user["login"].time().".png";
			$photoModel = new Photo();
			$photoModel->savePhoto($pathToDB, $user['id']);
			return json_encode(["status" => 200, "path" => $pathToDB]);
		}

		public function likes($photoID, $userID) {
			$likes = new Likes();
			$data = $likes->isLiked($photoID, $userID['id']);
			$this->status = (count($data) == 0)  ? SUCCESS : 202;
			($this->status == SUCCESS)
				? $likes->saveLike($photoID, $userID['id'])
				: $likes->deleteLike( $data[0]["photo_id"], $data[0]["user_id"]);
			$photoModel = new Photo();
			$emailPhoto = $photoModel->getAllWhere("photo", "id", $photoID);
			$userModel = new User();
			$userEmail = $userModel->getUser($emailPhoto[0]["user_id"], "id");
			if ($userEmail[0]["notification"] == 1) {
				$email = new EmailController();
				$email->sendLike($userEmail[0]["email"], $userID["login"], $emailPhoto[0]["path"]);
			}
//			return json_encode(["data" => $data, "photo" => $emailPhoto, "user" => $userEmail]);
			return json_encode(["status" => $this->status]);
		}

		public function favourite($photoID, $userID) {
			$favourite = new Favourite();
			$data = $favourite->isFavourite($photoID, $userID["id"]);
			$this->status = (count($data) == 0)  ? SUCCESS : 202;
			($this->status == SUCCESS)
				? $favourite->saveFavourite($photoID, $userID["id"])
				: $favourite->deleteFavourite($photoID, $userID["id"]);
			return json_encode(["status" => $this->status]);
		}

	}