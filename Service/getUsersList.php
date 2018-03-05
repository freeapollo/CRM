<?php 
	require_once("./../Controller/StaticDBCon.php");
	//http://localhost/wehnc/Service/GetUserData.php?id=1
	header("Access-Control-Allow-Origin: *");
	
	 $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                } 
              

	$userId = $_GET['id']; 
	$sql = "SELECT name , email ,id from user WHERE id <> ".$userId;
	//echo $sql;
	mysqli_set_charset($conn,"utf8");
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	  //  print_r($result);
	    $responseArr = array();
	    $responseArr["response"] = "true";
	    $responseArr["details"] = array();
	    while($row = mysqli_fetch_assoc($result)) {
	    	//print_r($row);
	    	array_push($responseArr["details"],$row);
	    }
	    //print_r($responseArr);
	    echo json_encode($responseArr);
	  //  echo "asdads";
	    
	} else {
	
	//ob_clean();
		$responseArr["response"] = false;
		echo json_encode($responseArr);
	}
	
	mysqli_close($conn);
	
?>