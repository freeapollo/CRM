<?php
 header('Access-Control-Allow-Origin: *');  
   if(isset($_FILES['image'])){
	   $name = $_POST['fileName'];
	   $userId = $_POST['userId'];
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      $name.=".".$file_ext;
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      print_r($name);
      if($file_size > 209715002){
         $errors[]='File size must be excately 20 MB';
         $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
		$msg = new Employees(0,"","","","","","","","","","","","","","","","","","","");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
			$read = 0;
			
			
	$sql = "UPDATE `employees` SET imgUrl` = '".$name ."' WHERE id = ".$userId."";
			//echo 'Query : '.$sql;
			if ($conn->query($sql) === TRUE) {
				$msg->isUpdateSuccess = TRUE;
				$msg->id = mysqli_insert_id($conn);
			} else {
				//echo "Error: " . $sql . "<br>" . $conn->error;
				$msg->isUpdateSuccess = FALSE;
				$msg->outMessage ="Something went wrong";
			}
		
		$conn->close();
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"Files/".$name);
         //echo "Success";
      }else{
         print_r($errors);
      }
      
      if ($msg->isUpdateSuccess) {
	$jsonStr = '{"responce":true}';
	}  else {
		$jsonStr = '{"responce":false,';
		$jsonStr.='"message":"'.$msg->outMessage.'"}';
	}
	echo $jsonStr;	
      
   }
?>