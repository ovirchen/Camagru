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


//            $headers = "Reply-To: ". $email . "\r\n";
//            $headers .= "CC: susan@example.com\r\n";
//            $headers .= "MIME-Version: 1.0\r\n";
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
}