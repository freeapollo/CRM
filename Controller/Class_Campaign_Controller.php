<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("../Models/Class_Campaign.php");
require_once("../Controller/StaticDBCon.php");

require_once("../Controller/EmailMgr.php");
require_once("mailChimpService.php");
require_once("mailChimpConfig.php");
header("Access-Control-Allow-Origin: *");

class CampaignController{

        public function getCampaignList($id){
                $resp = "";
                $emailList = array();
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                } 
                if($id==''){
                        $sql = "SELECT * FROM campaign;";
                }else{
                        $sql = "SELECT * FROM campaign where id='".$id."';";
                }
                $result = $conn->query($sql);
                //echo $sql.' id : '.$id;
                if ($result->num_rows > 0) {
                        $i = 0;
                        while($row = $result->fetch_assoc()) {
                            //echo $row['name'];
                                $mail = new Campaign($row['id'], $row['name'], $row['createdBy'], $row['emails'], $row['subject'], $row['body'], $row['recievedBy'], $row['dates'], $row['replacingContent'],$row['templateId'],$row['groupId']);
                                $mailList[$i]=$mail;
                                //echo $compList[$i]->getName();
                                $i++;

                        }
                } else {
                        //echo "0 results";
                }
                $conn->close();
                //$resp = json_encode($mailList);
                return $mailList;
        }	



        public function getCampaignJson($id){
                //echo "id : ".$id;
            $List = $this->getCampaignList($id);

            $jsonStr = '{"camp":[';
            $i=count($List);
            foreach($List as $grp){
                $jsonStr.='{';
                $jsonStr.='"id":"'.$grp->id.'",';
                $jsonStr.='"name":"'.$grp->name.'",';
                $jsonStr.='"createdBy":"'.$grp->createdBy.'",';
                $jsonStr.='"emails":"'.$grp->emails.'",';
                $jsonStr.='"subject":"'.$grp->subject.'",';
                $jsonStr.='"html":"'.urlencode ($grp->body).'",';
                $jsonStr.='"recievedBy":"'.$grp->recievedBy.'",';
                //$jsonStr.='"groupId":"'.$grp->@groupId.'",';
                $jsonStr.='"tempId":"'.$grp->tempId.'",';
                $jsonStr.='"createdOn":"'.$grp->dates.'"}';
                $i--;
                if($i!=0){
                    $jsonStr.=',';
                }
            }
            $jsonStr.=']}';

            return $jsonStr;

        }




            public function addNewCampaign($name,$createdBy,$emails,$subject,$body,$recievedBy,$dates,$templateId,$groupId,$segId){
                    $date = new DateTime();
                    $time = $date->getTimestamp();
                    $membersCount="";

                    $mailChimpService = new MailChimpService();
                    $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
                    $mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
                    $fromName = MailChimpConfig::$emailFromName;
                    $replyTo = MailChimpConfig::$emailReplyTo;
                    $toName = MailChimpConfig::$emailToName;
                    $templateId = MailChimpConfig::$emailTemplateId;
                    $list_id = $mailChimpService->list_id = getenv('mailChimpListId');
                    $title = "";

                    ob_start();
                    $createCamReq = $mailChimpService->createCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$list_id,(int)$segId,$subject,$body,$title,$fromName,$replyTo,$toName,(int)$templateId);
                    //echo $createCamReq;
                    $createCamReq = ob_get_clean();
                    ob_flush();
                    //echo $createCamReq;
                    //print_r(json_decode($createCamReq));

                    $createCamReqArr = array();
                    $createCamReqArr = $createCamReq === NULL ? array() : json_decode($createCamReq,true);
                    $mcCampId = array_key_exists("id",$createCamReqArr) ? $createCamReqArr["id"] : NULL;
                    //exit();
                    ob_start();
                    $runCampReq = $mailChimpService->runCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$mcCampId);
                  
                    $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                    $msg = new Campaign("", "", "", "", "", "", "", "", "", "", "");
                    if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                    }
                   
                    $read = 0;
                    $sql = "INSERT INTO ".StaticDBCon::$dbname.".campaign(name,createdBy,emails,subject,body,recievedBy,dates,replacingContent,templateId,groupId,campaignId,segId)
                    VALUES ('".$name."','".$createdBy."','".$emails."','".$subject."','".$body."','".$recievedBy."','".$dates."','','".$templateId."','".$groupId."','".$mcCampId."','".$segId."')";
                    //echo 'Query : '.$sql;
                    if ($conn->query($sql) === TRUE) {
                            $msg->isAdded = TRUE;
                            $msg->id = mysqli_insert_id($conn);
                            $msg->msg = "Added Successfully!";
                    } else {
                            //echo "Error: " . $sql . "<br>" . $conn->error;
                            $msg->isAdded = FALSE;
                            $msg->msg ="Something went wrong";
                    }

                    $conn->close();
                    return $msg;
            }	

            public function addNewCampaignJson($name,$createdBy,$emails,$subject,$body,$recievedBy,$dates,$templateId,$groupId,$segId){
                $msg  = $this->addNewCampaign($name,$createdBy,$emails,$subject,$body,$recievedBy,$dates,$templateId,$groupId,$segId);
                if ($msg->isAdded) {
                    $jsonStr = '{"responce":true,'
                            . '"id":'.$msg->id
                            . '}';
                }  else {
                    $jsonStr = '{"responce":false,';
                    $jsonStr.='"message":"'.$msg->msg.'"}';
                }
                return $jsonStr;	
            }


}


?>