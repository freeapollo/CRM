<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../Models/Class_Group.php");
require_once("../Controller/StaticDBCon.php");

require_once("../Models/Class_User.php");

require_once("../Models/Class_Employees.php");
//require_once("../Controller/EmailMgr.php");
require_once("mailChimpService.php");
require_once("mailChimpConfig.php");


class GroupController{
    
    public function getGroupList($id){
        
            $groupList = array();
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
            } 
            if($id==''){
                $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group;";
            }else{
                $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group where id='".$id."';";
            }
            $result = $conn->query($sql);
            //echo $sql.' id : '.$id;
            if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    $group = new Group($row["id"], $row["name"], $row["details"], $row["admin"], $row["members"], $row["membersCount"], $row["createdOn"],$row["segId"]);
                    $groupList[$i]=$group;
                    $i++;
                }
            } else {
                    
            }
            $conn->close();
            return $groupList;
    }   
    
    
    
    public function getGroupJson($id){
            //echo "id : ".$id;
            $GroupList = $this->getGroupList($id);
            $jsonStr = '{"Groups":[';
            $i=count($GroupList);
            foreach($GroupList as $grp){
                $jsonStr.='{';
                $jsonStr.='"id":"'.$grp->getId().'",';
                $jsonStr.='"name":"'.$grp->getName().'",';
                $jsonStr.='"details":"'.$grp->getDetails().'",';
                $jsonStr.='"admin":"'.$grp->getAdmin().'",';
                $jsonStr.='"segId":"'.$grp->getSegmentId().'",';
                $jsonStr.=$this->getUserJson($grp->getMembers()).',';
                $jsonStr.='"membersCount":"'.$grp->getMembersCount().'",';
                $jsonStr.='"createdOn":"'.$grp->getCreatedOn().'"}';
                $i--;
                if($i!=0){
                    $jsonStr.=',';
                }
            }
            $jsonStr.=']}';

            return $jsonStr;
        
    }
    
            
    public function getUserList($ids){
        
            $usrlList = array();
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
            } 

            $sql = "SELECT * FROM employee where id in(".$ids.");";
            //echo 'Query: '.$sql;
            ob_start();
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                ob_clean();
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    //$usr = new User($row["id"],$row["name"],$row["department"],$row["hireDate"],$row["dob"],$row["gender"],$row["homeAddress"],$row["email"],$row["phone"],$row["profilePic"]);
                    $empl = new Employees($row["id"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],"",$row["companyId"],$row["skype"],$row["age"],$row["gender"],$row["officePhone"],$row["jobRole"],$row["phone"],$row["email"],$row["linkedin"],$row["twitter"],$row["facebook"],$row["notes"],$row["imgUrl"]);
                     
                    $usrlList[$i]=$empl;
                    //echo $usrlList[$i]->getName();
                    $i++;
                }
            } else {
                ob_clean();
                   // echo "0 results";
            }
            $conn->close();
            return $usrlList;
    }   
    
    public function getUserJson($id){
            $UserList = $this->getUserList($id);
            $jsonStr = '"Members":[';
            $i=count($UserList);
            foreach($UserList as $empl){
                $jsonStr.='{';
                $jsonStr.='"id":"'.$empl->getId().'",';
                $jsonStr.='"CompanyId":"'.$empl->getCompanyId().'",';
                $jsonStr.='"name":"'.$empl->getName().'",';
                $jsonStr.='"title":"'.$empl->getTitle().'",';
                $jsonStr.='"email":"'.$empl->getEmail().'",';
                $jsonStr.='"industry":"'.$empl->getIndustry().'",';
                $jsonStr.='"location":"'.$empl->getLocation().'",';
                $jsonStr.='"phone":"'.$empl->getPhone().'",';
                $jsonStr.='"ratings":"'.$empl->getRatings().'"}';
                $i--;
                if($i!=0){
                    $jsonStr.=',';
                }
            }
            $jsonStr.=']';

            return $jsonStr;
        
    }
        
        
        
        public function addNewGroup($name,$details,$admin,$members,$createdOn){
            $membersCount="";
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            $grp = new Group("","","","","","","");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group where admin='".$admin."' AND name='".$name."' limit 1;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $grp->isGroupAdded = FALSE;
                $grp->message=$name." is already present with the same admin!";
            } else {

                // create SegmentId using MailchimpApi
                $mailChimpService = new MailChimpService();
                $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
                $mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
                $list_id = $mailChimpService->list_id = getenv('mailChimpListId');
                $membersEmailArr = array();
                $log = array();
              //  $log["createSegment"] = array();
                ob_start();
                $createSegReq = $mailChimpService->createSegment($name,$mailChimpSubDomainInit,$membersEmailArr,$list_id,$mailChimpApiKey);
                $createSegReq = ob_get_clean();
                ob_flush();
                $createSegReqArr = $createSegReq === NULL ? array() : json_decode($createSegReq,true);
                
                $segId = array_key_exists("id", $createSegReqArr) ? $createSegReqArr['id'] : NULL;
                $log['createSegment'] = is_null($createSegReq) ? "" : json_decode($createSegReq);
                
                //echo $segId;
               
                //exit();    
               
                $sql = "INSERT INTO ".StaticDBCon::$dbname.".group (name, details, admin, members, membersCount, createdOn,segId)
                VALUES ('".$name."','".$details."','".$admin."','".$members."','".$membersCount."','".$createdOn."','".$segId."')";
                //echo 'Query : '.$sql;
                if ($conn->query($sql) === TRUE) {
                    $grp->isGroupAdded = TRUE;
                   // $res = $emailMgr->addSegment($name);
                   // $re = json_encode($res);
                    $grp->logs = json_encode($log);
                    $grp->id = mysqli_insert_id($conn);
                    $this->updateGroup2($grp->id, $segId);
                } else {
                    //echo "Error: " . $sql . "<br>" . $conn->error;
                    $grp->isGroupAdded = FALSE;
                    $grp->message ="Something went wrong";
                }
            }
            $conn->close();
            return $grp;
    }   
    
    public function addGroupJson($name,$details,$admin,$members,$createdOn){
            $grp  = $this->addNewGroup($name,$details,$admin,$members,$createdOn);
            if ($grp->isGroupAdded) {
                $jsonStr = '{"responce":true,"logs":'.json_encode($grp,true).'}';
            }  else {
                $jsonStr = '{"responce":false,';
                $jsonStr.='"message":"'.$grp->message.'"}';
            }
            return $jsonStr;    
    }
        
        
        public function updateGroup($id,$members){
           
            /*
                1. Get current group from the Db by Id and check if it contains the segmentId.
                2. If It doesn't contains the segment Id then create the segment Id
                3. Check If any old members If db has old members then remove from the segment
                4. Add new members to the segment
            */

            $membersCount = "";
            $mailChimpService = new MailChimpService();
            $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
            $mailChimpApiKey = $mailChimpService->mailChimpApiKey = getenv("mailChimpApiKey");
            $list_id = $mailChimpService->list_id = getenv('mailChimpListId');
                    
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            $grp = new Group("","","","","","","","");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Step 1
            $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group where id='".$id."' limit 1;";
            $result = $conn->query($sql);
            $groupRow = $result->fetch_assoc();
            $segId = NULL;
            $membersEmailArr = array(); 
            $log = array();
            // exit($groupRow);

            if(!isset($groupRow['segId']) || strlen($groupRow['segId']) == 0 || $groupRow['segId'] == NULL) {
                ob_start();
                $createSegReq = $mailChimpService->createSegment($groupRow['name'],$mailChimpSubDomainInit,$membersEmailArr,$list_id,$mailChimpApiKey);
                $createSegReq = ob_get_clean();
                ob_flush();
                $createSegReqArr = $createSegReq === NULL ? array() : json_decode($createSegReq,true);
                $segId = array_key_exists("id", $createSegReqArr) ? $createSegReqArr['id'] : NULL;
                $log['createSegment'] = is_null($createSegReq) ? "" : json_decode($createSegReq);
            }
            
            else {
                $segId = $groupRow['segId'];
            }
            // End Step 1
            
            //exit();
            // Step 2-> check for old members 
            $membersArr = explode(",",$members);
            $membersEmailArr = array();
            $oldMemberEmailArr = array();
            $segmentEmailArr = array();
            $log['segments'] = array();
            ob_start();
            $membersBySegRes = $mailChimpService->getMemberbySegmentId($mailChimpSubDomainInit,$list_id,$mailChimpApiKey,$segId);
            $membersBySegRes = ob_get_clean();
            $membersBySegResArr = (json_decode($membersBySegRes,true));
            $log['segments'] = $membersBySegResArr;
            // print_r($membersBySegResArr);
            // exit();
            
            if($membersBySegResArr !== NULL && array_key_exists("members",$membersBySegResArr) && sizeof($membersBySegResArr["members"]) > 0) {
                for($i = 0; $i < sizeof($membersBySegResArr["members"]) ;$i++) {
                    array_push($segmentEmailArr,$membersBySegResArr["members"][$i]["email_address"]);
                }
            }
            $oldMembers = array_diff(explode(",",$groupRow['members']),$membersArr);
            $memberSql = "SELECT * from employee WHERE id IN (".trim($members).");";
            $selctResult = $conn->query($memberSql);
              
            $log['removeBulkEmailFromSegment'] = array();
            
            if(sizeof($oldMembers) > 0) {
                $oldMemberSql = "SELECT * from employee WHERE id IN (".implode(",",$oldMembers).");";
                $oldMemberSqlResult = $conn->query($oldMemberSql);
                while($oldMemberSqlRow = $oldMemberSqlResult->fetch_assoc()) {
                    array_push($oldMemberEmailArr,$oldMemberSqlRow['email']);
                }
                //print_r($oldMemberEmailArr);
                //exit();
                if(sizeof($oldMemberEmailArr) > 0) {
                    ob_start();
                    $removeBulkEmailReq = $mailChimpService->removeBulkMembersFromSegment($oldMemberEmailArr,$segId,$list_id,$mailChimpApiKey,$mailChimpSubDomainInit);
                    $removeBulkEmailReq = $removeBulkEmailReq === NULL ? "" : json_decode($removeBulkEmailReq);
                    $log['removeBulkEmailFromSegment'] = $removeBulkEmailReq;
                    ob_clean();
                }
            }
           
            if ($selctResult->num_rows > 0) {
                $log['userSubscribed'] = array();
                while($emplRow = $selctResult->fetch_assoc()) {
                    $emplEmail = $emplRow["email"]; 
                    $emplName = $emplRow["name"];
                    array_push($membersEmailArr,$emplEmail);
                    $subEmplRes = $mailChimpService->subscribeUser($emplEmail,$emplName,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
                    $subEmplRes = $subEmplRes === NULL ? "" : $subEmplRes;
                    array_push($log['userSubscribed'],json_decode($subEmplRes));
                }
                            
            }
           
            $log['addBulkEmailToSegment'] = array();
            if(sizeof($membersEmailArr) > 0) {
                ob_start();
                $addBulkEmailReq = $mailChimpService->addBulkMembersToSegment(array_merge(array_diff($membersEmailArr,$segmentEmailArr)),$segId,$list_id,$mailChimpApiKey,$mailChimpSubDomainInit);
                $addBulkEmailReq = $addBulkEmailReq === NULL ? "" : json_decode($addBulkEmailReq);
                $log['addBulkEmailToSegment'] = $addBulkEmailReq;
                ob_clean();
            }


            $sql = "UPDATE `group` SET `members` = '".$members."',`segId` = '".$segId."' WHERE `group`.`id` = ".$id.";";
            if ($conn->query($sql) === TRUE) {
                $grp->isGroupAdded = TRUE;
                $grp->logs = $log;
            } else {
                $grp->isGroupAdded = FALSE;
                $grp->message ="Something went wrong";
            }
           
            $logFile = fopen('./../logs/log-'.date('Y-m-d-H-i-s').'.json', "w");
            ob_start();
            fwrite($logFile, json_encode($log));
            fclose($logFile);
            ob_clean();
            
            $conn->close();
            return $grp;
    }   
    
        
        
        
        
    public function updateGroupJson($id,$members){
            $grp  = $this->updateGroup($id,$members);
            if ($grp->isGroupAdded) {
                $jsonStr = '{"responce":true,"logs":'.(json_encode($grp->logs,JSON_UNESCAPED_SLASHES)).'}';
            }  else {
                $jsonStr = '{"responce":false,';
                $jsonStr.='"message":"'.$grp->message.'"}';
            }
            return $jsonStr;    
    }

        
        public function updateGroup2($id,$segId){
            $membersCount="";
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            $grp = new Group("","","","","","","");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
           
            
                $sql = "UPDATE `group` SET `segId` = '".$segId."' WHERE `group`.`id` = ".$id.";";
                if ($conn->query($sql) === TRUE) {
                    $grp->isGroupAdded = TRUE;
                } else {
                    $grp->isGroupAdded = FALSE;
                    $grp->message ="Something went wrong";
                }
            
            $conn->close();
            return $grp;
    }   
    
        
        
        
    public function getGroup($id){
        
            $grp = "";
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
            } 
           
            $sql = "SELECT * FROM ".StaticDBCon::$dbname.".group where id='".$id."';";
          
            $result = $conn->query($sql);
            //echo $sql.' id : '.$id;
            if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    //$group = new Group($row["id"], $row["name"], $row["details"], $row["admin"], $row["members"], $row["membersCount"], $row["createdOn"]);
                    $grp = $row["segId"];
                }
            } else {
                    
            }
            $conn->close();
            return $grp;
    }


    
}

?>