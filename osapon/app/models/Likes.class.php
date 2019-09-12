<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 3/4/19
	 * Time: 2:48 PM
	 */

	namespace app;

	use models\BaseModel;

	class Likes extends BaseModel {

		public function __construct() {
			$this->table = "like";
			parent::__construct();
		}

		public function getAmountOfLikes($photoID) {
			$amount = $this->getAllWhere($this->table, '`photo_id`', $photoID);
			return $amount;
		}

		public function deleteLike($photoID, $userID) {
			$this->delete($this->table, $photoID, $userID);
		}

		public function saveLike($photoID, $userID) {
			$columns = $this->getColumnList($this->table);
			array_shift($columns);
			$values = $this->prepareSqltem([$userID, $photoID], "'");
			$columns = $this->prepareSqltem($columns, "`");
			$this->insert($this->table, $columns, $values);
		}

		public function isLiked($photoID, $userID) {
			return $this->whereAndWhere($this->table, "`photo_id`", "`user_id`", $photoID, $userID);
		}
	}