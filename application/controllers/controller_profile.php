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
        if (!isset($_SESSION['user']) && !isset($_GET['id']))
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
            header('Location: http://localhost:8080/profile?id=' . $_SESSION['user']['id']);
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
        header('Location: http://localhost:8080/profile?id=' . $_SESSION['user']['id']);
    }

    function action_add_like()
    {
        if (isset($_POST['data']))
        {
            $data = json_decode($_POST['data']);
//            var_dump($data);
            $photo = new Photo();
            $photo->setId($data->photoId);
            if ($photo->addLike($data->userId))
                echo json_encode(['status' => 200, 'message' => 'Like added', 'amount' => $photo->countLikes()]);
        } else {
            echo json_encode(['status'=> 400, 'message' => 'Cannot set like']);
        }
//        $data = json_decode($_POST['data']);


    }
}