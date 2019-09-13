<?php

require_once "Photo.php";

class Model_Profile extends Model {

    public function get_data()
    {
        $result = null;
        if (isset($_GET['id']))
        {
            $photo = new Photo();
            $result = $photo->getPhotoByUser($_GET['id']);
        }
        else if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $photo = new Photo();
            $result = $photo->getPhotoByUser($user['id']);
        }
        return $result;
    }

}