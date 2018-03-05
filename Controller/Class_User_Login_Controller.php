<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("../Models/Class_User.php");
require_once("StaticDBCon.php");
 header("Access-Control-Allow-Origin: *");
 
class UserLoginController{

            public function getUser($userName,$password){
				$nowTime = date("Y-m-d H:i:s");
                $usr = new User("0","","","","","","","","","");
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT * FROM user where email='".$userName."' and password='".$password."' limit 1;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                	$userId = '';	
                    while($row = $result->fetch_assoc()) {
                        $usr = new User($row["id"],$row["name"],$row["department"],$row["hireDate"],$row["dob"],$row["gender"],$row["homeAddress"],$row["email"],$row["phone"],$row["profilePic"]);  
                        $usr->isSignedIn = TRUE;
                        $usr->message = "Signin Success!";
                        $userId = $row['id'];
                    }
					
			$insertTimeSql = "UPDATE user SET lastactive = '".$nowTime."' WHERE id=".$userId;
			$conn->query($insertTimeSql);
					
					
                } else {
                    $usr = new User("","","","","","","","","","");
                    $usr->isSignedIn = FALSE;
                    $usr->message = "Signin Failed!";
                }
                $conn->close();
                return $usr;
            }	

            public function getUserJson($userName,$password){
                $usr = $this->getUser($userName,$password);
                $jsonStr = "";
                if ($usr->isSignedIn) {
                    $jsonStr = '{"responce":true,';
                    $jsonStr.='"name":"'.$usr->getName().'",';
                    $jsonStr.='"id":"'.$usr->getId().'",';
                    $jsonStr.='"department":"'.$usr->getDepartment().'",';
                    $jsonStr.='"hireDate":"'.$usr->getHireDate().'",';
                    $jsonStr.='"dob":"'.$usr->getDob().'",';
                    $jsonStr.='"gender":"'.$usr->getGender().'",';
                    $jsonStr.='"homeAddress":"'.$usr->getHomeAddress().'",';
                    $jsonStr.='"email":"'.$usr->getEmail().'",';
                    $jsonStr.='"profilePic":"'.$usr->getProfilePic().'",';
                    $jsonStr.='"phone":"'.$usr->getPhone().'"}';
                }  else {
                    $jsonStr = '{"responce":false,';
                    $jsonStr.='"message":"'.$usr->getMessage().'"}';
                }
                return $jsonStr;

            }
        
        
	public function addUser($name, $department, $hireDate, $dob, $gender, $homeAddress, $email, $phone, $profilePic, $password){
           
 $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            $usr = new User("","","","","","","","","","");
   
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
		
            $sql = "SELECT * FROM user where email='".$email."' limit 1;";
           
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $usr->isSignedUp = FALSE;
                $usr->message=$email." is already used!";
             
            } else {
                
                $sql = "INSERT INTO user (name, department, hireDate, dob, gender, homeAddress, email, phone, profilePic, password)
                VALUES ('".$name."','".$department."','".$hireDate."','".$dob."','".$gender."','".$homeAddress."','".$email."','".$phone."','".$profilePic."','".$password."')";
                //echo 'Query : '.$sql;
                if ($conn->query($sql) === TRUE) {
                    $usr->isSignedUp = TRUE;
                } else {
                    //echo "Error: " . $sql . "<br>" . $conn->error;
                    $usr->isSignedUp = FALSE;
                    $usr->message="Signup Failed!";
                }
            }
            $conn->close();
            return $usr;
	}	
	
	public function addUserJson($name, $department, $hireDate, $dob, $gender, $homeAddress, $email, $phone, $profilePic, $password){
      
  $usr  = $this->addUser($name, $department, $hireDate, $dob, $gender, $homeAddress, $email, $phone, $profilePic, $password);
		
            if ($usr->isSignedUp) {
                $jsonStr = '{"responce":true}';
            }  else {
                $jsonStr = '{"responce":false,';
                $jsonStr.='"message":"'.$usr->getMessage().'"}';
            }
		
            return $jsonStr;	
	}
}




?>
