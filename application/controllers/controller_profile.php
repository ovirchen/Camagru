<?php

class Controller_Profile extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new Model_Profile();
        $this->view = new View();
    }

    function action_index()
    {
        if (!isset($_SESSION['user']))
        {
            header('Location: http://localhost:8080/login');
        }
        $data = $this->model->get_data();
        $this->view->generate('profile_view.php',
            'template_view.php', $data);
    }

    function action_add_photo()
    {
        if ($_FILES['filename']['error'] != 0) {
            //alert
            echo "ERROR LOADING FILE";
            die();
            header('Location: http://localhost:8080/profile');
        }
        $filename = $_FILES['filename']['name'];
        $file = basename($filename);
        $filename = $_FILES['filename']['tmp_name'];
        $newfile = "images/photoes/" . $file;
        $user = $_SESSION['user'];
        $photo = new Photo($user['id'], $newfile);
        // проверка наличия такого файла
        copy($filename, $newfile);
        $photo->insertPhoto();
        header('Location: http://localhost:8080/profile');
    }
}