<?php 
	
	//http://localhost/wehnc/Service/GetUserData.php?id=1
	
	//ob_start();
	header("Access-Control-Allow-Origin: *");
	$responseArr = array();
	$dats = '';
	$id = @$_POST['id'];
	$userFileName = @$_POST['fileName'];
	require_once("../Controller/StaticDBCon.php");
	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}
	
	  //exit("before If");
    if(isset($_FILES['image'])){
	  $extt = $_FILES['image']['name'];
      $errors= array();
	  $path_info = pathinfo($_FILES['image']['name']);
	  //echo $path_info['extension'];
	  if(isset($userFileName) && !empty($userFileName) && (strlen($userFileName) > 0)) {
		$file_name = $userFileName.".".$path_info['extension'];
	  }
	  else{ 
		$file_name = $_FILES['image']['name'];
	  }
	  
      //$file_name =  $_FILES['image']['name'];
	 
      $file_size =$_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type= $_FILES['image']['type'];
      //$file_ext=strtolower(end(explode('.',$extt)));
   //   $expensions= array("jpeg","jpg","png");
      
       //exit("outside empty");
      if(!empty($file_name)){
		
          $uploadDirPath = "../uploads/";
		  $emplFolder = "../uploads/company";
		  if (!file_exists($emplFolder)) {
			mkdir($emplFolder, 0777, true);
		  }
		  
		  $userIdFolder = $emplFolder."/".$id;
		  if (!file_exists($userIdFolder)) {
				mkdir($userIdFolder, 0777, true);
		  }
		  $userIdFolderPath = "uploads/company/".$id."/";
		  $fileUrl = $userIdFolderPath;
         	
		  
	  $insertUserFileSql = "INSERT into cmpyFiles (companyId,url,name,filesize,isactive,date) VALUES('".$id."','".$userIdFolderPath."','".$file_name."','".$file_size."','1','".date("d-m-Y")."')";
		//echo $insertUserFileSql;
	//exit();  
      if (mysqli_query($conn, $insertUserFileSql)) { 
		//exit("hello");		
		move_uploaded_file($file_tmp,$userIdFolder."/".$file_name);
	      
	   $responseArr["result"] = true;
	   $responseArr["details"] = array();
	   $responseArr["details"]["fileName"] = $file_name;
	   $responseArr["details"]["id"] =  mysqli_insert_id($conn);
	   $responseArr["details"]["filesize"] =  $file_size;
	   $responseArr["details"]["date"] =  date("d-m-Y");
		echo json_encode($responseArr); 
	 
	  }
   }
   else{
		$responseArr["result"] = false;	
		$responseArr["details"] = "error occured";
		echo json_encode($responseArr);
	   
   }
   
	}
	else{
		$responseArr["result"] = false;
		$responseArr["details"] = "server is down";
		echo json_encode($responseArr);
	}
	
?>