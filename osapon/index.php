<?php


	require __DIR__."/web/Api.class.php";
	require __DIR__."/web/Web.class.php";
	use app\Api;
	use app\Web;

//	exec("~/Applications/MAMP/Library/bin/mysql -u root -proot < ./config/database.sql  2>&- ");
    exec("/Users/ovirchen/MAMP/mysql/bin/mysql -uroot -pqwerty < ./config/database.sql  2>&- ");

	$requestUrl = $_SERVER['REQUEST_URI'];
	$request = explode('/', $requestUrl);
	array_shift($request);
	switch ($request[0]) {
		case "api":
			array_shift($request);
			$data = ($_POST) ? json_decode($_POST["data"], true) : [];
			$api = new Api($request, $data);
			echo $api->getMethod();
			break;
		default:
			$webModel = new Web();
			$view = $webModel->getView($request);
			require $view;
			break;
	}
?>