<?php


class SQL extends Database
{
    public function update($table, $statement, $name_id, $id)
    {
        $sql = "UPDATE `" . $table . "` SET valid=1 WHERE ". $name_id . "=" . $id;
        $stmt = parent::getInstance()->prepare($sql);
        return $stmt->execute();
    }

    public function delete($table, $name_id, $id)
    {
        $sql = "DELETE FROM `" . $table . "` WHERE " . $name_id . "=" . $id;
        $stmt = parent::getInstance()->prepare($sql);
        return $stmt->execute();
    }

    public function selectAll($table, $name_id, $id)
    {
        $sql = "SELECT * FROM `" . $table . "` WHERE " . $name_id . "=" . $id;
        $stmt = parent::getInstance()->prepare($sql);
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
    }

    public function selectOne($table, $name_id, $id)
    {
        $sql = "SELECT * FROM `" . $table . "` WHERE " . $name_id . "=" . $id;
        $stmt = parent::getInstance()->prepare($sql);
        $stmt->execute();
        if (!$stmt)
            return null;
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res)
            return array_reverse($res);
        return null;
    }

    public function insert($table, $data)
    {
        $sql = "INSERT INTO `" . $table . "` (photo_id, user_id, text) VALUES (? ,? ,?)";
    }
}