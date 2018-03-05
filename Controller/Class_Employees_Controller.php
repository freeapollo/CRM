<?php

    require_once("../Models/Class_Employees.php");
    require_once("Class_Company_Controller.php");
    require_once("../Controller/StaticDBCon.php");
    class EmployeesController{

            public function getEmployeeList($id){
                $emplList = array();
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                }
                if($id==''){
                //	$sql = "SELECT * FROM employee inner join company on company.id = employee.companyId;";
                    $sql = "SELECT * FROM employee ";
                }else{
                //	$sql = "SELECT * FROM erp_crm.employee inner join company on company.id = employee.companyId where company.id='".$id."';";
                    $sql = "SELECT * FROM employee where id='".$id."';";
                }

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        //$comp = new Company($row["company.companyId"],$row["areaOfWork"],$row["establised"],$row["employees"],$row["revenue"],$row["ofcAddress"],$row["email"],$row["phone"],$row["logo"]);
                        $empl = new Employees($row["id"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],"",$row["companyId"],$row["skype"],$row["age"],$row["gender"],$row["officePhone"],$row["jobRole"],$row["phone"],$row["email"],$row["linkedin"],$row["twitter"],$row["facebook"],$row["notes"],$row["imgUrl"]);
                        $empl->extra = $row["extra"];
                        $emplList[$i]=$empl;
                        //echo $emplList[$i]->getName();
                        $i++;
                    }
                } else {
                        //echo "0 results";
                }
                $conn->close();
                return $emplList;
            }	

            public function getEmployeeJson($id){
                    $EmployeeList = $this->getEmployeeList($id);
                    $comps = new CompanyController();
                    $jsonStr = '{"Employees":[';
                    $i=count($EmployeeList);
                    foreach($EmployeeList as $empl){
                            $jsonStr.='{';
                            $jsonStr.='"id":"'.$empl->getId().'",';
                            $jsonStr.='"companyId":"'.$empl->getCompanyId().'",';
                            $jsonStr.='"RootUrl":"http://jaiswaldevelopers.com/CRMV1/files/Files/",';
                            $jsonStr.='"name":"'.$empl->getName().'",';
                            $jsonStr.='"title":"'.$empl->getTitle().'",';
                            $jsonStr.='"extra":"'.$empl->extra.'",';
                            $jsonStr.='"industry":"'.$empl->getIndustry().'",';
                            $jsonStr.='"location":"'.$empl->getLocation().'",';
                            $jsonStr.='"ratings":"'.$empl->getRatings().'",';

                            $jsonStr.='"skype":"'.$empl->getSkype().'",';
                            $jsonStr.='"age":"'.$empl->getAge().'",';
                            $jsonStr.='"gender":"'.$empl->getGender().'",';
                            $jsonStr.='"officePhone":"'.$empl->getOfficePhone().'",';
                            $jsonStr.='"jobRole":"'.$empl->getJobRole().'",';
                            $jsonStr.='"phone":"'.$empl->getPhone().'",';
                            $jsonStr.='"email":"'.$empl->getEmail().'",';
                            $jsonStr.='"linkedin":"'.$empl->getLinkedin().'",';
                            $jsonStr.='"twitter":"'.$empl->getTwitter().'",';
                            $jsonStr.='"facebook":"'.$empl->getFacebook().'",';
                            $jsonStr.='"notes":"'.$empl->getNotes().'",';
                            $jsonStr.='"isUpdateSuccess":"'.$empl->isUpdateSuccess.'",';
                            $jsonStr.='"outMessage":"'.$empl->outMessage.'",';
                            $jsonStr.='"foundIn":"'.$empl->getFoundIn().'",';
                            $jsonStr.='"imgUrl":"'.$empl->imgurl.'",';




                            $jsonStr.='"Company":['.$comps->getCompanyJsonForEmpl($empl->getCompanyId()).']}';
                            $i--;
                            if($i!=0){
                                            $jsonStr.=',';
                            }
                    }
                    $jsonStr.=']}';
                    return $jsonStr;
            }










            public function addNewEmployee($name,$title,$industry,$location,$ratings,$companyId,$skype,$age,$gender,$officePhone,$jobRole,$phone,$email,$linkedin,$twitter,$facebook,$notes,$imgUrl){
                    $date = new DateTime();
                    $time = $date->getTimestamp();
                    $membersCount="";
                    $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                    $msg = new Employees(0,"","","","","","","","","","","","","","","","","","","");
                    if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                    }
                            $read = 0;
                            $sql = "INSERT INTO ".StaticDBCon::$dbname.".employee (name,title,industry,location,ratings,companyId,skype,age,gender,officePhone,jobRole,phone,email,linkedin,twitter,facebook,notes,imgUrl)
                            VALUES ('".$name."','".$title."','".$industry."','".$location."','".$ratings."','".$companyId."','".$skype."','".$age."','".$gender."','".$officePhone."','".$jobRole."','".$phone."','".$email."','".$linkedin."','".$twitter."','".$facebook."','".$notes."','".$imgUrl."')";
                            //echo 'Query : '.$sql;
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

            public function addNewEmployeeJson($name,$title,$industry,$location,$ratings,$companyId,$skype,$age,$gender,$officePhone,$jobRole,$phone,$email,$linkedin,$twitter,$facebook,$notes,$imgUrl){
                $msg  = $this->addNewEmployee($name,$title,$industry,$location,$ratings,$companyId,$skype,$age,$gender,$officePhone,$jobRole,$phone,$email,$linkedin,$twitter,$facebook,$notes,$imgUrl);
                if ($msg->isUpdateSuccess) {
                    $jsonStr = '{"responce":true}';
                }  else {
                    $jsonStr = '{"responce":false,';
                    $jsonStr.='"message":"'.$msg->outMessage.'"}';
                }
                return $jsonStr;	
            }



            public function updateEmployee($id,$name,$title,$industry,$location,$ratings,$companyId,$skype,$age,$gender,$officePhone,$jobRole,$phone,$email,$linkedin,$twitter,$facebook,$notes,$imgUrl,$companyName,$extra){
                    $date = new DateTime();
                    $time = $date->getTimestamp();
                    $membersCount="";
                    $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                    $msg = new Employees(0,"","","","","","","","","","","","","","","","","","","");
                    if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                    }
                            $read = 0;
                            //$sql = "UPDATE ".StaticDBCon::$dbname.".employee SET (name,title,industry,location,ratings,companyId,skype,age,gender,officePhone,jobRole,phone,email,linkedin,twitter,facebook,notes,imgUrl)
                            //VALUES ('".$name."','".$title."','".$industry."','".$location."','".$ratings."','".$companyId."','".$skype."','".$age."','".$gender."','".$officePhone."','".$jobRole."','".$phone."','".$email."','".$linkedin."','".$twitter."','".$facebook."','".$notes."','".$imgUrl."') WHERE id=".$id."";
                            $sql = "UPDATE `employee` SET `companyName` = '".$companyName."',`name` = '".$name."',`title` = '".$title."',`industry` = '".$industry."',`location` = '".$location."',`ratings` = '".$ratings."',`companyId` = '".$companyId."',`skype` = '".$skype."',`age` = '".$age."',`gender` = '".$gender."',`officePhone` = '".$officePhone."',`jobRole` = '".$jobRole."',`phone` = '".$phone."',`email` = '".$email."',`linkedin` = '".$linkedin."',`twitter` = '".$twitter."',`facebook` = '".$facebook."',`notes` = '".$notes."',`imgUrl` = '".$imgUrl."',`extra` = '".$extra."' WHERE id = ".$id."";
                            //echo 'Query : '.$sql;
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

            public function updateEmployeeJson($id,$name,$title,$industry,$location,$ratings,$companyId,$skype,$age,$gender,$officePhone,$jobRole,$phone,$email,$linkedin,$twitter,$facebook,$notes,$imgUrl,$companyName,$extra){
                    $msg  = $this->updateEmployee($id,$name,$title,$industry,$location,$ratings,$companyId,$skype,$age,$gender,$officePhone,$jobRole,$phone,$email,$linkedin,$twitter,$facebook,$notes,$imgUrl,$companyName,$extra);
                    if ($msg->isUpdateSuccess) {
                            $jsonStr = '{"responce":true}';
                    }  else {
                            $jsonStr = '{"responce":false,';
                            $jsonStr.='"message":"'.$msg->outMessage.'"}';
                    }
                    return $jsonStr;	
            }


            public function updateEmployeeImage($id,$imgUrl){
                    $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                    $msg = new Employees(0,"","","","","","","","","","","","","","","","","","","");
                    if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                    }
                            $read = 0;
                            //$sql = "UPDATE ".StaticDBCon::$dbname.".employee SET (name,title,industry,location,ratings,companyId,skype,age,gender,officePhone,jobRole,phone,email,linkedin,twitter,facebook,notes,imgUrl)
                            //VALUES ('".$name."','".$title."','".$industry."','".$location."','".$ratings."','".$companyId."','".$skype."','".$age."','".$gender."','".$officePhone."','".$jobRole."','".$phone."','".$email."','".$linkedin."','".$twitter."','".$facebook."','".$notes."','".$imgUrl."') WHERE id=".$id."";
                            $sql = "UPDATE `employee` SET `imgUrl` = '".$imgUrl."' WHERE id = ".$id."";
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

            public function updateEmployeeImageJson($id,$imgUrl){
                    $msg  = $this->updateEmployeeImage($id,$imgUrl);
                    if ($msg->isUpdateSuccess) {
                            $jsonStr = '{"responce":true}';
                    }  else {
                            $jsonStr = '{"responce":false,';
                            $jsonStr.='"message":"'.$msg->outMessage.'"}';
                    }
                    return $jsonStr;	
            }






            



            public function updateEmployeeProImage($id,$imgUrl){
                    $msg = new Employees(0,"","","","","","","","","","","","","","","","","","","");
                            $read = 0;
                            //$sql = "UPDATE ".StaticDBCon::$dbname.".employee SET (name,title,industry,location,ratings,companyId,skype,age,gender,o....................fficePhone,jobRole,phone,email,linkedin,twitter,facebook,notes,imgUrl)
                            //VALUES ('".$name."','".$title."','".$industry."','".$location."','".$ratings."','".$companyId."','".$skype."','".$age."','".$gender."','".$officePhone."','".$jobRole."','".$phone."','".$email."','".$linkedin."','".$twitter."','".$facebook."','".$notes."','".$imgUrl."') WHERE id=".$id."";
                            $sql = "UPDATE `user` SET `profilePic` = '".$imgUrl."' WHERE id = ".$id."";
                            //echo 'Query : '.$sql;
                                    $msg->isUpdateSuccess = TRUE;
                                    $msg->id = $id;

                    //$conn->close();
                    return $msg;
            }	

            
            public function updateEmployeeImageProJson($id){

                    $msg  = $this->updateEmployeeProImage($id,TRUE);

                    if ($msg->isUpdateSuccess) {
                            $jsonStr = '{"responce":true}';
                    }  else {
                            $jsonStr = '{"responce":false,';
                            $jsonStr.='"message":"'.$msg->outMessage.'"}';
                    }
                    return $jsonStr;	
            }


            
            public function updateEmployeeAttImage($id,$imgUrl){
                    $msg = new Employees(0,"","","","","","","","","","","","","","","","","","","");
                            $read = 0;
                            //$sql = "UPDATE ".StaticDBCon::$dbname.".employee SET (name,title,industry,location,ratings,companyId,skype,age,gender,o....................fficePhone,jobRole,phone,email,linkedin,twitter,facebook,notes,imgUrl)
                            //VALUES ('".$name."','".$title."','".$industry."','".$location."','".$ratings."','".$companyId."','".$skype."','".$age."','".$gender."','".$officePhone."','".$jobRole."','".$phone."','".$email."','".$linkedin."','".$twitter."','".$facebook."','".$notes."','".$imgUrl."') WHERE id=".$id."";
                            $sql = "UPDATE `employee` SET `attachments` = '".$imgUrl."' WHERE id = ".$id."";
                            //echo 'Query : '.$sql;
                                    $msg->isUpdateSuccess = TRUE;
                                    $msg->id = $id;

                    //$conn->close();
                    return $msg;
            }	

            public function updateEmployeeImageAttJson($id){

                    $msg  = $this->updateEmployeeAttImage($id,TRUE);

                    if ($msg->isUpdateSuccess) {
                            $jsonStr = '{"responce":true}';
                    }  else {
                            $jsonStr = '{"responce":false,';
                            $jsonStr.='"message":"'.$msg->outMessage.'"}';
                    }
                    return $jsonStr;	
            }




            public function getAtt($id){
                    $dir = "../files/Files/".$id."/";
                  
                    
                    
                    
                    
                    $exclude = array(".", ".."); // you don't want these entries in your files array
                    $files = scandir($dir);
                    $files = array_diff($files, $exclude);
                    
                    
                    
                    
                    
                    $attach = [];
                    $i=0;
                   
                    // Open a directory, and read its contents
                    if (is_dir($dir)){
                        
                     foreach ($files as $file) {
                         $attach[$i] = $file;
                         $i++;
                     }
                         
                         
                         
                    }
                    return $attach;
                            }	

            public function getAttJson($id){
                    $roots = 'http://jaiswaldevelopers.com/CRMV1/files/Files/'.$id.'/';

                    $msg  = $this->getAtt($id);
                    //echo count($msg);
                    if (count($msg)>0) {
                            $jsonStr = '{"responce":true,"rootLink":"'.$roots.'","links":[';
                $i=count($msg);
                foreach($msg as $empl){
                    $jsonStr.='{';
                    $jsonStr.='"url":"'.$empl.'",';
                    $jsonStr.='"uploadedOn":"'.date("F d Y H:i:s.",filemtime("../files/Files/".$id.'/'.$empl)).'"}';
                    $i--;
                    if($i!=0){
                            $jsonStr.=',';
                    }
                }
                $jsonStr.=']}';



                    }  else {
                            $jsonStr = '{"responce":false,';
                            $jsonStr.='"message":"no file"}';
                    }
                    return $jsonStr;	
            }









            public function getEmployeeNameList($id){
                $emplList = array();
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                if($id==''){
                //	$sql = "SELECT * FROM employee inner join company on company.id = employee.companyId;";
                    $sql = "SELECT * FROM employee";
                }else{
                //	$sql = "SELECT * FROM erp_crm.employee inner join company on company.id = employee.companyId where company.id='".$id."';";
                    $sql = "SELECT * FROM employee where id='".$id."';";
                }

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        //$comp = new Company($row["company.companyId"],$row["areaOfWork"],$row["establised"],$row["employees"],$row["revenue"],$row["ofcAddress"],$row["email"],$row["phone"],$row["logo"]);
                        $empl = new Employees($row["id"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],"",$row["companyId"],$row["skype"],$row["age"],$row["gender"],$row["officePhone"],$row["jobRole"],$row["phone"],$row["email"],$row["linkedin"],$row["twitter"],$row["facebook"],$row["notes"],$row["imgUrl"]);
                        $emplList[$i]=$empl;
                        //echo $emplList[$i]->getName();
                        $i++;
                    }
                } else {
                        //echo "0 results";
                }
                $conn->close();
                return $emplList;
            }	

            public function getEmployeeNameJson($id){
                $EmployeeList = $this->getEmployeeNameList($id);
                $comps = new CompanyController();
                $jsonStr = '{"Employees":[';
                $i=count($EmployeeList);
                foreach($EmployeeList as $empl){
                    $jsonStr.='{';
                    $jsonStr.='"id":"'.$empl->getId().'",';
                    $jsonStr.='"imgUrl":"'.$empl->imgurl.'",';
                    $jsonStr.='"email":"'.$empl->getEmail().'",';
                    $jsonStr.='"name":"'.$empl->getName().'"}';
                    $i--;
                    if($i!=0){
                            $jsonStr.=',';
                    }
                }
                $jsonStr.=']}';
                return $jsonStr;
            }










            public function getEmployeeNameSearchList($term){
                $emplList = array();
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
              
                //	$sql = "SELECT * FROM erp_crm.employee inner join company on company.id = employee.companyId where company.id='".$id."';";
                $sql = "SELECT * FROM employee where name LIKE '%".$term."%' LIMIT 10;";
                

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        //$comp = new Company($row["company.companyId"],$row["areaOfWork"],$row["establised"],$row["employees"],$row["revenue"],$row["ofcAddress"],$row["email"],$row["phone"],$row["logo"]);
                        $empl = new Employees($row["id"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],"",$row["companyId"],$row["skype"],$row["age"],$row["gender"],$row["officePhone"],$row["jobRole"],$row["phone"],$row["email"],$row["linkedin"],$row["twitter"],$row["facebook"],$row["notes"],$row["imgUrl"]);
                        $emplList[$i]=$empl;
                        //echo $emplList[$i]->getName();
                        $i++;
                    }
                } else {
                        //echo "0 results";
                }
                $conn->close();
                return $emplList;
            }	

            public function getEmployeeNameSearchJson($term){
                $EmployeeList = $this->getEmployeeNameSearchList($term);
                $comps = new CompanyController();
                $jsonStr = '{"Employees":[';
                $i=count($EmployeeList);
                foreach($EmployeeList as $empl){
                    $jsonStr.='{';
                    $jsonStr.='"id":"'.$empl->getId().'",';
                    $jsonStr.='"imgUrl":"'.$empl->imgurl.'",';
                    $jsonStr.='"name":"'.$empl->getName().'"}';
                    $i--;
                    if($i!=0){
                            $jsonStr.=',';
                    }
                }
                $jsonStr.=']}';
                return $jsonStr;
            }
















            public function getSearchEmployeeList($name){
                $emplList = array();
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                } 
                $sql = "SELECT * FROM employee where name LIKE '%".$name."%';";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        $empl = new Employee($row["id"],$row["companyId"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],"");
                        $emplList[$i]=$empl;
                        //echo $emplList[$i]->getName();
                        $i++;
                    }
                } else {
                        //echo "0 results";
                }
                $conn->close();
                return $emplList;
            }	


            public function getSearchEmployeeJson($name){
                $EmployeeList = $this->getSearchEmployeeList($name);
                $comps = new CompanyController();
                $jsonStr = '{"Employees":[';
                $i=count($EmployeeList);
                foreach($EmployeeList as $empl){
                    $jsonStr.='{';
                    $jsonStr.='"id":"'.$empl->getId().'",';
                    $jsonStr.='"CompanyId":"'.$empl->getCompanyId().'",';
                    $jsonStr.='"name":"'.$empl->getName().'",';
                    $jsonStr.='"title":"'.$empl->getTitle().'",';
                    $jsonStr.='"industry":"'.$empl->getIndustry().'",';
                    $jsonStr.='"location":"'.$empl->getLocation().'",';
                    $jsonStr.='"ratings":"'.$empl->getRatings().'",';
                    $jsonStr.='"Company":'.$comps->getCompanyJsonForEmpl($empl->getCompanyId()).'}';
                    $i--;
                    if($i!=0){
                            $jsonStr.=',';
                    }
                }
                $jsonStr.=']}';

                return $jsonStr;

            }



            public function getEmployeeSmartSearch($term){
                $emplList = array();
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 
                $sql = "select * from employee where employee.id like '".$term."%' employee.companyName like '".$term."%' or employee.name like '".$term."%' or employee.title like '".$term."%' or employee.location like '".$term."%' or employee.industry like '".$term."%' LIMIT 10";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        $arr = array();
                        $arr = $this->getKeysArray($row,$term);
                        $empl = new Employees($row["id"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],"",$row["companyId"],$row["skype"],$row["age"],$row["gender"],$row["officePhone"],$row["jobRole"],$row["phone"],$row["email"],$row["linkedin"],$row["twitter"],$row["facebook"],$row["notes"],$row["imgUrl"]);
                        $emplList[$i]=$empl;
                        $i++;
                    }
                } else {
                        //echo "0 results";
                }
                $conn->close();
                return $emplList;
            }	


            public function getEmployeeSmartSearchJson($name){
                $EmployeeList = $this->getEmployeeSmartSearch($name);
                $comps = new CompanyController();
                $jsonStr = '{"Employees":[';
                $i=count($EmployeeList);
                foreach($EmployeeList as $empl){
                    $String_Contains = $empl->getFoundIn();
                    $jsonStr.='{';
                    $jsonStr.='"id":"'.$empl->getId().'",';
                    $jsonStr.='"CompanyId":"'.$empl->getCompanyId().'",';
                    $jsonStr.='"name":"'.$empl->getName().'",';
                    $jsonStr.='"title":"'.$empl->getTitle().'",';
                    $jsonStr.='"industry":"'.$empl->getIndustry().'",';
                    $jsonStr.='"location":"'.$empl->getLocation().'",';
                    $jsonStr.='"ratings":"'.$empl->getRatings().'",';
                    $jsonStr.='"foundIn":"'.$String_Contains.'",';
                    $jsonStr.='"Company":['.$comps->getCompanyJsonForEmpl($empl->getCompanyId()).']}';
                    $i--;
                    if($i!=0){
                            $jsonStr.=',';
                    }
                }
                $jsonStr.=']}';
                return $jsonStr;
            }




            public function getEmployeeSmart($terms){
                $emplList = array();
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                $rows2=array();
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $var_db = explode(" ", $terms);
                $term = $var_db[0];
                $sql = "select * from employee where employee.companyName like '%".$term."%' or employee.name like '%".$term."%' or employee.title like '%".$term."%' or employee.location like '%".$term."%' or employee.industry like '%".$term."%'";
             //   echo 'Query : '.$sql;
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        $aa = count($var_db);
                        foreach ($var_db as $v2){
                            if($this->getKeysAr($v2, $row)){
                                $aa--;
                            }
                        }
                        if($aa==0){
                            $arr = array();
                            $arr = $this->getKeysArray($row,$term);
                            $empl = new Employees($row["id"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],"",$row["companyId"],$row["skype"],$row["age"],$row["gender"],$row["officePhone"],$row["jobRole"],$row["phone"],$row["email"],$row["linkedin"],$row["twitter"],$row["facebook"],$row["notes"],$row["imgUrl"]);
                            $emplList[$i]=$empl;
                            $i++;
                        }
                    }
                } else {
                        //echo "0 results";
                }
                $conn->close();
                return $emplList;
            }	



            public function getSmartResult($terms){
                $dataAr = array();
                $dataAr = explode(" ", $terms);
                $emplList = array();
                $conn = new mysqli(StaticDBCon::$servername, StaticDBCon::$username, StaticDBCon::$password, StaticDBCon::$dbname);
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                }
                $ds2 = "";
                $sql = "select * from employee where";
                $j = count($dataAr);
                for($i=0;$i<$j;$i++){
                    $ds2.= " employee.id like '%".$dataAr[$i]."%' or employee.name like '%".$dataAr[$i]."%' or employee.title like '%".$dataAr[$i]."%' or employee.location like '%".$dataAr[$i]."%' or employee.industry like '%".$dataAr[$i]."%'";
                    if($i!=($j-1)){
                         $ds2.= " or ";
                    } 
                }
                $sql = $sql." ".$ds2;
                //echo 'Sql : '.$sql;
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        $arr = array();
                        $arr = $this->getKeysArrays($row,$terms);
                        $empl = new Employees($row["id"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],"",$row["companyId"],$row["skype"],$row["age"],$row["gender"],$row["officePhone"],$row["jobRole"],$row["phone"],$row["email"],$row["linkedin"],$row["twitter"],$row["facebook"],$row["notes"],$row["imgUrl"]);
                        $emplList[$i]=$empl;
                        $i++;
                    }
                } else {
                        //echo "0 results";
                }
                $conn->close();
                return $emplList;
            }








            public function getSmartResultJson($terms){
                $EmployeeList = $this->getEmployeeSmart($terms);
                //$EmpList2 = $this->getSorteddArray($EmployeeList, $terms);
                $comps = new CompanyController();
                $jsonStr = '{"Employees":[';
                $i=count($EmployeeList);
                foreach( $EmployeeList as $empl){
                   $String_Contains = $empl->getFoundIn();
                   $jsonStr.='{';
                   $jsonStr.='"id":"'.$empl->getId().'",';
                   $jsonStr.='"CompanyId":"'.$empl->getCompanyId().'",';
                   $jsonStr.='"name":"'.$empl->getName().'",';
                   $jsonStr.='"jobRole":"'.$empl->getJobRole().'",';
                   $jsonStr.='"title":"'.$empl->getTitle().'",';
                   $jsonStr.='"industry":"'.$empl->getIndustry().'",';
                   $jsonStr.='"location":"'.$empl->getLocation().'",';
                   $jsonStr.='"ratings":"'.$empl->getRatings().'",';
                   $jsonStr.='"foundIn":"'.$String_Contains.'",';
                   $jsonStr.='"Company":['.$comps->getCompanyJsonForEmpl($empl->getCompanyId()).']}';
                   $i--;
                   if($i!=0){
                           $jsonStr.=',';
                   }
                }
                $jsonStr.=']}';
                return $jsonStr;
            }



            public function getKeysArray($array,$compStr){
                $data = array();
                $i=0;
                while ($rowName = current($array)) {
                    $rowName = strtolower($rowName);
                    $compStr = strtolower($compStr);
                    if (strlen(strstr($rowName , $compStr))>0) {
                        $data[$i] = key($array);
                    }
                    next($array);
                    $i++;
                }       
                return $data;
            }



            public function getKeysArrays($array,$compStr){
                $data = array();
                $data2 = array();
                $data2 = explode(" ", $compStr);
                $i=0;
                $counts = count($data2);
                for($j=0;$j<=$counts;$j++){
                    while ($rowName = current($array)) {
                        $rowName = strtolower($rowName);
                        $compStr = strtolower($compStr);
                        $rowName2 = $rowName;
                        $rowName3 = $data2[$j];
                        $rowName2 = strtolower($rowName);
                        $rowName3 = strtolower($data2[$j]);

                        if (strlen(strstr($rowName2 , $rowName3))>0) {
                            $data[$i] = key($array);
                        }
                        next($array);
                        $i++;
                    }
                }            
                return $data;
            }

            function getKeysAr($key,$arrays){
                $keys = array_keys($arrays);
                $count = count($keys);
                for ($i=0;$i<$count;$i++){
                    $k = strtolower($arrays[$keys[$i]]);
                    $key = strtolower($key);
                    if (strlen(strstr($k , $key))>0) {
                        return TRUE;
                    }
                }
            }

            function getSorteddArray($data_ar,$string){
                $final_ar = array();
                $str_ar = explode(" ", $string);
                $f_it =0;
                foreach ($data_ar as $value) {
                    $aa = count($str_ar);
                    foreach ($str_ar as $v2){
                        if(in_array($v2, (array)$value)){
                            $aa--;
                        }
                    }
                    if($aa==0){
                        $final_ar[$f_it] = $value;
                        $f_it++;
                    }  
                }
                return $final_ar;
            }








    }




    ?>