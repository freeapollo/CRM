<?php
require_once("./../StaticDBCon.php");
// Create connection
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "CREATE TABLE `smscampaign` (
  `id` int(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `groupid` int(100) DEFAULT NULL,
  `infobipresponse` text,
  `ibmessageid` varchar(100) DEFAULT NULL,
  `createdat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

if ($conn->query($sql) === TRUE) {
    echo "Table smscampaign successfully Created <br/>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>