<?php
require_once("./../StaticDBCon.php");
// Create connection
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "ALTER TABLE `campaign` ADD `campaignId` VARCHAR(100) NULL AFTER `groupId`;";

if ($conn->query($sql) === TRUE) {
    echo "groupId column successfully added <br/>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql2 = "ALTER TABLE `campaign` ADD `segId` VARCHAR(100) NULL AFTER `campaignId`;";
if ($conn->query($sql2) === TRUE) {
    echo "campaign Id column successfully added <br/>";
} else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
}
$conn->close();
?>