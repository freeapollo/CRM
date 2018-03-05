<?php 
	
	ob_start();
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	header("Access-Control-Allow-Origin: *");
	
	$id = @$_GET['id'];
	$name = @$_GET['name'];
	$title = @$_GET['title'];
	$industry = @$_GET['industry'];
	$location = @$_GET['location'];
	$ratings = @$_GET['ratings'];
	$companyId = @$_GET['companyId'];
	$skype = @$_GET['skype'];
	$age = @$_GET['age'];
	$gender = @$_GET['gender'];
	$officePhone = @$_GET['officePhone'];
	$jobRole = @$_GET['jobRole'];
	$phone = @$_GET['phone'];
	$email = @$_GET['email'];
	$linkedin = @$_GET['linkedin'];
	$twitter = @$_GET['twitter'];
	$facebook = @$_GET['facebook'];
	$notes = @$_GET['notes'];
	$imgUrl = @$_GET['imgUrl'];
	$companyName = @$_GET['companyName']; 
	$extra = @$_GET['extra'];
	

	require_once("../Controller/Class_Employees_Controller.php");
	$controller = new EmployeesController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->updateEmployeeJson($id,$name,$title,$industry,$location,$ratings,$companyId,$skype,$age,$gender,$officePhone,$jobRole,$phone,$email,$linkedin,$twitter,$facebook,$notes,$imgUrl,$companyName,$extra);

	

?>