<?php
	header("Access-Control-Allow-Origin: *");
	require_once("./../StaticDBCon.php");
	
	$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	if($conn->connect_error) {
		$responseArr["result"] = false;
		$responseArr["details"] = $conn->connect_error;
		exit(json_encode($responseArr));
	}

	$smsdata = file_get_contents('php://input');
	$responseArr = array();
	$smsArr = json_decode($smsdata,true);
	$groupid = isset($smsArr["groupid"]) ? $smsArr["groupid"] : "";
	$name = isset($smsArr["name"]) ? $smsArr["name"] : "";
	//echo ($groupid);

	if(sizeof($smsArr > 0)  && array_key_exists("data", $smsArr)  && array_key_exists("messages",$smsArr["data"])) {

		$sql = "INSERT INTO `smscampaign` (name, groupid, infobipresponse) VALUES ('".$name."', '".$groupid."' , '".$smsdata."')";

		if (mysqli_query($conn, $sql)) {
		    $responseArr["result"] = true;
		} else {
			$responseArr["result"] = false;
			$responseArr["details"] = mysqli_error($conn);
		}
		
		echo json_encode($responseArr);

	}
	else {
		$responseArr["result"] = false;
		$responseArr["details"] = "Empty data";
		echo json_encode($responseArr);
	}
	
?>