<?php

require_once "Database.php";


class User extends Database
{
    private $id;
    private $username;
    private $firstname;
    private $lastname;
    private $email;
    private $password;

    public function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

//    public function __construct2($username, $password) {
//        $this->username = $username;
//        $this->password = $password;
//    }

    public function __construct3($username, $email, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function __construct5($username, $firstname, $lastname, $email, $password) {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username = $username; }

    public function getFirstname() { return $this->firstname; }
    public function setFirstname($firstname) { $this->firstname = $firstname; }

    public function getLastname() { return $this->lastname; }
    public function setLastname($lastname) { $this->lastname = $lastname; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }

    public function insertUser() : bool {
        try {
            $passwd = hash('whirlpool', $this->password);
            $stmt = parent::getInstance()->prepare("INSERT INTO `user` (username, firstname, lastname, email, password)
VALUES (? ,? ,? ,? ,?)");
            $stmt->bindParam(1, $this->username);
            $stmt->bindParam(2, $this->firstname);
            $stmt->bindParam(3, $this->lastname);
            $stmt->bindParam(4, $this->email);
            $stmt->bindParam(5, $passwd);
            return $stmt->execute();
        } catch (PDOException $e)
        {

            return false;
        }
//        $statement = $this->connection->query('SELECT * FROM users');
//        while($row = $statement->fetch(PDO::FETCH_CLASS, 'User')) {
//            echo $row->getId() . ' ' . $row->getName();
//          }
    }

    public function getUserByName($username) {
        try {
            $stmt = parent::getInstance()->prepare('SELECT * FROM `user` WHERE username=?');
            $stmt->bindParam(1, $username);
            $stmt->execute();
            if (!$stmt)
                return false;
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result)
                return false;
            $this->setId($result['id']);
            $this->setUsername($result['username']);
            $this->setFirstname($result['firstname']);
            $this->setLastname($result['lastname']);
            $this->setEmail($result['email']);
            $this->setPassword($result['password']);
            return $result;

        } catch (PDOException $e)
        {
            return false;
        }
    }

    public function getUserByEmail($email): bool {
        try {
            $stmt = parent::getInstance()->prepare('SELECT * FROM `user` WHERE email=?');
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if (!$stmt)
                return false;
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result)
                return false;
            $this->setId($result['id']);
            $this->setUsername($result['username']);
            $this->setFirstname($result['firstname']);
            $this->setLastname($result['lastname']);
            $this->setEmail($result['email']);
            $this->setPassword($result['password']);
            return true;

        } catch (PDOException $e)
        {
            return false;
        }
    }

    public function getUserById($id) {
        try {
            $stmt = parent::getInstance()->prepare('SELECT * FROM `user` WHERE id=?');
            $stmt->bindParam(1, $id);
            $stmt->execute();
            if (!$stmt)
                return false;
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result)
                return false;
            $this->setId($result['id']);
            $this->setUsername($result['username']);
            $this->setFirstname($result['firstname']);
            $this->setLastname($result['lastname']);
            $this->setEmail($result['email']);
            $this->setPassword($result['password']);
            return $result;
        } catch (PDOException $e)
        {
            return false;
        }
    }

    public function updateUser() {

    }

    public function deleteUser($username) : bool {
        try {
            $stmt = parent::getInstance()->prepare('DELETE FROM `user` WHERE EXISTS username=?');
            $stmt->bindParam(1, $username);
            $stmt->execute();
            return true;
        } catch (PDOException $e)
        {
            return false;
        }
    }


}