<?php

require_once("../Models/Class_Group.php");
require_once("../Controller/StaticDBCon.php");

require_once("../Models/Class_User.php");

require_once("../Models/Class_Employee.php");

require_once("../Models/Message.php");
$fromUserInfoArr = array();
		
class MessageController{
	
	public function getMsgList($id,$from,$to){
		
		$msgList = array();
		$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
		if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
		}
		
		$getFromInfoSql = "SELECT name,profilePic from user WHERE id=".$from;
		$getFromInfoResult = $conn->query($getFromInfoSql);
		if($getFromInfoResult->num_rows > 0) {
			while($userRow = $getFromInfoResult->fetch_assoc()) { 
				//print_r($userRow);
				$fromUserInfoArr["from_userName"] = $userRow["name"];
				$fromUserInfoArr["from_profilePic"] = $userRow["profilePic"];
			}
		}
		
		if($id==''){
			$sql = "SELECT * FROM ".StaticDBCon::$dbname.".chat2  where (fromId='".$from."' AND toId='".$to."') OR (fromId='".$to."' AND toId='".$from."');";
		}else{
			$sql = "SELECT * FROM ".StaticDBCon::$dbname.".chat2  where ((fromId='".$from."' AND toId='".$to."') OR (fromId='".$to."' AND toId='".$from."')) AND id>".$id.";";
		   // echo 'Query : '.$sql;
		}
		$result = $conn->query($sql);
		//echo $sql.' id : '.$id;
		if ($result->num_rows > 0) {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$row["fromUserName"] = $fromUserInfoArr["from_userName"];
				$row["profilePic"] = $fromUserInfoArr["profilePic"];
				$messsage = new Message($row["id"], $row["fromId"], $row["toId"], $row["message"],$row["time"],$row["readed"],$row["fromUserName"],$row["profilePic"]);
				$msgList[$i]= $messsage;
				$i++;
			}
		} else {
				
		}
		$conn->close();
		return $msgList;
	}	
	
	
	
	public function getMsgJson($id,$from,$to){
            //echo "id : ".$id;
		$MsgList = $this->getMsgList($id,$from,$to);
		$jsonStr = '{"Messages":[';
		$i=count($MsgList);
		foreach($MsgList as $msg){
			//	print_r($msg);
			$jsonStr.='{';
			$jsonStr.='"id":"'.$msg->getId().'",';
			$jsonStr.='"message":"'.$msg->getMessage().'",';
			$jsonStr.='"fromId":"'.$msg->getFrom().'",';
			$jsonStr.='"toId":"'.$msg->getTo().'",';
			$jsonStr.='"from_userName":"'.$msg->fromUserName.'",';
			$jsonStr.='"profilePic":"'.$msg->profilePic.'",';
			$jsonStr.='"readed":"'.$msg->isMessageReaded.'",';
			$jsonStr.='"time":"'.$msg->getTimestamp().'"}';
			$i--;
			if($i!=0){
				$jsonStr.=',';
			}
		}
		$jsonStr.=']}';

		return $jsonStr;
	
	}
	
	  
	public function addNewMessage($msgS,$from,$to){
		$date = new DateTime();
		$time = $date->getTimestamp();
		$membersCount="";
		$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
		$msg = new Message(0,"","","","","","");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
			$read = 0;
			$sql = "INSERT INTO ".StaticDBCon::$dbname.".chat2 (fromId,toId,message,time,readed)
			VALUES ('".$from."','".$to."','".$msgS."','".$time."',".$read.")";
			//echo 'Query : '.$sql;
			if ($conn->query($sql) === TRUE) {
				$msg->isMessageAdded = TRUE;
				$msg->id = mysqli_insert_id($conn);
			} else {
				//echo "Error: " . $sql . "<br>" . $conn->error;
				$msg->isMessageAdded = FALSE;
				$msg->returnMsg ="Something went wrong";
			}
		
		$conn->close();
		return $msg;
	}	
	
	public function addMessageJson($msg,$from,$to){
            $msg  = $this->addNewMessage($msg,$from,$to);
            if ($msg->isMessageAdded) {
                $jsonStr = '{"responce":true,"msgId":'.$msg->id.'}';
            }  else {
                $jsonStr = '{"responce":false}';
                $jsonStr.='"message":"'.$msg->returnMsg.'"}';
            }
            return $jsonStr;	
	}
        
        
        
        
}




?>