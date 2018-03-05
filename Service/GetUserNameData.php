<?php 
	
	//http://localhost/wehnc/Service/GetUserData.php?id=1
	
	ob_start();
	$dats = '';
	$dats = @$_GET['id'];
	

	require_once("../Controller/Class_User_Controller.php");
	$controller = new UserController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->getUserNameJson($dats);

?>