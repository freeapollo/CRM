<?php 
	
	
	error_reporting(E_ALL);
ini_set('display_errors', '1');
	//Link -> localhost/wehnc/Service/GetEmplData.php
	
	
	//ob_start();	
	$name = @$_GET['name'];
	$department= @$_GET['departmen'];
	$hireDate= @$_GET['hireDate'];
	$dob= @$_GET['dob'];
	$gender= @$_GET['gender'];
	$homeAddress= @$_GET['homeAddres'];
	$email= @$_GET['email'];
	$phone= @$_GET['phone'];
	$profilePic= @$_GET['profilePic'];
	$password= @$_GET['password'];

	require_once("../Controller/Class_User_Login_Controller.php");
      
	$controller = new UserLoginController();
  
	
	header('Content-Type: application/json');
        
	//ob_clean();
	echo $controller->addUserJson($name, $department, $hireDate, $dob, $gender, $homeAddress, $email, $phone, $profilePic, $password);

	

?>
