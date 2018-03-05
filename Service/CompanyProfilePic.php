<?php 
	//echo "top";
	require_once("../Controller/Class_Company_Controller.php");
	
	require_once("../Controller/Class_Employees_Controller.php");
require_once("../Controller/StaticDBCon.php");
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
$responseArr = array();
	
	//http://localhost/wehnc/Service/GetUserData.php?id=1
	//echo "up hello".$id.$path;
	
	$dats = '';
	$id = @$_POST['id'];
	$path = @$_POST['fileName'];
	header("Access-Control-Allow-Origin: *");
	
   if(isset($_FILES['image'])){
   
   	//echo "if isset files image ".$id.$path;
	   $extt = $_FILES['image']['name'];
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      //$file_ext=strtolower(end(explode('.',$extt)));
      $expensions= array("jpeg","jpg","png");
      
      if($file_size > 209715002){
     // echo "big file ".$id.$path;
         $errors[]='File size must be excately 20 MB';
      }
      
      if(empty($errors)==true){
      
		$file_name =  $_FILES['image']['name']; 
		$file_tmp = $_FILES['image']['tmp_name'];

		$uploadDirPath = "../uploads/";
		$proPicFolder = "../uploads/profilepic";

		if (!file_exists($proPicFolder)) {
			mkdir($proPicFolder);
		}

		$emplFolder = $proPicFolder."/company";

		if (!file_exists($emplFolder)) {
		mkdir($emplFolder);
		}

		$emplIdFolder = $emplFolder."/".$id;
		if (!file_exists($emplIdFolder)) {
		mkdir($emplIdFolder, 0777, true);
		}
		$emplIdFolderPath = "uploads/profilepic/company/".$id."/";
		$fileUrl = $emplIdFolderPath; 	
		  
		$updateEmplProfilePicSql = "UPDATE company SET logo = '".$fileUrl.$file_name."' WHERE id=".$id;
		
		if (mysqli_query($conn, $updateEmplProfilePicSql)) { 
			
			move_uploaded_file($file_tmp,$emplIdFolder."/".$file_name);  
			$responseArr["result"] = true;
			$responseArr["details"] = "file Uploaded successfully";
		}else{
			$responseArr["result"] = true;
			$responseArr["details"] = mysqli_error($conn);
		}
			
		echo json_encode($responseArr);
   
      }else{
			
			$responseArr["result"] = false;
			$responseArr["details"] = "Error Occured";
			echo json_encode($responseArr);
      }  
   }
?>