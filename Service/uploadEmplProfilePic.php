<?php 
	
	//http://localhost/wehnc/Service/GetUserData.php?id=1
	
	ob_start();
	header("Access-Control-Allow-Origin: *");
	$responseArr = array();
	$dats = '';
	$emplId = @$_POST['id'];
	require_once("../Controller/StaticDBCon.php");
	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	
	if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}

	ob_clean();
	
	if(isset($_FILES['image'])){
	  $extt = $_FILES['image']['name'];
      $errors= array();
	  $path_info = pathinfo($_FILES['image']['name']);
	  //echo $path_info['extension'];
	  $file_name = $_FILES['image']['name'];
	  
      $file_size =$_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type= $_FILES['image']['type'];
      //$file_ext=strtolower(end(explode('.',$extt)));
   //   $expensions= array("jpeg","jpg","png");
      
       //exit("outside empty");
      if(!empty($file_name)){
		
          $uploadDirPath = "../uploads/";
		  $proPicFolder = "../uploads/profilepic";
		
		  if (!file_exists($proPicFolder)) {
			mkdir($proPicFolder, 0777, true);
		  }
		  
		  $emplFolder = $proPicFolder."/empl";
		  
		  if (!file_exists($emplFolder)) {
			mkdir($emplFolder, 0777, true);
		  }
		  
		  $emplIdFolder = $emplFolder."/".$emplId;
		  if (!file_exists($emplIdFolder)) {
			mkdir($emplIdFolder, 0777, true);
		  }
		  $emplIdFolderPath = "uploads/profilepic/empl/".$emplId."/";
		  $fileUrl = $emplIdFolderPath;
         	
		  
	  $updateEmplProfilePicSql = "UPDATE employee SET imgUrl = '".$fileUrl.$file_name."' WHERE id=".$emplId;
		//exit($updateEmplProfilePicSql);
	//exit();  
      if (mysqli_query($conn, $updateEmplProfilePicSql)) { 
		//exit("hello");		
		$ifuploaded = move_uploaded_file($file_tmp,$emplIdFolder."/".$file_name);
	      $responseArr["upload"] = $ifuploaded;
	   $responseArr["result"] = true;
	   $responseArr["details"] = array();
	   $responseArr["details"]["domainName"] = $_SERVER['SERVER_NAME'];
	   $responseArr["details"]["imageUrl"] =  $fileUrl.$file_name;
	   echo json_encode($responseArr); 
	 
	  }
	  else{
			$responseArr["result"] = false;
			$responseArr["details"] = mysqli_error($conn);
			echo json_encode($responseArr); 
	  }
   }
   else{
		$responseArr["result"] = false;	
		$responseArr["details"] = "file Name empty";
		echo json_encode($responseArr);
	   
   }
   
	}
	else{
		$responseArr["result"] = false;
		$responseArr["details"] = "server is down";
		echo json_encode($responseArr);
	}
	
?>