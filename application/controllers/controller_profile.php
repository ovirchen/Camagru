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

    function action_edit()
    {
        $this->view->generate('profile_edit_view.php',
            'template_view.php', null);
    }

    function action_delete()
    {
        if (isset($_SESSION['user'])) {
            $user = new User();
            if ($user->deleteUser($_SESSION['user']['id'])) {
                $photo = new Photo();
                if ($result = $photo->getProfilePhoto($_SESSION['user']['id']))
                    $photo->deletePhoto($result['id']);
                if ($result = $photo->getPhotoByUser($_SESSION['user']['id']))
                {
                    foreach ($result as $ph) {
                        $photo->deletePhoto($ph['id']);
                    }
                }
                echo json_encode(['status' => 200, 'message' => 'User deleted']);
                return;
            }
        }
        echo json_encode(['status'=> 400, 'message' => 'Cannot delete user']);
    }

    function action_add_profile_photo()
    {
        if ($_FILES['filename']['error'] != 0) {
            if ($_FILES['filename']['error'] == 2)
            {
                echo "<script>
                alert(\"ERROR: The file is too big\");
                location.href='http://localhost:8080/profile?id=" .  $_SESSION['user']['id'] . "';
                </script>";
            }
            else {
                echo "<script>
                alert(\"ERROR: Cannot loading the file\");
                location.href='http://localhost:8080/profile?id=" .  $_SESSION['user']['id'] . "';
                </script>";
            }
        }
        $filename = $_FILES['filename']['name'];
        $file = basename($filename);
        $filename = $_FILES['filename']['tmp_name'];
        $newfile = "images/profiles/" . $file;
        // проверка наличия такого файла
        copy($filename, $newfile);
        $user = $_SESSION['user'];
        $photo = new Photo();
        if ($photo->getProfilePhoto($user['id'])) {
            $delfile = $photo->getPath();
            if (file_exists($delfile))
                unlink($delfile);
            $photo->setPath($newfile);
        }
        else
        {
            $photo->setUserId($user['id']);
            $photo->setPath($newfile);
            $photo->insertPhoto();
        }
        header('Location: http://localhost:8080/profile/edit');
    }

    function action_add_photo()
    {
        if ($_FILES['filename']['error'] != 0) {
            if ($_FILES['filename']['error'] == 2)
            {
                echo "<script>
                alert(\"ERROR: The file is too big\");
                location.href='http://localhost:8080/profile?id=" .  $_SESSION['user']['id'] . "';
                </script>";
            }
            else {
                echo "<script>
                alert(\"ERROR: Cannot loading the file\");
                location.href='http://localhost:8080/profile?id=" .  $_SESSION['user']['id'] . "';
                </script>";
            }
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

    function action_delete_photo()
    {
        if (isset($_POST['data']))
        {
            $data = json_decode($_POST['data']);
            $photo = new Photo();
            if ($photo->deletePhoto($data->photoId)) {
                echo json_encode(['status' => 200, 'message' => 'Photo deleted']);
                return;
            }
        }
        echo json_encode(['status'=> 400, 'message' => 'Cannot delete photo']);
    }

    function action_add_like()
    {
        if (isset($_POST['data']))
        {
            $data = json_decode($_POST['data']);
            $photo = new Photo();
            $photo->setId($data->photoId);
            if ($photo->addLike($data->userId)) {
                echo json_encode(['status' => 200, 'message' => 'Like added', 'amount' => $photo->countLikes()]);
                return;
            }
        }
        echo json_encode(['status'=> 400, 'message' => 'Cannot set like']);

    }

    function action_add_comment()
    {
        if (isset($_POST['data']))
        {
            $data = json_decode($_POST['data']);
            $photo = new Photo();
            $photo->setId($data->photoId);
            if ($photo->addComment($data->userId, $data->text)) {
                $user = new User();
                $user->getUserById($data->userId);
                $comment = $photo->getLastComment();
                $result = $user->getUsername() . ": " . $comment['text'];
                
                $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $message = '<html><body>';
                $message .= '<div>HI THERE!</div>
            <div>You have a new comment!</div>
            <div>Click on link to find it: <a href="http://localhost:8080">CLICK ME</a></div>';
                $message .= '</body></html>';

                mail($user->getEmail(), 'Make a new password for account TAKEaPICTURE', $message, $headers);

                echo json_encode(['status' => 200, 'message' => 'Comment added', 'amount' => $result]);
                return;
            }
        }
        echo json_encode(['status'=> 400, 'message' => 'Cannot add comment']);
    }
}
