<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/25/19
	 * Time: 12:40 PM
	 */

	namespace controllers;


	class EmailController {
		protected $encoding = "utf-8";

		public function varification($email, $password) {
			$preferences = [
				"input-charset" => $this->encoding,
				"output-charset" => $this->encoding,
				"line-length" => 76,
				"line-break-chars" => "\r\n"
			];
			$to = $email;

			$subject = "Welcome from Camagru";
			$msg = "<a href='http://localhost:8080/verification?code=".$password."'>Click for verification</a>";
			$message = '<!DOCTYPE html>
					<html>
					<head>
						<title>Camagru Activity</title>
					</head>
					<body>
						<div>
							<p>'.$msg.'</p>
						</div>
					</body>
					</html>';
			$additional_header = "Content-type: text/html; charset=".$this->encoding." \r\n";
			$additional_header .= "From: Camagru <no-reply@camagru.com> \r\n";
			$additional_header .= "MIME-Version: 1.0 \r\n";
			$additional_header .= "Content-Transfer-Encoding: 8bit \r\n";
			$additional_header .= "Date: ".date("r (T)")." \r\n";
			$additional_header .= iconv_mime_encode("Subject", $subject, $preferences);
			mail($to, $subject, $message, $additional_header);
		}

		public function sendNewPassword($email, $newPass) {
			$preferences = [
				"input-charset" => $this->encoding,
				"output-charset" => $this->encoding,
				"line-length" => 76,
				"line-break-chars" => "\r\n"
			];
			$to = $email;

			$subject = "Welcome from Camagru";
			$msg = "<p>This is your new password: ".$newPass."</p>";
			$message = '<!DOCTYPE html>
					<html>
					<head>
						<title>Camagru Activity</title>
					</head>
					<body>
						<div>
							<p>'.$msg.'</p>
						</div>
					</body>
					</html>';
			$additional_header = "Content-type: text/html; charset=".$this->encoding." \r\n";
			$additional_header .= "From: Camagru <no-reply@camagru.com> \r\n";
			$additional_header .= "MIME-Version: 1.0 \r\n";
			$additional_header .= "Content-Transfer-Encoding: 8bit \r\n";
			$additional_header .= "Date: ".date("r (T)")." \r\n";
			$additional_header .= iconv_mime_encode("Subject", $subject, $preferences);
			mail($to, $subject, $message, $additional_header);
		}

		public function sendComment($email, $user, $photo) {
			$preferences = [
				"input-charset" => $this->encoding,
				"output-charset" => $this->encoding,
				"line-length" => 76,
				"line-break-chars" => "\r\n"
			];
			$to = $email;

			$subject = "Welcome on Camagru";
			$msg = "<p>New comment from $user on the post <img src='$photo' alt=''></p>";
			$message = '<!DOCTYPE html>
					<html>
					<head>
						<title>Camagru Activity</title>
					</head>
					<body>
						<div>
							<p>'.$msg.'</p>
						</div>
					</body>
					</html>';
			$additional_header = "Content-type: text/html; charset=".$this->encoding." \r\n";
			$additional_header .= "From: Camagru <no-reply@camagru.com> \r\n";
			$additional_header .= "MIME-Version: 1.0 \r\n";
			$additional_header .= "Content-Transfer-Encoding: 8bit \r\n";
			$additional_header .= "Date: ".date("r (T)")." \r\n";
			$additional_header .= iconv_mime_encode("Subject", $subject, $preferences);
			mail($to, $subject, $message, $additional_header);
		}


		public function sendLike($email, $user, $photo) {
			$preferences = [
				"input-charset" => $this->encoding,
				"output-charset" => $this->encoding,
				"line-length" => 76,
				"line-break-chars" => "\r\n"
			];
			$to = $email;

			$subject = "Welcome on Camagru";
			$msg = "<p>New activity from $user on the post <img src='$photo' alt=''></p>";
			$message = '<!DOCTYPE html>
					<html>
					<head>
						<title>Camagru Activity</title>
					</head>
					<body>
						<div>
							<p>'.$msg.'</p>
						</div>
					</body>
					</html>';
			$additional_header = "Content-type: text/html; charset=".$this->encoding." \r\n";
			$additional_header .= "From: Camagru <no-reply@camagru.com> \r\n";
			$additional_header .= "MIME-Version: 1.0 \r\n";
			$additional_header .= "Content-Transfer-Encoding: 8bit \r\n";
			$additional_header .= "Date: ".date("r (T)")." \r\n";
			$additional_header .= iconv_mime_encode("Subject", $subject, $preferences);
			mail($to, $subject, $message, $additional_header);
		}

	}