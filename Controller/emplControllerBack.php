<?php

require_once("../Models/Class_Employee.php");
require_once("Class_Company_Controller.php");
require_once("../Controller/StaticDBCon.php");
class EmployeeController{
	
	public function getEmployeeList($id){
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
                $sql = "SELECT * FROM erp_crm.employee where id='".$id."';";
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    //$comp = new Company($row["company.companyId"],$row["areaOfWork"],$row["establised"],$row["employees"],$row["revenue"],$row["ofcAddress"],$row["email"],$row["phone"],$row["logo"]);
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
	
	public function getEmployeeJson($id){
            $EmployeeList = $this->getEmployeeList($id);
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
                $jsonStr.='"Company":['.$comps->getCompanyJsonForEmpl($empl->getCompanyId()).']}';
                $i--;
                if($i!=0){
                        $jsonStr.=',';
                }
            }
            $jsonStr.=']}';
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
                $sql = "SELECT * FROM erp_crm.employee where id='".$id."';";
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    //$comp = new Company($row["company.companyId"],$row["areaOfWork"],$row["establised"],$row["employees"],$row["revenue"],$row["ofcAddress"],$row["email"],$row["phone"],$row["logo"]);
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
	
	public function getEmployeeNameJson($id){
            $EmployeeList = $this->getEmployeeNameList($id);
            $comps = new CompanyController();
            $jsonStr = '{"Employees":[';
            $i=count($EmployeeList);
            foreach($EmployeeList as $empl){
                $jsonStr.='{';
                $jsonStr.='"id":"'.$empl->getId().'",';
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
            $sql = "select * from employee where employee.id like '".$term."%' or employee.name like '".$term."%' or employee.title like '".$term."%' or employee.location like '".$term."%' or employee.industry like '".$term."%'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    $arr = array();
                    $arr = $this->getKeysArray($row,$term);
                    $empl = new Employee($row["id"],$row["companyId"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],$arr);
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
                $String_Contains = implode (", ", $empl->getFoundIn());
                $jsonStr.='{';
                $jsonStr.='"id":"'.$empl->getId().'",';
                $jsonStr.='"CompanyId":"'.$empl->getCompanyId().'",';
                $jsonStr.='"name":"'.$empl->getName().'",';
                $jsonStr.='"title":"'.$empl->getTitle().'",';
                $jsonStr.='"industry":"'.$empl->getIndustry().'",';
                $jsonStr.='"location":"'.$empl->getLocation().'",';
                $jsonStr.='"ratings":"'.$empl->getRatings().'",';
                $jsonStr.='"foundIn":"'.$String_Contains.'",';
                $jsonStr.='"Company":'.$comps->getCompanyJsonForEmpl($empl->getCompanyId()).'}';
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
            $sql = "select * from employee where employee.id like '%".$term."%' or employee.name like '%".$term."%' or employee.title like '%".$term."%' or employee.location like '%".$term."%' or employee.industry like '%".$term."%'";
            //echo 'Query : '.$sql;
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
                        $empl = new Employee($row["id"],$row["companyId"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],$arr);
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
                    $empl = new Employee($row["id"],$row["companyId"],$row["name"],$row["title"],$row["industry"],$row["location"],$row["ratings"],$arr);
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
               $String_Contains = implode (", ", $empl->getFoundIn());
               $jsonStr.='{';
               $jsonStr.='"id":"'.$empl->getId().'",';
               $jsonStr.='"CompanyId":"'.$empl->getCompanyId().'",';
               $jsonStr.='"name":"'.$empl->getName().'",';
               $jsonStr.='"title":"'.$empl->getTitle().'",';
               $jsonStr.='"industry":"'.$empl->getIndustry().'",';
               $jsonStr.='"location":"'.$empl->getLocation().'",';
               $jsonStr.='"ratings":"'.$empl->getRatings().'",';
               $jsonStr.='"foundIn":"'.$String_Contains.'",';
               $jsonStr.='"Company":'.$comps->getCompanyJsonForEmpl($empl->getCompanyId()).'}';
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