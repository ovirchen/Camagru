<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 3/4/19
	 * Time: 2:30 PM
	 */

	namespace app;

	use models\BaseModel;

	class Comment extends BaseModel {

		public function __construct() {
			$this->table = "comment";
			parent::__construct();
		}

		public function getCommentFromPhoto($photoID) {
			$comments = $this->getAllWhere($this->table, '`photo_id`', $photoID, 'ASC');
			return $comments;
		}

		public function isComment($photoID, $userID) {
			return $this->whereAndWhere($this->table, "`photo_id`", "`user_id`", $photoID, $userID);
		}

		public function deleteComment($photoID, $userID) {
			$this->delete($this->table, $photoID, $userID);
		}

	}