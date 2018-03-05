<?php
require_once("./../StaticDBCon.php");
// Create connection
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "ALTER TABLE `employee` ADD `isactive` BOOLEAN NOT NULL DEFAULT TRUE AFTER `extra`;";

if ($conn->query($sql) === TRUE) {
    echo "iactive added as column successfully added in Employee table<br/>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>