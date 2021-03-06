<?php


class Route
{
    static function start()
    {
        $controller_name = 'main';
        $action = 'index';

        $route = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($route[1])) {
            if (strpos($route[1], '?id='))
            {
                $result = explode('?id=', $route[1]);
                $controller_name = $result[0];
            }
            else
                $controller_name = $route[1];
        }
        if (!empty($route[2])) {
            if (strpos($route[2], '?id='))
            {
                $result = explode('?id=', $route[2]);
                $action = $result[0];
            }
            elseif (strpos($route[2], '?email='))
            {
                $result = explode('?email=', $route[2]);
                $action = $result[0];
            }
            elseif (strpos($route[2], '%'))
            {
                $result = explode('%', $route[2]);
                $action = $result[0];
            }
            else
                $action = $route[2];
        }
        $model_name = 'model_' . $controller_name;
        $controller_name = 'controller_' . $controller_name;
        $action = 'action_' . $action;
        $model_file = strtolower($model_name) . '.php';
        $model_path = 'application/models/' . $model_file;

        if (file_exists($model_path)) {
            include $model_path;
        }

        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = 'application/controllers/' . $controller_file;

        try {
            if (file_exists($controller_path)) {
                include $controller_path;
            } else {
                throw new Exception('File not found.');
//                self::ErrorPage404();
            }
            $controller = new $controller_name;
            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                echo $action;
                die();
                throw new Exception('File not found.');
//                self::ErrorPage404();
            }
        } catch (Exception $e)
        {
            self::ErrorPage404();
        }


    }

    private function ErrorPage404()
    {
        require_once 'application/controllers/controller_404.php';
        $not_found = new Controller_404();
        $not_found->action_index();
    }
}