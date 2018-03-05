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
$title = $emplData["title"];
$industry = $emplData["industry"];
$location = $emplData["location"];
$rating = $emplData["rating"];
$skype = $emplData["skype"];
$age = $emplData["age"];
$gender = $emplData["gender"];
$officePhone = $emplData["officePhone"];
$jobRole = $emplData["jobRole"];
$email = $emplData["email"];
$linkedin = $emplData["linkedin"];
$twitter = $emplData["twitter"];
$facebook = $emplData["facebook"];
$skype = $emplData["skype"];
$companyId = $emplData["company"];
$companyName = $emplData["companyName"];
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

$checkEmailSql = "SELECT email from employee WHERE email='".$email."'";
//echo $checkEmailSql;
$emailResult = mysqli_query($conn, $checkEmailSql);

if (mysqli_num_rows($emailResult) > 0) {
	//echo "email address exits";
	$responseArr["result"] = false;
	$responseArr["details"] = "Email address Already Exists";
	exit(json_encode($responseArr));
}

//echo "after title and email";
$insertEmplProfile = "INSERT INTO employee ( name, title, industry, location, ratings, age, gender, officePhone, jobRole, email, linkedin, twitter,facebook ,notes,skype, imgUrl,companyId,companyName) VALUES('".$name."','".$title."','".$industry."','".$location."','".$rating."','".$age."','".$gender."','".$officePhone."','".$jobRole."','".$email."','".$linkedin."','".$twitter."','".$facebook."','".$notes."','".$skype."','".$imageUrl."','".$companyId."','".$companyName."')";
//echo $insertEmplProfile;
if (mysqli_query($conn, $insertEmplProfile)) {
	
	$emplId = mysqli_insert_id($conn);
	$responseArr["result"] = true;
	$responseArr["emplId"] = $emplId;
	echo json_encode($responseArr);
	
	if(isset($_FILES['image'])){
	  
		$file_name =  $_FILES['image']['name']; 
		$file_tmp = $_FILES['image']['tmp_name'];

		$uploadDirPath = "../uploads/";
		$proPicFolder = "../uploads/profilepic";

		if (!file_exists($proPicFolder)) {
			mkdir($proPicFolder);
		}

		$emplFolder = $proPicFolder."/empl";

		if (!file_exists($emplFolder)) {
		mkdir($emplFolder);
		}

		$emplIdFolder = $emplFolder."/".$emplId;
		if (!file_exists($emplIdFolder)) {
		mkdir($emplIdFolder, 0777, true);
		}
		$emplIdFolderPath = "uploads/profilepic/empl/".$emplId."/";
		$fileUrl = $emplIdFolderPath; 	
		  
		$updateEmplProfilePicSql = "UPDATE employee SET imgUrl = '".$fileUrl.$file_name."' WHERE id=".$emplId;
		
		if (mysqli_query($conn, $updateEmplProfilePicSql)) { 
			
			move_uploaded_file($file_tmp,$emplIdFolder."/".$file_name);  
		
		}
		
	}
	
} else {
   	$responseArr["result"] = false;
	echo json_encode($responseArr);
}
?>