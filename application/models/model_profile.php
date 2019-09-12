<?php

require_once "Photo.php";

class Model_Profile extends Model {

    public function get_data()
    {
        $result = null;
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $photo = new Photo();
            $result = $photo->getPhotoByUser($user['id']);
        }
        return $result;
    }

}