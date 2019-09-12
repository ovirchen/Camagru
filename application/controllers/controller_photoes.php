<?php


class Controller_Photoes extends Controller
{
    function __construct()
    {
        session_start();
        $this->view = new View;
        $this->model = new Model_Photoes();
    }

    function action_index() {
        try {
            $data = $this->model->get_data();
            $this->view->generate('photoes_view.php',
            'template_view.php', $data);
        } catch (PDOException $e)
        {
            return false;
        }
    }

}