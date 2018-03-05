<?php 
	
	
	
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	ob_start();
	
	$dats = '';
	$dats = @$_GET['id'];
	

	require_once("../Controller/Class_Employees_Controller.php");
	$controller = new EmployeesController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->getEmployeeNameJson($dats);

	

?>