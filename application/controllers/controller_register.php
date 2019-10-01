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

    function action_reset_password()
    {
        echo '<script>
                    var email = prompt("Enter your email", "email@.com");
                    window.location.href = "http://localhost:8080/register/mail_password?email=" + email;
              </script>';
    }

    function action_mail_password()
    {
        $user = new User();
//        var_dump($_GET);
//        die();
        if (!($user->getUserByEmail($_GET['email'])))
        {
            echo "<script>
                alert(\"SUCH EMAIL DOES NOT EXIST\");
                location.href='http://localhost:8080/login';
                </script>";
        }
        else {
        $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = '<html><body>';
        $message .= '<div>HI THERE!</div>
            <div>You reset your password for account TAKEaPICTURE.</div>
            <div>Click on link to make a new one: <a href="http://localhost:8080/login/new_password?id='.
            $user->getId() .'">CLICK ME</a></div>';
        $message .= '</body></html>';

        mail($user->getEmail(), 'Make a new password for account TAKEaPICTURE', $message, $headers);
        }
        header('Location: http://localhost:8080');
    }

    function action_new_password()
    {
        $user = new User();
        $user->getUserById($_POST['id']);

        if (($password = trim($_POST['password'])) != "" && ($password2 = trim($_POST['password2'])) != "")
        {
            if ($password == $password2)
            {
                $passwd = hash('whirlpool', $password);
                $user->setPassword($passwd);
                echo "<script>
                alert(\"NOW YOU HAVE A NEW PASSWORD\");
                location.href='http://localhost:8080';
                </script>";
            }
            else {
                echo "<script>
                alert(\"INCORRECT PASSWORD. TRY AGAIN\");
                location.href='http://localhost:8080';
                </script>";
            }
        }
    }

    function action_check_email()
    {
        $user = new User();
        $user->updateUser($_GET['id']);
        $photo = new Photo();
        $photo->setPath("images/profiles/default.jpg");
        $photo->setUserId($_GET['id']);
        $photo->insertPhoto();
        header('Location: http://localhost:8080');
    }

    function action_edit()
    {
        $user = new User();
        $user->getUserById($_SESSION['user']['id']);
        if (($username = trim($_POST['username'])) != "")
        {
            if (!($user->setUsername($username))) {
                echo "<script>
                    alert(\"SUCH USERNAME ALREADY EXIST\");
                    location.href='http://localhost:8080/profile/edit';
                </script>";
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
                echo "<script>
                alert(\"SUCH EMAIL ALREADY EXIST\");
                location.href='http://localhost:8080/profile/edit';
                </script>";
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
                echo "<script>
                alert(\"INCORRECT PASSWORD. TRY AGAIN\");
                location.href='http://localhost:8080/profile/edit';
                </script>";
            }
        }
        header('Location: http://localhost:8080/profile');
    }
}

