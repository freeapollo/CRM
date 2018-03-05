<?php 
	//http://localhost/wehnc/Service/GetUserData.php?id=1
	header("Access-Control-Allow-Origin: *");
	require_once("../Controller/StaticDBCon.php");
	
	$dats = '';
	$emplId = @$_GET['id'];
		
	$responseArr = array();
	
	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}
	
	
	if(isset($emplId) && !empty($emplId)){
		
		$getAllFileSql = "SELECT * from cmpyFiles WHERE companyId=".$emplId." AND isactive=1";
		$result = mysqli_query($conn, $getAllFileSql);
		
		if (mysqli_num_rows($result) > 0) {
			$responseArr["details"] = array();	
			$responseArr["result"] = true;	
			
			while($row = mysqli_fetch_assoc($result)) {
				array_push($responseArr["details"],$row);
			}
			
			echo json_encode($responseArr);
			
		} else {
			$responseArr["result"] = false;
			$responseArr["details"] = "No records Found";
			echo json_encode($responseArr);
		}
		
	}
	
	else{
		$responseArr["result"] = false;
		$responseArr["details"] = "Company Id not found";
		echo json_encode($responseArr);
	}
	
?>
	
