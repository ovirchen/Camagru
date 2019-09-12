<?php
	/**
	 * Created by PhpStorm.
	 * User: alexsapon
	 * Date: 2/20/19
	 * Time: 5:01 PM
	 */

	namespace app;
	use PDO;
	use PDOException;

	class DataBase {

		private $username = "root";
		private $password = "qwerty";
		private $host = "localhost";
		private $database = "camagru";
		protected $connection;

		public function __construct() {
			try {
				$this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo "Connection failed: ". $e->getMessage();
			}
		}

		public function selectAllFromTableWithColumn($sql) {
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$data = $stmt->fetchAll();
			return $data;
		}

		public function selectAllFromTableWithColumn1($table, $column1, $column2, $data1, $data2) {
			$sql = "SELECT * FROM `$table` WHERE $column1=:data1 AND $column2=:tmp;";
			$stmt = $this->connection->prepare($sql);
			$stmt->bindParam(":data1", $data1);
			$stmt->bindParam(":tmp", $data2);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$data = $stmt->fetchAll();
			return $data;
		}

		public function selectAllFromTableWithColumn2($table, $column, $data, $sort) {
			$sql = "SELECT * FROM `$table` WHERE $column=:data1 ORDER BY `id` $sort;";
			$stmt = $this->connection->prepare($sql);
			$stmt->bindParam(":data1", $data);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$data = $stmt->fetchAll();
			return $data;
		}
//	';DROP DATABASE `camagru`;
		public function insertIntoAllDataToTable($table, $columns, $values) {
			$sql = "INSERT INTO `$table` ($columns) VALUES ($values)";
//			$stmt = $this->connection->prepare($sql);
//			$stmt->bindParam(":id", $values[0]);
//			$stmt->bindParam(":path", $values[1]);
			$this->connection->exec($sql);
		}

		public function insertComment($table, $columns, $values) {
			$sql = "INSERT INTO `$table` ($columns) VALUES (:user_id, :login, :photo_id, :comment, :comment_date)";
			$stmt = $this->connection->prepare($sql);
			$stmt->bindParam(":user_id", $values["user_id"]);
			$stmt->bindParam(":login", $values["login"]);
			$stmt->bindParam(":photo_id", $values["photo_id"]);
			$stmt->bindParam(":comment", $values["comment"]);
			$stmt->bindParam(":comment_date", $values["date"]);
			$stmt->execute($sql);
//			$this->connection->exec($sql);
		}

		public function insertIntoAllDataToTable1($table, $photoID, $userID) {
			$sql = "DELETE FROM `$table` WHERE `user_id`=:userId AND `photo_id`=:photoId;";
			$stmt = $this->connection->prepare($sql);
			$stmt->bindParam(":userId", $userID);
			$stmt->bindParam(":photoId", $photoID);
			$stmt->execute();
		}

		public function columnsList($sql) {
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}

		public function update($table, $values, $id) {
			$sql = "UPDATE `$table` SET $values WHERE `id`=:id;";
			$stmt = $this->connection->prepare($sql);
			$stmt->bindParam(":id",$id);
			$stmt->execute($sql);
		}

	}