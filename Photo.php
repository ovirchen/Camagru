<?php


class Photo extends Database
{
    private $id;
    private $user_id;
    private $path;
    private $like;

    public function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    public function __construct2($user_id, $path) {
        $this->user_id = $user_id;
        $this->path = $path;
        $this->like = 0;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }

    public function getPath() { return $this->path; }
    public function setPath($path) { $this->path = $path; }

    public function getLike() { return $this->like; }
    public function addLike() { $this->like++; }

    public function insertPhoto() : bool {
        try {
            $stmt = parent::getInstance()->prepare("INSERT INTO `photo` (user_id, path) VALUES (? ,?)");
            $stmt->bindParam(1, $this->user_id);
            $stmt->bindParam(2, $this->path);
            return $stmt->execute();
        } catch (PDOException $e)
        {
            return false;
        }
    }

    public function getPhotoByUser($user_id) {
        try {
            $stmt = parent::getInstance()->prepare("SELECT * FROM `photo` WHERE user_id=? AND path LIKE 'images/photoes/%'");
            $stmt->bindParam(1, $user_id);
            $stmt->execute();
            if (!$stmt)
                return null;
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return null;
            return $result;
        } catch (PDOException $e)
        {
            return null;
        }
    }

    public function getAllPhoto() {
        try {
            $stmt = parent::getInstance()->prepare("SELECT * FROM `photo` WHERE path LIKE 'images/photoes/%'");
            $stmt->execute();
            if (!$stmt)
                return null;
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e)
        {
            return null;
        }
    }

    public function getProfilePhoto($user_id) {
        try {
            $stmt = parent::getInstance()->prepare("SELECT * FROM `photo` WHERE user_id=? AND path LIKE 'images/profiles/%'");
            $stmt->bindParam(1, $user_id);
            $stmt->execute();
            if (!$stmt) {
                return null;
            }
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e)
        {
            echo $e;
            return null;
        }
    }

    public function deletePhoto($path) : bool {
        try {
            $stmt = parent::getInstance()->prepare('DELETE FROM `photo` WHERE EXISTS path=?');
            $stmt->bindParam(1, $path);
            $stmt->execute();
            return true;
        } catch (PDOException $e)
        {
            return false;
        }
    }
}