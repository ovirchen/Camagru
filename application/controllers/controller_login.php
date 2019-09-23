<?php

class Controller_Login extends Controller
{
    public function action_index()
    {
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
        echo "<script>alert(\"INCORRECT LOGIN OR PASSWORD\");</script>";
        die();
        header('Location: http://localhost:8080/login');
    }

    function action_logout()
    {
        $_SESSION['user'] = null;
        session_destroy();
        header('Location: http://localhost:8080');
    }
}