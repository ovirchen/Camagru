<?php

require_once "Photo.php";

class Model_Photoes extends Model
{
    public function get_data()
    {
        $result = null;
        $photo = new Photo();
        $arr = $photo->getAllPhoto();
        if ($arr)
            $result = array_reverse($arr);

        return $result;
    }

}