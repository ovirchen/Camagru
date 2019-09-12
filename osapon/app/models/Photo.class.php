<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/24/19
	 * Time: 11:15 PM
	 */

	namespace app;
//	require __DIR__."/BaseModel.class.php";
//
	use controllers\AuthController;
	use models\BaseModel;

	class Photo extends BaseModel {

		public function __construct() {
			$this->table = "photo";
			parent::__construct();
		}

		public function savePhoto($path, $id) {
			$columns = $this->getColumnList($this->table);
			array_shift($columns);
			$columns = $this->prepareSqltem($columns, "`");
			$values = [
				0 => $id,
				1 => $path
			];
			$values = $this->prepareSqltem($values, "'");
			$this->insert($this->table, $columns, $values);
		}

		public function getPhoto($photoID) {
			$photo = $this->getAllWhere($this->table, '`id`', $photoID);
			return $photo[0];
		}

		public function getAllPhotos() {
			$photos = $this->getAll($this->table, "ASC");
			return $photos;
		}

		public function getAllPhotosByUserID($id) {
			$photos = $this->getAllWhere($this->table, '`user_id`', $id, "ASC");
			return $photos;
		}
		public function deletePhoto($photoID, $userID) {
			$this->delete($this->table, $photoID, $userID);
		}
		public function comment($id, $login, $photoID, $comment) {
			$columns = $this->getColumnList("comment");
			array_shift($columns);
			$columns = $this->prepareSqltem($columns, "`");
			$values = [
				"user_id" => $id,
				"login" => $login,
				"photo_id" => $photoID,
				"comment" => $comment,
				"comment_date" => date('l jS \of F Y h:i:s A')
			];
////			return ["col"=>$columns, "val"=>$values];
//			$tmp = $this->prepareSqltem($values, "'");
			$this->insertComment("comment", $columns, $values);
			return $values;
		}
	}