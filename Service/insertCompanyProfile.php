<?php

header("Access-Control-Allow-Origin: *");	
require_once("../Controller/StaticDBCon.php");
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
$responseArr = array();
if($conn->connect_error) {
	$responseArr["result"] = false;
	$responseArr["details"] = $conn->connect_error;
	exit(json_encode($responseArr));
}
//echo "Hi";
$emplData = json_decode($_POST['data'],true);
//print_r($emplData);	
$name = $emplData["name"];
//echo "this is name".$name." - ".$email;
$areaOfWork = $emplData["areaOfWork"];
$established = $emplData["established"];
$employees = $emplData["employees"];
$revenue = $emplData["revenue"];
$ofcAddress = $emplData["ofcAddress"];
$email = $emplData["email"];
$phone = $emplData["phone"];
$logo = "";
$facebook = $emplData["fb"];
$twitter = $emplData["twitter"];
//echo $facebook;
$notes = $emplData["notes"];
$imageUrl = "";
//echo "Hello";
if(!isset($name) || empty($name) || !isset($email) || empty($email)) {
	$responseArr["result"] = false;
	$responseArr["details"] = "please enter name and emailId";
	exit(json_encode($responseArr));
}
//check duplicate email address

$checkEmailSql = "SELECT email from company WHERE email='".$email."'";
//echo $checkEmailSql;
$emailResult = mysqli_query($conn, $checkEmailSql);

if (mysqli_num_rows($emailResult) > 0) {
	//echo "email address exits";
	$responseArr["result"] = false;
	$responseArr["details"] = "Email address Already Exists";
	exit(json_encode($responseArr));
}

//echo "after title and email";
$insertEmplProfile = "INSERT INTO company ( name, areaOfWork, establised, employees, ofcAddress, email, phone, logo, fb,  tw,revenue) VALUES('".$name."','".$areaOfWork."','".$established."','".$employees."','".$ofcAddress."','".$email."','".$phone."','".$logo."','".$facebook."','".$twitter."','".$revenue."')";
//echo $insertEmplProfile;
if (mysqli_query($conn, $insertEmplProfile)) {
	
	$companyId = mysqli_insert_id($conn);
	$responseArr["result"] = true;
	$responseArr["companyId"] = $companyId;
	echo json_encode($responseArr);
	
	if(isset($_FILES['image'])){
	  
		$file_name =  $_FILES['image']['name']; 
		$file_tmp = $_FILES['image']['tmp_name'];

		$uploadDirPath = "../uploads/";
		$proPicFolder = "../uploads/profilepic";

		if (!file_exists($proPicFolder)) {
			mkdir($proPicFolder);
		}

		$emplFolder = $proPicFolder."/company";

		if (!file_exists($emplFolder)) {
		mkdir($emplFolder);
		}

		$emplIdFolder = $emplFolder."/".$companyId;
		if (!file_exists($emplIdFolder)) {
		mkdir($emplIdFolder, 0777, true);
		}
		$emplIdFolderPath = "uploads/profilepic/company/".$companyId."/";
		$fileUrl = $emplIdFolderPath; 	
		  
		$updateEmplProfilePicSql = "UPDATE company SET logo = '".$fileUrl.$file_name."' WHERE id=".$companyId;
		
		if (mysqli_query($conn, $updateEmplProfilePicSql)) { 
			
			move_uploaded_file($file_tmp,$emplIdFolder."/".$file_name);  
		
		}
		
	}
	
} else {
   	$responseArr["result"] = false;
	echo json_encode($responseArr);
}
?>