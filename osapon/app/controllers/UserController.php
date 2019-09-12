<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/22/19
	 * Time: 10:35 AM
	 */

	namespace controllers;
	require __DIR__."/../models/User.class.php";
	require __DIR__."/EmailController.php";

	use models\User;

	class UserController {

		public function login($data) {
			$userModel = new User();
			$user = $userModel->getUser($data['login'], "login");
			return $user;
		}
		public function registration($data) {
			if (!preg_match(EMAIL_PATTERN, $data['email'])) return json_encode([FRONT_ERROR => "I don't like this email"]);
			if (!preg_match(UC_PASS, $data['password']) || !preg_match(LC_PASS, $data['password']) || !preg_match(NB_PASS, $data['password'])) return json_encode([FRONT_ERROR => "to weak password"]);

			$userModel = new User();
			$isEmail = $userModel->getUser($data["email"], "email");
			$isLogin = $userModel->getUser($data["login"], "login");
			if (!empty($isEmail) || !empty($isLogin)) {
				return json_encode([FRONT_ERROR => "not unique login or email"]);
			}
			$data["verified"] = 0;
			$data["notification"] = 0;
			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
			$userModel->createtUser($data);
			$email = new EmailController();
			$email->varification($data["email"], $data["password"]);
			return json_encode(SUCCESS);
		}

		public function updateUser($data) {
			$auth = new AuthController();
			$user = $auth->getAuthorized();
			foreach ($user as $key => $value) {
				foreach ($data as $newDataKey => $datum) {
					if ($key == $newDataKey && $value != $datum && $datum != "") {
						$user[$key] = $datum;
					}
				}
			}
			$userModel = new User();
			$userModel->updateUser($user);
			$auth->setAuthorized($user);
		}

		public function saveAvatar() {
			$auth = new AuthController();
			$user = $auth->getAuthorized();
			if (!file_exists(BASE_PATH.'/resources/img/avatar/'.$user["login"])) {
				mkdir(BASE_PATH.'/resources/img/avatar/'.$user["login"], 0777);
			}
			$uploadedFile = '';
			if(!empty($_FILES["data"]["name"])){
				$fileName = time().'_'.$_FILES["data"]["name"];
				$valid_extensions = array("jpeg", "jpg", "png");
				$temporary = explode(".", $_FILES["data"]["name"]);
				$file_extension = end($temporary);
				if((($_FILES["data"]["type"] == "image/png") || ($_FILES["data"]["type"] == "image/jpg") || ($_FILES["data"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
					$sourcePath = $_FILES['data']['tmp_name'];
					$targetPath = BASE_PATH.'/resources/img/avatar/'.$user["login"]."/".$fileName;
					if(move_uploaded_file($sourcePath,$targetPath)){
						$uploadedFile = $fileName;
					}
				} else {
					return ["status" => 400];
				}
			}
			$pathToDB = 'http://localhost:8080/resources/img/avatar/'.$user["login"].'/'.$uploadedFile;
			$this->updateUser(["avatar" => $pathToDB]);
			return ["status" => 200, "path" => $pathToDB];
		}
		public function changeAccess($code) {
			$userModel = new User();
			$users = $userModel->getAll("user", "ASC");
			foreach ($users as $user) {
				if ($code === $user["password"]) {
					$tmp = $userModel->getUser($user["email"], "email");
					$tmp[0]["verified"] = 1;
					$userModel->updateUser($tmp[0]);
					break;
				}
			}
		}
		public function restorePassword($login) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$newPass = '';
			for ($i = 0; $i < 8; $i++) {
				$newPass .= $characters[rand() % strlen($characters)];
			}
			$userModel = new User();
			$isLogin = $userModel->getUser($login, "login");
			if (!empty($isLogin)) {
				$isLogin[0]["password"] = password_hash($newPass, PASSWORD_DEFAULT);
				$userModel->updateUser($isLogin[0]);
				$email = new EmailController();
				$email->sendNewPassword($isLogin[0]["email"], $newPass);
				return json_encode(["status" => SUCCESS, "pass" => $newPass]);
			}
			return json_encode(FRONT_ERROR);
		}

	}