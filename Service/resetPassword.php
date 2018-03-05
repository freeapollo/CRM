<?php
ob_start();
$email =  @$_GET['email'];

require_once("../Controller/StaticDBCon.php");
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Create connection

$responseArr = array();
if (!$conn) {
	$responseArr["result"] = false;
	$responseArr["details"] =  mysqli_connect_error();
    die($responseArr["details"]);
}

if(!isset($email) || empty($email)) {
	$responseArr["result"] = false;
	$responseArr["details"] =  "Please enter Email Id";
    die($responseArr["details"]);
}

// code for random alpha numeric string generator
$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
$code = '';
$max = strlen($characters) - 1;
for ($i = 0; $i < $random_string_length; $i++) {
  $code .= $characters[mt_rand(0, $max)];
}
// code for random alpha numeric string generator

// insert random string into database
ob_clean();
$sql = "UPDATE user SET forgetpasscode= ".$code." WHERE email=".$email;
if (mysqli_query($conn, $sql)) {
	
	$to = $email;
	$subject = "Re: Reset Password";

	$message = "<div><div>Please Click on Below Link to reset your password.</div>";
	$message .= "<div><a href='".$_SERVER['SERVER_NAME']."/views/resetPassword/".$code."'/></div></div>";

	$header = "From:support@jaiswal.com \r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";

	$retval = mail ($to,$subject,$message,$header);

	if( $retval == true ) {
		$responseArr["result"] = true;
		$responseArr["details"] = "Please check your Inbox or Spam to reset your Password";
		echo json_encode($responseArr);
	}else {
		$responseArr["result"] = false;
		$responseArr["details"] = "mail Function failed";
		echo json_encode($responseArr);
	}


	
} else {
    $responseArr["result"] = false;
	$responseArr["details"] = mysqli_error($conn);
	echo json_encode($responseArr);
  //  echo "Error updating record: " . mysqli_error($conn);
}
//



mysqli_close($conn);
?>  

		
		
		