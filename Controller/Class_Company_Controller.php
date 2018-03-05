<?php

require_once("../Models/Class_Company.php");
require_once("../Models/Class_Company.php");
require_once("../Controller/StaticDBCon.php");
 header("Access-Control-Allow-Origin: *");
class CompanyController{
	
	public function getCompanyList($id){
		
		$compList = array();
		$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		if($id==''){
			$sql = "SELECT * FROM company;";
		}else{
			$sql = "SELECT * FROM company where id='".$id."';";
		}
		$result = $conn->query($sql);
		//echo $sql.' id : '.$id;
		if ($result->num_rows > 0) {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$comp = new Company($row["id"],$row["name"],$row["areaOfWork"],$row["establised"],$row["employees"],$row["revenue"],$row["ofcAddress"],$row["email"],$row["phone"],$row["logo"],$row["fb"],$row["tw"],$row["extra"]);
			
				 $comp->extra = $row["extra"];	//echo $row['extra'];
				$compList[$i]=$comp;
				//echo $compList[$i]->getName();
				$i++;
			}
		} else {
			//echo "0 results";
		}
		$conn->close();
		return $compList;
	}	
	
	
	
	public function getCompanyListEmpl($id){
		
		$compList = array();
		$conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
			$sql = "SELECT * FROM company where id='".$id."' LIMIT 1;";
		
		$result = $conn->query($sql);
		//echo $sql.' id : '.$id;
		if ($result->num_rows > 0) {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$comp = new Company($row["id"],$row["name"],$row["areaOfWork"],$row["establised"],$row["employees"],$row["revenue"],$row["ofcAddress"],$row["email"],$row["phone"],$row["logo"],$row["fb"],$row["tw"],$row['extra']);
				
				$compList[$i]=$comp;
				//echo $compList[$i]->getName();
				$i++;
			}
		} else {
			//echo "0 results";
		}
		$conn->close();
		return $compList;
	}	
	
	
	
	public function getCompanyJson($id){
		//echo "id : ".$id;
		$CompList = $this->getCompanyList($id);
		$jsonStr = '{"Users":[';
		$i=count($CompList);
		foreach($CompList as $comp){
			$jsonStr.='{';
			$jsonStr.='"name":"'.$comp->getName().'",';
			$jsonStr.='"areaOfWork":"'.$comp->getAreaOfWork().'",';
			$jsonStr.='"establised":"'.$comp->getEstablised().'",';
			$jsonStr.='"employees":"'.$comp->getEmployees().'",';
			$jsonStr.='"revenue":"'.$comp->getRevenue().'",';
                        $jsonStr.='"RootUrl":"http://jaiswaldevelopers.com/CRMV1/files/Files2/'.$comp->id.'/",';
			$jsonStr.='"ofcAddress":"'.$comp->getOfcAddress().'",';
			$jsonStr.='"email":"'.$comp->getEmail().'",';
			$jsonStr.='"phone":"'.$comp->getPhone().'",';
			$jsonStr.='"fb":"'.$comp->getFb().'",';
			$jsonStr.='"twitter":"'.$comp->getTw().'",';
			
			$jsonStr.='"extra":"'.$comp->extra.'",';
			$jsonStr.='"logo":"'.$comp->getLogo().'"}';
			$i--;
			if($i!=0){
				$jsonStr.=',';
			}
		}
		$jsonStr.=']}';
		
		return $jsonStr;
		
	}
	
	
	
	public function getCompanyJsonForEmpl($id){
		//echo "id : ".$id;
		$CompList = $this->getCompanyListEmpl($id);
		$jsonStr = '';
		$i=count($CompList);
		foreach($CompList as $comp){
			$jsonStr.='{';
			$jsonStr.='"name":"'.$comp->getName().'",';
			$jsonStr.='"areaOfWork":"'.$comp->getAreaOfWork().'",';
			$jsonStr.='"establised":"'.$comp->getEstablised().'",';
                        $jsonStr.='"RootUrl":"http://jaiswaldevelopers.com/CRMV1/files/Files2/'.$id.'/",';
			$jsonStr.='"employees":"'.$comp->getEmployees().'",';
			$jsonStr.='"revenue":"'.$comp->getRevenue().'",';
			$jsonStr.='"ofcAddress":"'.$comp->getOfcAddress().'",';
			$jsonStr.='"email":"'.$comp->getEmail().'",';
			$jsonStr.='"phone":"'.$comp->getPhone().'",';
			$jsonStr.='"logo":"'.$comp->getLogo().'"}';
			$i--;






                    if($i!=0){
                            $jsonStr.=',';
                    }

            }


            return $jsonStr;

    }


    public function updateCompany($id, $name, $areaOfWork, $establised, $employees, $revenue, $ofcAddress, $email, $phone,$fb, $tw, $ln,$extra){
        $date = new DateTime();
        $time = $date->getTimestamp();
        $membersCount="";
        $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
        $msg = new Company("", "", "", "", "", "", "", "", "", "", "", "");
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }
                $read = 0;
                $sql = "UPDATE `company` SET `name` = '".$name."',`areaOfWork` = '".$areaOfWork."',`establised` = '".$establised."',`employees` = '".$employees."',`revenue` = '".$revenue."',`ofcAddress` = '".$ofcAddress."',`email` = '".$email."',`fb` = '".$fb."',`tw` = '".$tw."',`ln` = '".$ln."',`phone` = '".$phone."',`extra` = '".$extra."' WHERE id = ".$id."";
               // echo 'Query : '.$sql;
                if ($conn->query($sql) === TRUE) {
                        $msg->isUpdateSuccess = TRUE;
                        $msg->id = mysqli_insert_id($conn);
                } else {
                        //echo "Error: " . $sql . "<br>" . $conn->error;
                        $msg->isUpdateSuccess = FALSE;
                        $msg->outMessage ="Something went wrong";
                }

        $conn->close();
        return $msg;
    }	

    public function updateCompanyJson($id, $name, $areaOfWork, $establised, $employees, $revenue, $ofcAddress, $email, $phone, $fb, $tw, $ln,$extra){
            $msg  = $this->updateCompany($id, $name, $areaOfWork, $establised, $employees, $revenue, $ofcAddress, $email, $phone,$fb, $tw, $ln,$extra);
            if ($msg->isUpdateSuccess) {
                    $jsonStr = '{"responce":true}';
            }  else {
                    $jsonStr = '{"responce":false,';
                    $jsonStr.='"message":"'.$msg->outMessage.'"}';
            }
            return $jsonStr;	
    }

	public function updateCompanyImage($id,$imgUrl){
	    $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
	    $msg = new Employees(0,"","","","","","","","","","","","","","","","","","","");
	    if ($conn->connect_error) {
	            die("Connection failed: " . $conn->connect_error);
	    }
	            
	            $sql = "UPDATE `company` SET `logo` = '".$imgUrl."' WHERE id = ".$id."";
	            //echo 'Query : '.$sql;
	            if ($conn->query($sql) === TRUE) {
	                    $msg->isUpdateSuccess = TRUE;
	                    $msg->id = mysqli_insert_id($conn);
	            } else {
	                    echo "Error: " . $sql . "<br>" . $conn->error;
	                    $msg->isUpdateSuccess = FALSE;
	                    $msg->outMessage ="Something went wrong";
	            }
	
	    $conn->close();
	    return $msg;
	}	
	
	public function updateCompanyImageJson($id,$imgUrl){
	    $msg  = $this->updateCompanyImage($id,$imgUrl);
	    if ($msg->isUpdateSuccess) {
	            $jsonStr = '{"responce":true}';
	    }  else {
	            $jsonStr = '{"responce":false,';
	            $jsonStr.='"message":"'.$msg->outMessage.'"}';
	    }
	    return $jsonStr;	
	}
	








        
        
}




?>