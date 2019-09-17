<?php


class Controller_Camera extends Controller
{
    public function action_index()
    {
        $this->view->generate('camera_view.php',
            'template_view.php', null);
    }
}