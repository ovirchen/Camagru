<?php

class Controller_Login extends Controller
{
    public function action_index()
    {
        if (isset($_SESSION['user']))
        {
            header('Location: http://localhost:8080');
        }
        $this->view->generate('login_view.php',
            'template_view.php', null);
    }

    function action_login()
    {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $user = new User();
        if (($test = $user->getUserByName($username)) && ($user->getPassword() === hash('whirlpool', $password))
            && $test['valid'] == 1)
        {
            $_SESSION['user'] = $test;
            header('Location: http://localhost:8080/profile?id=' . $_SESSION['user']['id']);
        }
        if ($test && $test['valid'] != 1)
        {
            echo "<script>
                alert(\"PLEASE VERIFY YOUR EMAIL\");
                location.href='http://localhost:8080/login';
              </script>";
        }
        else {
            echo "<script>
                alert(\"INCORRECT LOGIN OR PASSWORD\");
                location.href='http://localhost:8080/login';
              </script>";
        }
    }

    function action_logout()
    {
        $_SESSION['user'] = null;
        session_destroy();
        header('Location: http://localhost:8080');
    }

    public function action_new_password()
    {
        $data = array('id' => $_GET['id']);
        $this->view->generate('password_view.php',
            'template_view.php', $data);
    }
}