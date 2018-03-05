<?php
require_once("../../Controller/StaticDBCon.php");
//echo "hello";
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$chatId = $_GET['chatId'];
$fromId = $_GET['fromId'];
$chatReadSql = 'UPDATE chat2 SET readed = 1 WHERE id <='.$chatId.' AND fromId ='.$fromId;
//echo $chatReadSql."</br>";
//exit($chatReadSql);
$reponseArr = array();

if(!isset($chatId ) || empty($chatId )){
	$reponseArr["result"] = false;
	$reponseArr["reason"] = "please prove chat Id";
	exit(json_encode($reponseArr));
}

//echo $getAllNewChatSql;
if(mysqli_query($conn, $chatReadSql)){
//echo "if sdfdsf";
$responseArr = array();
	$responseArr["result"] = "true";
	//echo ($response);
	echo json_encode($responseArr);
}
else{
//echo "else";
	$reponseArr["result"] = "false";
	echo json_encode($responseArr);
//echo "wefewf";
}

?>