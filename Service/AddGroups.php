<?php 
	ob_start();
	
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	header("Access-Control-Allow-Origin: *");
	
	$name = @$_GET['name'];
	$details= @$_GET['details'];
	$admin= @$_GET['admin'];
	$members= @$_GET['members'];
	$membersCount= @$_GET['membersCount'];
	$createdOn= @$_GET['createdOn'];
	

	require_once("../Controller/Class_Group_Controller.php");
	$controller = new GroupController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->addGroupJson($name,$details,$admin,$members,$createdOn);

	

?>