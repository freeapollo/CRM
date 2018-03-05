<?php
require_once("./../StaticDBCon.php");
// Create connection
$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$createSql = "CREATE TABLE `smscampaign` (
  `id` int(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `groupid` int(100) DEFAULT NULL,
  `infobipresponse` varchar(100) DEFAULT NULL,
  `ibmessageid` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$primaryKeySql = "ALTER TABLE `smscampaign` ADD PRIMARY KEY (`id`);";

$autoIncSql = "ALTER TABLE `smscampaign` MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;";

$varcharToJson = "ALTER TABLE `smscampaign` CHANGE `infobipresponse` `infobipresponse` JSON NULL DEFAULT NULL;";

$timestampcol = "ALTER TABLE `smscampaign` ADD `createdat` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `ibmessageid`;";

if ($conn->query($createSql) === TRUE) {
    echo "sms Campaign Table Created<br/>";
} else {
    echo "Error: " . $createSql . "<br>" . $conn->error;
}

if ($conn->query($primaryKeySql) === TRUE) {
    echo "id made Primary key<br/>";
} else {
    echo "Error: " . $primaryKeySql . "<br>" . $conn->error;
}

if ($conn->query($autoIncSql) === TRUE) {
    echo "auto Inc Added to primary key<br/>";
} else {
    echo "Error: " . $autoIncSql . "<br>" . $conn->error;
}

if ($conn->query($varcharToJson) === TRUE) {
    echo "Infobip response defination changed to json<br/>";
} else {
    echo "Error: " . $varcharToJson . "<br>" . $conn->error;
}

if ($conn->query($timestampcol) === TRUE) {
    echo "Infobip response defination changed to json<br/>";
} else {
    echo "Error: " . $timestampcol . "<br>" . $conn->error;
}

$conn->close();
?>