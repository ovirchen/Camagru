<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/21/19
	 * Time: 11:12 AM
	 */


	namespace models;
	require __DIR__."/BaseModel.class.php";

	class User extends BaseModel {

		public function __construct() {
			$this->table = "user";
			parent::__construct();
		}

		public function getUser($user, $column) {
			return parent::getAllWhere($this->table, $column, $user, "DESC");
		}

		public function createtUser($user) {
			$values = $this->prepareSqltem($user, "'");
			$columns = $this->getColumnList($this->table);
			array_shift($columns);
			if (($key = array_search('avatar', $columns)) !== false) {
				unset($columns[$key]);
			}
			if (($key = array_search('description', $columns)) !== false) {
				unset($columns[$key]);
			}
			$columns = $this->prepareSqltem($columns, "`");
			$this->insert($this->table, $columns, $values);
		}

		public function updateUser($data) {
			$id = array_shift($data);
			$values = $this->prepareSqltem($data, "'");
			$columns = $this->getColumnList($this->table);
			array_shift($columns);
			$array = '';
			$values = explode(" ", $values);
			for ($i = 0; $i < count($columns); $i++) {
				$array .= $columns[$i]."=".$values[$i];
			}
//			return $values;
			$this->update($this->table, $array, $id);
		}

	}