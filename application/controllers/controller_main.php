<?php

require_once "User.php";

class Controller_Main extends Controller
{
    function action_index()
    {
        $this->view->generate('main_view.php',
            'template_view.php', null);
    }

    function action_login()
    {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $user = new User();
        if (($test = $user->getUserByName($username)) && ($user->getPassword() === hash('whirlpool', $password)))
        {
            $_SESSION['user'] = $test;
        }
        header('Location: http://localhost:8080/profile');
    }

    function action_register()
    {
        $username = trim($_POST['username']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $user = new User($username, $firstname, $lastname, $email, $password);
            if ($user->getUserByName($username)) {
                die("Such username is already exist");
            }
            else if ($user->getUserByEmail($email)) {
                die("Such email is already exist");
            }
            $user->insertUser();
        }
        header('Location: http://localhost:8080');
    }

    function action_logout()
    {
        $_SESSION['user'] = null;
        session_destroy();
        header('Location: http://localhost:8080');
    }
}
