<?php 
	 ob_start();
	
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	header("Access-Control-Allow-Origin: *");
	
	$from = @$_GET['from'];
	$msg = @$_GET['msg'];
	$to = @$_GET['to'];
	

	require_once("../Controller/Class_Chat_Controller.php");
	$controller = new MessageController();
	header('Content-Type: application/json');
	 
	ob_clean();
	echo $controller->addMessageJson($msg, $from,$to);

	

?>