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
    public function setId($id) {
        $stmt = parent::getInstance()->prepare('UPDATE `user` SET id=? WHERE id=?');
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        if (!$stmt)
            return;
        $stmt = parent::getInstance()->prepare('UPDATE `comment` SET user_id=? WHERE user_id=?');
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        $stmt = parent::getInstance()->prepare('UPDATE `likes` SET user_id=? WHERE user_id=?');
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        $stmt = parent::getInstance()->prepare('UPDATE `photo` SET user_id=? WHERE user_id=?');
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        $this->id = $id;
    }

    public function getUsername() { return $this->username; }
    public function setUsername($username) {
        $stmt = parent::getInstance()->prepare('SELECT * FROM `user` WHERE BINARY username=? AND NOT id=?');
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        if ($stmt && ($result = $stmt->fetch(PDO::FETCH_ASSOC)))
                return false;
        $this->username = $username;
        $stmt = parent::getInstance()->prepare('UPDATE `user` SET username=? WHERE id=?');
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function getFirstname() { return $this->firstname; }
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        $stmt = parent::getInstance()->prepare('UPDATE `user` SET firstname=? WHERE id=?');
        $stmt->bindParam(1, $firstname);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function getLastname() { return $this->lastname; }
    public function setLastname($lastname) {
        $this->lastname = $lastname;
        $stmt = parent::getInstance()->prepare('UPDATE `user` SET lastname=? WHERE id=?');
        $stmt->bindParam(1, $lastname);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function getEmail() { return $this->email; }
    public function setEmail($email) {
        $stmt = parent::getInstance()->prepare('SELECT * FROM `user` WHERE email=? AND NOT id=?');
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        if ($stmt && ($result = $stmt->fetch(PDO::FETCH_ASSOC)))
            return false;
        $this->email = $email;
        $stmt = parent::getInstance()->prepare('UPDATE `user` SET email=? WHERE id=?');
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function getPassword() { return $this->password; }
    public function setPassword($password) {
        $this->password = $password;
        $stmt = parent::getInstance()->prepare('UPDATE `user` SET password=? WHERE id=?');
        $stmt->bindParam(1, $password);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function insertUser() : bool {
        try {
            $passwd = hash('whirlpool', $this->password);
            $stmt = parent::getInstance()->prepare("INSERT INTO `user` (username, firstname, lastname, 
email, password) VALUES (? ,? ,? ,? ,?)");
            $stmt->bindParam(1, $this->username);
            $stmt->bindParam(2, $this->firstname);
            $stmt->bindParam(3, $this->lastname);
            $stmt->bindParam(4, $this->email);
            $stmt->bindParam(5, $passwd);
            if ($stmt->execute())
                return $this->getUserByEmail($this->email);
            else
                return false;
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
            $stmt = parent::getInstance()->prepare('SELECT * FROM `user` WHERE BINARY username=?');
            $stmt->bindParam(1, $username);
            $stmt->execute();
            if (!$stmt)
                return false;
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result)
                return false;
            $this->id = $result['id'];
            $this->username = $result['username'];
            $this->firstname = $result['firstname'];
            $this->lastname = $result['lastname'];
            $this->email = $result['email'];
            $this->password = $result['password'];
            return $result;

        } catch (PDOException $e)
        {
            return false;
        }
    }

    public function getUserByEmail($email): bool {
        try {
            $stmt = parent::getInstance()->prepare('SELECT * FROM `user` WHERE BINARY email=?');
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if (!$stmt)
                return false;
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result)
                return false;
            $this->id = $result['id'];
            $this->username = $result['username'];
            $this->firstname = $result['firstname'];
            $this->lastname = $result['lastname'];
            $this->email = $result['email'];
            $this->password = $result['password'];
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
            $this->id = $result['id'];
            $this->username = $result['username'];
            $this->firstname = $result['firstname'];
            $this->lastname = $result['lastname'];
            $this->email = $result['email'];
            $this->password = $result['password'];
            return $result;
        } catch (PDOException $e)
        {
            return false;
        }
    }

    public function updateUser($id) {
        $stmt = parent::getInstance()->prepare('UPDATE `user` SET valid=1 WHERE id=?');
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    public function deleteUser($id) : bool {
        try {
            $stmt = parent::getInstance()->prepare('DELETE FROM `user` WHERE id=?');
            $stmt->bindParam(1, $id);
            if ($stmt->execute())
            {
                $stmt = parent::getInstance()->prepare('DELETE FROM `comment` WHERE user_id=?');
                $stmt->bindParam(1, $id);
                $stmt->execute();
                $stmt = parent::getInstance()->prepare('DELETE FROM `likes` WHERE user_id=?');
                $stmt->bindParam(1, $id);
                $stmt->execute();
                return true;
            }
            return false;
        } catch (PDOException $e)
        {
            return false;
        }
    }


}