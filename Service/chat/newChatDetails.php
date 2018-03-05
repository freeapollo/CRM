<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require_once("../../Controller/StaticDBCon.php");
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$userId = $_GET['userId'];
$nowDateTime = date("Y-m-d H:i:s");
$updateLastActiveSql = "UPDATE user SET lastactive='".$nowDateTime."' WHERE id=".$userId;
//exit($updateLastActiveSql);
mysqli_query($conn, $updateLastActiveSql);


//'SELECT id, fromId, message,toId
//FROM chat2
//WHERE id IN (
//    SELECT MAX(id)
//    FROM chat2
//    WHERE toId ='.$userId.'
//    GROUP BY fromId
//)
//ORDER by id DESC
//';



$responseArr = array();

if(!isset($userId) || empty($userId)){
	$responseArr["result"] = false;
	$responseArr["reason"] = "please prove Userid";
	exit(json_encode($responseArr));
}

//echo $getAllNewChatSql;

$getAllNewChatSql = 'SELECT * FROM chat2 WHERE (toId='.$userId.' AND readed=0) ORDER By id DESC';
$chatResult = mysqli_query($conn, $getAllNewChatSql);

$responseArr["result"] = "true";
$responseArr["chatDetails"] = array();
mysqli_set_charset($conn,"utf8");
if (mysqli_num_rows($chatResult) > 0) {
//echo "asdsad";
    // output data of each row
   
    while($row = mysqli_fetch_assoc($chatResult)) {
    	//print_r($row);
   	$emplSql = "SELECT name,profilePic from user WHERE id=".$row["fromId"];
	$emplResult =  mysqli_query($conn,$emplSql);
	
	
	if (mysqli_num_rows($emplResult) > 0) {
		while($emplRow = mysqli_fetch_assoc($emplResult)) { 
			//print_r($emplRow);
			$row["from_userName"] = $emplRow["name"];
			$row["from_profilePic"] = $emplRow["profilePic"];
		}
	}
	
	
        array_push($responseArr["chatDetails"],$row);
       
    }
  //  echo "asdsad";
   // print_r($responseArr);
  //  echo json_encode($responseArr);
    
} else {
	$responseArr["result"] = false; 
	$responseArr["reason"] = "No New Messages";   
//	echo json_encode($responseArr);
}

$responseArr["usersList"] = array();
$usersList = "SELECT id,name,profilePic,lastactive FROM user WHERE id <>".$userId;
$userListResult = mysqli_query($conn,$usersList);
$nowTime = date("Y-m-d H:i:s");
if (mysqli_num_rows($userListResult) > 0) { 
	while($userRow = mysqli_fetch_assoc($userListResult)) { 
		if(!empty($userRow["lastactive"])) {
			$userLastActiveTime = new DateTime($userRow["lastactive"]);
			$nowDateTime = new DateTime($nowTime);
			$interval = $userLastActiveTime->diff($nowDateTime);
			if($interval->h < 1 && $interval->m < 1) {
				$userRow["status"] = true;
			}
			else {
				$userRow["status"] = false;
			}
			
		}
		else{
			$userRow["status"] = false;
		}
		
		array_push($responseArr["usersList"],$userRow);
	}
	echo json_encode($responseArr);
	
}	
	
else{
	echo json_encode($responseArr);
}

 //echo json_encode($responseArr);
?>
