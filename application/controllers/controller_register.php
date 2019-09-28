<?php

class Controller_Register extends Controller
{
    public function action_index()
    {
        $this->view->generate('register_view.php',
            'template_view.php', null);
    }

    function action_register()
    {
        $username = trim($_POST['username']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password) && !empty($email) &&
            filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $user = new User($username, $firstname, $lastname, $email, $password);
            if ($user->getUserByName($username)) {
                die("Such username is already exist");
            }
            else if ($user->getUserByEmail($email)) {
                die("Such email is already exist");
            }
            $user->insertUser();

            $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $message = '<html><body>';
            $message .= '<div>HI THERE!</div>
            <div>If you want to validate your account TAKEaPICTURE</div>
            <div>click on link: <a href="http://localhost:8080/register/check_email?id='.
                $user->getId() .'">CLICK ME</a></div>';
            $message .= '</body></html>';

            mail($email, 'Validate your account TAKEaPICTURE', $message, $headers);
        }
        header('Location: http://localhost:8080');
    }

    function action_check_email()
    {
        $user = new User();
        $user->updateUser($_GET['id']);
    }

    function action_edit()
    {
        $user = new User();
        $user->getUserById($_SESSION['user']['id']);
        if (($username = trim($_POST['username'])) != "")
        {
            if (!($user->setUsername($username))) {
                echo "SUCH USERNAME ALREADY EXIST";
                echo "\nuser: " . $user->getUsername();
                echo "\nnew: " . $username;
                var_dump($user);
                die();
            }
            $_SESSION['user']['username'] = $username;
        }
        if (($firstname = trim($_POST['firstname'])) != "")
        {
            $user->setFirstname($firstname);
            $_SESSION['user']['firstname'] = $firstname;
        }
        if (($lastname = trim($_POST['lastname'])) != "")
        {
            $user->setLastname($lastname);
            $_SESSION['user']['lastname'] = $lastname;
        }
        if (($email = trim($_POST['email'])) != "")
        {
            if (!($user->setEmail($email))) {
                echo "SUCH EMAIL ALREADY EXIST";
                die();
            }
            $_SESSION['user']['email'] = $email;
        }
        if (($password = trim($_POST['password'])) != "" && ($password2 = trim($_POST['password2'])) != "")
        {
            if ($password == $password2)
            {
                $passwd = hash('whirlpool', $password);
                $user->setPassword($passwd);
                $_SESSION['user']['password'] = $passwd;
            }
            else {
                echo "INCORRECT PASSWORD. TRY AGAIN";
                die();
            }
        }
        header('Location: http://localhost:8080/profile');
    }
}