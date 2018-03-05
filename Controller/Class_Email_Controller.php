<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("../Models/Class_Email.php");
require_once("../Controller/StaticDBCon.php");
 header("Access-Control-Allow-Origin: *");
class EmailController{
	
	public function getEmailList($id){
		$resp = "";
		$emailList = array();
		$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		if($id==''){
			$sql = "SELECT * FROM mail;";
		}else{
			$sql = "SELECT * FROM mail where id='".$id."';";
		}
		$result = $conn->query($sql);
		//echo $sql.' id : '.$id;
		if ($result->num_rows > 0) {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$mail = new Email($row['id'], $row['sender'], $row['reciever'], $row['subject'], $row['body'], $row['name'], $row['mailKey']);
				$mailList[$i]=$mail;
				//echo $compList[$i]->getName();
				$i++;
			}
		} else {
			//echo "0 results";
		}
		$conn->close();
                $resp = json_encode($mailList);
		return $resp;
	}	
	
	
	
	public function getEmailJson($id){
		//echo "id : ".$id;
		$CompList = $this->getEmailList($id);
		$jsonStr = '{"Users":'
                        . $this->getEmailList($id)
                        . '}';
		
		return $jsonStr;
		
	}
	
	
}




?>