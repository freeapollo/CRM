<?php

	header("Access-Control-Allow-Origin: *");
	require_once("./../StaticDBCon.php");
	
	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}

	$sql = "SELECT * FROM `smscampaign` ";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	        echo json_encode($row);
	    }
	} else {
		$responseArr["result"] = false;
		$responseArr["details"] = mysqli_error($conn);
	    echo json_encode($responseArr);
	}

	mysqli_close($conn);

?>