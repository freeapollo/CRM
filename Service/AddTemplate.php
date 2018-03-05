<?php 
	
	
	 ob_start();
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	header("Access-Control-Allow-Origin: *");
	
	//$id = @$_POST['id'];
	$name = $_POST['name'];
	$html = $_POST['html'];
	$addedBy = $_POST['addedBy'];
	
	

	require_once("../Controller/Class_Template_Controller.php");
	$controller = new TemplateController();
	header('Content-Type: application/json');
	$responseArr = array();
	$responseArr["response"] = true;
	$responseArr["template"] = $controller->addNewTemplateJson($name, $html, $addedBy);
	ob_clean(); 
	echo $controller->addNewTemplateJson($name, $html, $addedBy);
	

?>