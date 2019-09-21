<?php

require_once "Photo.php";

class Model_Profile extends Model {

    public function get_data()
    {
        $result = null;
        if (isset($_GET['id']))
        {
            $photo = new Photo();
            $arr = $photo->getPhotoByUser($_GET['id']);
            if ($arr)
                $result = array_reverse($arr);
        }
        else if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $photo = new Photo();
            $arr = $photo->getPhotoByUser($user['id']);
            if ($arr)
                $result = array_reverse($arr);
        }
        return $result;
    }

}