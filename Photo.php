<?php


class Photo extends Database
{
    private $id;
    private $user_id;
    private $path;

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
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }

    public function getPath() { return $this->path; }
    public function setPath($path) { $this->path = $path; }

    public function addLike($user_id)
    {
        try {
            $stmt = parent::getInstance()->prepare("SELECT * FROM `likes` WHERE user_id=? AND photo_id=?");
            $stmt->bindParam(1, $user_id);
            $stmt->bindParam(2, $this->id);
            $stmt->execute();
            if (!$stmt)
                return false;
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
            {
                $stmt = parent::getInstance()->prepare("INSERT INTO `likes` (user_id, photo_id) VALUES (? ,?)");
                $stmt->bindParam(1, $user_id);
                $stmt->bindParam(2, $this->id);
                return $stmt->execute();
            }
            else {
                $stmt = parent::getInstance()->prepare("DELETE FROM `likes` WHERE user_id=? AND photo_id=?");
                $stmt->bindParam(1, $user_id);
                $stmt->bindParam(2, $this->id);
                return $stmt->execute();
            }
        } catch (PDOException $e)
        {
            return false;
        }
    }

    public function countLikes() {
        $stmt = parent::getInstance()->prepare("SELECT * FROM `likes` WHERE photo_id=?");
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        if ($stmt)
            return $stmt->rowCount();
        return -1;
    }

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
            if ($result) {
                $this->id = $result['id'];
                $this->user_id = $result['user_id'];
                $this->path = $result['path'];
            }
            return $result;
        } catch (PDOException $e)
        {
            echo $e;
            return null;
        }
    }

    public function deletePhoto($id) : bool {
        try {
            $stmt = parent::getInstance()->prepare('DELETE FROM `comment` WHERE photo_id=?');
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $stmt = parent::getInstance()->prepare('DELETE FROM `likes` WHERE photo_id=?');
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $stmt = parent::getInstance()->prepare('DELETE FROM `photo` WHERE id=?');
            $stmt->bindParam(1, $id);
            return $stmt->execute();
        } catch (PDOException $e)
        {
            return false;
        }
    }

    public function addComment($user_id, $comment) {
        try {
            $stmt = parent::getInstance()->prepare('INSERT INTO `comment` (photo_id, user_id, text) VALUES (? ,? ,?)');
            $stmt->bindParam(1, $this->id);
            $stmt->bindParam(2, $user_id);
            $stmt->bindParam(3, $comment);
            return $stmt->execute();
        } catch (PDOException $e)
        {
            return false;
        }
    }

    public function getLastComment() {
        try {
            $stmt = parent::getInstance()->prepare('SELECT * FROM `comment` WHERE photo_id=?');
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            if (!$stmt)
                return null;
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($res)
            {
                $result = array_reverse($res);
                return $result[0];
            }
            return null;
        } catch (PDOException $e)
        {
            return null;
        }
    }
}