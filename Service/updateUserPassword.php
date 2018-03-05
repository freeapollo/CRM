<?php
ob_start();
$userId = @$_GET['id'];
$password =  @$_GET['password'];

require_once("../Controller/StaticDBCon.php");
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Create connection

$responseArr = array();
if (!$conn) {
	$responseArr["result"] = false;
	$responseArr["details"] =  mysqli_connect_error();
    die($responseArr["details"]);
}

$sql = "UPDATE user SET password= ".$password." WHERE id=".$userId ;
ob_clean();
if (mysqli_query($conn, $sql)) {
    $responseArr["result"] = true;
	echo json_encode($responseArr);
} else {
    $responseArr["result"] = false;
	$responseArr["details"] = mysqli_error($conn);
	echo json_encode($responseArr);
  //  echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>