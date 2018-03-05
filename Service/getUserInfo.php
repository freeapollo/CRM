<?php
	header("Access-Control-Allow-Origin: *");
	$responseArr = array();
	$dats = '';
	$userId = @$_GET['id'];
	require_once("../Controller/StaticDBCon.php");
	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	
	if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}

$sql = "SELECT id,department,dob,email,gender,hireDate,homeAddress,name,phone,profilePic FROM user WHERE id=".$userId;

mysqli_set_charset($conn,"utf8");
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
       // print_r($result);
	$responseArr["result"] = true;
	$responseArr["details"] = array(); 
	while($row = mysqli_fetch_assoc($result)) {
//	print_r($row);
        $responseArr["details"] = $row;
      }
	echo json_encode($responseArr);
} else {
	$responseArr["result"] = false;
	$responseArr["details"] = "user Not found";
    echo (json_encode($responseArr));
}
mysqli_close($conn);
?>