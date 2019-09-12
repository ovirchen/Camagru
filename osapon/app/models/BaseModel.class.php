<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/21/19
	 * Time: 5:25 PM
	 */

	namespace models;
	require __DIR__."/../DataBase.class.php";
	use app\DataBase;

	class BaseModel {
		protected $table;
		private $db;

		public function __construct() {
			$this->db = new DataBase();
		}

		protected function prepareSqltem($array, $symbol) {
			foreach ($array as $key => $value) {
				$array[$key] = $symbol.$value.$symbol;
			}
			return implode(", ", $array);
		}

		public function getColumnList($table) {
			$sql = "DESCRIBE `$table`";
			return $this->db->columnsList($sql);
		}

		public function whereAndWhere($table, $column1, $column2, $data1, $data2) {
			return $this->db->selectAllFromTableWithColumn1($table, $column1, $column2, $data1, $data2);
		}

		public function getAll($table, $sort) {
			$sql = "SELECT * FROM $table ORDER BY `id` $sort";
			return $this->db->selectAllFromTableWithColumn($sql);
		}

		public function getAllWhere($table, $column, $data, $sort = "ASC") {
			return $this->db->selectAllFromTableWithColumn2($table, $column, $data, $sort);
		}

		public function insert($table, $columns, $values) {
			$this->db->insertIntoAllDataToTable($table, $columns, $values);
		}

		public function insertComment($table, $columns, $values) {
			$this->db->insertComment($table, $columns, $values);
		}

		public function delete($table, $photoID, $userID) {
			$this->db->insertIntoAllDataToTable1($table, $photoID, $userID);
		}

		public function update($table, $values, $id) {

			$this->db->update($table, $values, $id);
		}
	}