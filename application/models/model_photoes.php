<?php

require_once "Photo.php";

class Model_Photoes extends Model
{
    public function get_data()
    {
        $photo = new Photo();
        $result = $photo->getAllPhoto();

        return $result;
    }

}