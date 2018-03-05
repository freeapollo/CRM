<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');	
	 ob_start();
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	 header("Access-Control-Allow-Origin: *");
	
	
	$dats = '';
	$dats = @$_GET['id'];
	

	require_once("../Controller/Class_Campaign_Controller.php");
	$controller = new CampaignController();
	$controller->apiKey = getenv("mailChimpApiKey");
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->getCampaignJson($dats);

	

?>