<?php 
	
	//http://localhost/wehnc/Service/GetUserData.php?id=1
	ob_start();
	
	
	$dats = '';
	$id = @$_POST['id'];
	$path = @$_POST['fileName'];
	header("Access-Control-Allow-Origin: *");

	
	require_once("../Controller/Class_Employees_Controller.php");
		
	$controller = new EmployeesController();
	$resp = "";

	
	
	
	
   if(isset($_FILES['image'])){
	   $name = $_POST['fileName'];
	   $extt = $_FILES['image']['name'];
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      //$file_ext=strtolower(end(explode('.',$extt)));
      $expensions= array("jpeg","jpg","png");
      
      if($file_size > 209715002){
         $errors[]='File size must be excately 20 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"../Files/".$name);
		 $resp = $controller->updateEmployeeImageJson($id,$path);
      }else{
         $jsonStr = '{"responce":false,';
			$jsonStr.='"message":"'.$msg->outMessage.'"}';
			$resp = $jsonStr;
      }
	  
	  
	  
	  
	  
	  	header('Content-Type: application/json');
	  	ob_clean();
		echo $resp;  
	  
	  
	  
	  
   }
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	
?>