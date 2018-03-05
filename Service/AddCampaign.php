<?php 
	
	ob_start();	
	header("Access-Control-Allow-Origin: *");
	
	//$id = @$_POST['id'];
	$name = $_POST['name'];
	$createdBy = $_POST['createdBy'];
	$emails = $_POST['emails'];
	$subject = $_POST['subject'];
	$body = $_POST['body'];
	//$recievedBy = $_POST['recievedBy'];
	$dates = $_POST['dates'];
	$templateId = $_POST['templateId'];
	$groupId = $_POST['groupId'];
	$segId = $_POST['segId'];
	
	require_once("../Controller/Class_Campaign_Controller.php");
	$controller = new CampaignController();
	header('Content-Type: application/json');
	ob_clean();
	echo $controller->addNewCampaignJson($name, $createdBy, $emails, $subject, $body, "", $dates, $templateId,$groupId,$segId);
	

?>