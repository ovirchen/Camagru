<?php

require_once "User.php";

class Controller
{
    public $model;
    public $view;

    function __construct()
    {
        if (!isset($_SESSION))
            session_start();
        $this->view = new View;
    }

    function action_index()
    {
    }
}