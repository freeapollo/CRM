<?php 
	
	
	ob_start();
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	header("Access-Control-Allow-Origin: *");
	
	$id = @$_GET['id'];
	$members= @$_GET['members'];
	

	require_once("../Controller/Class_Group_Controller.php");
	$controller = new GroupController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->updateGroupJson($id,$members);

	

?>