<?php


class Controller_Register extends Controller
{
    public function action_index()
    {
        $this->view->generate('register_view.php',
            'template_view.php', null);
    }
}