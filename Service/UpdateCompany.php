<?php 
	
	
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	ob_start();
	header("Access-Control-Allow-Origin: *");
	
	$id = @$_GET['id'];
	$name = @$_GET['name'];
	$areaOfWork = @$_GET['areaOfWork'];
	$establised = @$_GET['establised'];
	$employees = @$_GET['employees'];
	$revenue = @$_GET['revenue'];
	$ofcAddress = @$_GET['ofcAddress'];
	$email = @$_GET['email'];
	$phone = @$_GET['phone'];
	$fb = @$_GET['fb'];
	$tw = @$_GET['twitter'];
	$ln = @$_GET['ln'];
	$extra = @$_GET['extra'];
	
	
	

	require_once("../Controller/Class_Company_Controller.php");
	$controller = new CompanyController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->updateCompanyJson($id, $name, $areaOfWork, $establised, $employees, $revenue, $ofcAddress, $email, $phone,$fb,$tw,$ln,$extra);

?>