<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 3/16/19
	 * Time: 2:36 PM
	 */

	namespace app\models;

	use models\BaseModel;

	class Favourite extends BaseModel {

		public function __construct() {
			$this->table = "favourite";
			parent::__construct();
		}

		public function getAllPhotosByUserID($id) {
			$photos = $this->getAllWhere($this->table, '`user_id`', $id, "ASC");
			return $photos;
		}

		public function deleteFavourite($photoID, $userID) {
			$this->delete($this->table, $photoID, $userID);
		}

		public function saveFavourite($photoID, $userID) {
			$columns = $this->getColumnList($this->table);
			array_shift($columns);
			$values = $this->prepareSqltem([$userID, $photoID], "'");
			$columns = $this->prepareSqltem($columns, "`");
			$this->insert($this->table, $columns, $values);
		}

		public function isFavourite($photoID, $userID) {
			return $this->whereAndWhere($this->table, "`photo_id`", "`user_id`", $photoID, $userID);
		}
	}