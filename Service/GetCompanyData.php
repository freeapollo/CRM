<?php 
	
	
	 ob_start();
	//Link -> http://localhost/wehnc/Service/GetCompanyData.php?id=1
	
	 header("Access-Control-Allow-Origin: *");
	
	$dats = 'na';
	$dats = @$_GET['id'];
	
	require_once("../Controller/Class_Company_Controller.php");
	$controller = new CompanyController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->getCompanyJson($dats);

?>