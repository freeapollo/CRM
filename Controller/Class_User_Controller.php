<?php

require_once("../Models/Class_User.php");

require_once("../Controller/StaticDBCon.php");

class UserController{
	
	public function getUserList($id){
		
		$usrlList = array();
		$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
		if($id==''){
			$sql = "SELECT * FROM user;";
		}else{
			$sql = "SELECT * FROM user where id='".$id."';";
		}
		
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$usr = new User($row["id"],$row["name"],$row["department"],$row["hireDate"],$row["dob"],$row["gender"],$row["homeAddress"],$row["email"],$row["phone"],$row["profilePic"]);
				$usrlList[$i]=$usr;
				//echo $usrlList[$i]->getName();
				$i++;
			}
		} else {
			echo "0 results";
		}
		$conn->close();
		return $usrlList;
	}	
	
	public function getUserJson($id){
		$UserList = $this->getUserList($id);
		$jsonStr = '{"Users":[';
		$i=count($UserList);
		foreach($UserList as $usr){
			$jsonStr.='{';
			$jsonStr.='"name":"'.$usr->getName().'",';
			$jsonStr.='"department":"'.$usr->getDepartment().'",';
			$jsonStr.='"hireDate":"'.$usr->getHireDate().'",';
			$jsonStr.='"dob":"'.$usr->getDob().'",';
			$jsonStr.='"gender":"'.$usr->getGender().'",';
			$jsonStr.='"homeAddress":"'.$usr->getHomeAddress().'",';
			$jsonStr.='"email":"'.$usr->getEmail().'",';
			$jsonStr.='"profilePic":"'.$usr->getProfilePic().'",';
			$jsonStr.='"phone":"'.$usr->getPhone().'"}';
			$i--;
			if($i!=0){
				$jsonStr.=',';
			}
		}
		$jsonStr.=']}';
		
		return $jsonStr;
		
	}
	
	
	
	public function getUserNameList($id){
		
		$usrlList = array();
		$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
		if($id==''){
			$sql = "SELECT * FROM user;";
		}else{
			$sql = "SELECT * FROM user where id='".$id."';";
		}
		
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$usr = new User($row["id"],$row["name"],$row["department"],$row["hireDate"],$row["dob"],$row["gender"],$row["homeAddress"],$row["email"],$row["phone"],$row["profilePic"]);
				$usrlList[$i]=$usr;
				//echo $usrlList[$i]->getName();
				$i++;
			}
		} else {
			echo "0 results";
		}
		$conn->close();
		return $usrlList;
	}	
	
	public function getUserNameJson($id){
		$UserList = $this->getUserNameList($id);
		$jsonStr = '{"Users":[';
		$i=count($UserList);
		foreach($UserList as $usr){
			$jsonStr.='{';
			$jsonStr.='"id":"'.$usr->getId	().'",';
			$jsonStr.='"name":"'.$usr->getName().'"}';
			$i--;
			if($i!=0){
				$jsonStr.=',';
			}
		}
		$jsonStr.=']}';
		
		return $jsonStr;
		
	}
	
	
	
}




?>