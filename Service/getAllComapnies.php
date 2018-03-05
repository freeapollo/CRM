<?php

header("Access-Control-Allow-Origin: *");	
require_once("../Controller/StaticDBCon.php");
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
$responseArr = array();

if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["details"] = $conn->connect_error;
	exit(json_encode($responseArr["details"]));
}
mysqli_set_charset($conn,"utf8");
$getAllCompaniesSql = "SELECT id,name FROM company";
$result = mysqli_query($conn, $getAllCompaniesSql);

if (mysqli_num_rows($result) > 0) {
	$responseArr["result"] = true;
	$responseArr["details"] = array();
	// output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        array_push($responseArr["details"],$row);
    }
	echo json_encode($responseArr);
	
} else {
    $responseArr["result"] = false;
	$responseArr["details"] = "No Data Found";
	echo json_encode($responseArr);
}



?>