<?php 
	
	//http://localhost/wehnc/Service/GetUserData.php?id=1
error_reporting(E_ALL);
ini_set('display_errors', 1);
	header("Access-Control-Allow-Origin: *");
	ob_start();
	$dats = '';
	$dats = @$_GET['id'];
	

	require_once("../Controller/Class_Group_Controller.php");
	$controller = new GroupController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->getGroupJson($dats);

?>