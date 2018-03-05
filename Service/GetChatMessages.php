<?php 
	
	 ob_start();
	//http://localhost/wehnc/Service/GetUserData.php?id=1
	header("Access-Control-Allow-Origin: *");
	
	$fIds = '';
	$fIds = @$_GET['from'];
	$tIds = '';
	$tIds = @$_GET['to'];
	$id = '';
	$id = @$_GET['id'];
	

	require_once("../Controller/Class_Chat_Controller.php");
	$controller = new MessageController();
	header('Content-Type: application/json');
	ob_clean(); 
	echo $controller->getMsgJson($id, $fIds,$tIds);

?>