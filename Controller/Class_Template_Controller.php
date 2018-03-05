<?php

require_once("../Models/Class_Template.php");
require_once("../Controller/StaticDBCon.php");
 header("Access-Control-Allow-Origin: *");
class TemplateController{
	
	public function getTemplateList($id){
            $resp = "";
            $emailList = array();
            $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
            if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
            } 
            if($id==''){
                    $sql = "SELECT * FROM templates;";
            }else{
                    $sql = "SELECT * FROM templates where id='".$id."';";
            }
            $result = $conn->query($sql);
            //echo $sql.' id : '.$id;
            if ($result->num_rows > 0) {
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        //echo $row['name'];
                            $mail = new Template($row['id'], $row['name'], $row['html'], $row['addedBy']);
                            $mailList[$i]=$mail;
                            //echo $compList[$i]->getName();
                            $i++;

                    }
            } else {
                    //echo "0 results";
            }
            $conn->close();
            $resp = json_encode($mailList);
            return $mailList;
	}	
	
	
	
	public function getTemplateJson($id){
		//echo "id : ".$id;
            $List = $this->getTemplateList($id);
		
                
            $List = $this->getTemplateList($id);
            $jsonStr = '{"templ":[';
            $i=count($List);
            foreach($List as $grp){
                $jsonStr.='{';
                $jsonStr.='"id":"'.$grp->id.'",';
                $jsonStr.='"name":"'.$grp->name.'",';
                $jsonStr.='"html":"'.htmlentities($grp->html).'",';
                $jsonStr.='"createdOn":"'.$grp->addedBy.'"}';
                $i--;
                if($i!=0){
                    $jsonStr.=',';
                }
            }
            $jsonStr.=']}';

            return $jsonStr;
		
	}
	
	


            public function addNewTemplate($name,$html,$addedBy){
                    $date = new DateTime();
                    $time = $date->getTimestamp();
                    $membersCount="";
                    $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                    $msg = new Template("", "", "", "");
                    if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                    }
                            $read = 0;
                            $sql = "INSERT INTO ".StaticDBCon::$dbname.".templates(name,html,addedBy)
                            VALUES ('".$name."','".$html."','".$addedBy."')";
                            echo 'Query : '.$sql;
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

            public function addNewTemplateJson($name,$html,$addedBy){
                $msg  = $this->addNewTemplate($name,$html,$addedBy);
                if ($msg->isAdded) {
                    $jsonStr = '{"responce":true,'
                            . '"id":'.$msg->id
                            . '}';
                }  else {
                    $jsonStr = '{"responce":false,';
                    $jsonStr.='"message":"'.$msg->outMessage.'"}';
                }
                return $jsonStr;	
            }


}




?>