<?php
 header('Access-Control-Allow-Origin: *'); 
require_once("../Controller/EmailMgr.php");
$c2 = new EmailMgr();
$jsondata = $_POST["data"];

$data = $jsondata;
$new_array = objectToArray($param);

function objectToArray($d) 
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}

$servername = "localhost";
$username = "jaiswaladmin";
$password = "wppassword";
$db = "erp_crm";
// Create connection
$conn = mysqli_connect($servername,$username, $password,$db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
//print_r($new_array);

$encodedData =  ($data);
//echo sizeof($encodedData);
//print_r($encodedData);$properData = objectToArray($encodedData[0]);
//print_r($properData);
//exit("yoo");

$responseArr["result"] = true;
$responseArr["details"] = array();

for($i=0;$i<sizeof($encodedData);$i++) {
//echo"heloo";
	$properData = objectToArray($encodedData[$i]);
	//print_r($properData[$i]);
	//exit("exit");
	//echo "</br>";
	$name = mysqli_real_escape_string($conn,($properData["Firstname"])." ".($properData["Surname"]));
	$email =  mysqli_real_escape_string($conn,($properData["E-mail address"]));
	$companyName = mysqli_real_escape_string($conn,($properData["Company"]));
	$jobRole = mysqli_real_escape_string($conn,($properData["Job Role"]));
	$ofcAddress =  mysqli_real_escape_string($conn,($properData["Office Address"]));
	$website =  mysqli_real_escape_string($conn,($properData["Company Website"]));
	$industry =  mysqli_real_escape_string($conn,($properData["Industry"]));
	$country  = mysqli_real_escape_string($conn,($properData["Country"]));
	
	//echo $name."-".$companyName."-".$jobRole."-".$ofcAddress."-".$website."-".$industry."-".$country;
	//echo "<br/>";		
	//check if company already exists into the database
	
	$responseArr["details"][$i] = array();
	
	if(isset($companyName) && !empty($companyName)) {
		
		$sql = 'SELECT id,name FROM company WHERE name="'.$companyName.'"';
		//echo $sql."</br>";
		$result = mysqli_query($conn, $sql);
		$companyFound = false;
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
		//	echo "no of row";
			$foundCompnayId = null;
			$foundCompanyName = null;
			while($row = mysqli_fetch_assoc($result)) { 
					$foundCompnayId = $row["id"];
					$foundCompanyName = $row["name"];
			}
			
			//check if email Id already exists
			$emailFound = checkDupEmail($email);
			if($emailFound["result"] == false) {
				//insert query
				$insertSql = "INSERT INTO employee (name,companyName,jobRole,industry,location,website,companyId,email) VALUES('".$name."','".$companyName."','".$jobRole."','".$industry."','".$country."','".$website."','".$foundCompnayId."','".$email."')";
				
			}
			else {
				// update query
				$updateSql = 'UPDATE employee SET name = "'.$name.'" , companyName = "'.$companyName.'" , jobRole = "'.$jobRole.'" ,industry = "'.$industry.'" , location = "'.$country.'" , website = "'.$website.'" , companyId = "'.$foundCompnayId.'" WHERE email = "'.$email.'" ';
			}
			
			$responseArr["details"][$i]["loopNo"] = $i;
			if (mysqli_query($conn, $insertSql)) {
			
				
				$c2->addMebmberToList($email,'d0a4dda674',$name,'','');
				$responseArr["details"][$i]["listResponse"] = json_encode($c2);
				$responseArr["details"][$i]["inserted"] = true;
				$responseArr["details"][$i]["name"] = $name;
				//echo "if New record with found company Inserted successfully".$i."</br>";
			} else {
				$responseArr["details"][$i]["inserted"] = false;
				$responseArr["details"][$i]["name"] = $name;
				$responseArr["details"][$i]["reason"] = mysqli_error($conn);
				
				//echo "</br>Error: ".$sql."<br>" . mysqli_error($conn);
			}
			
		} else {
		
			$insertNewCmpySql = "INSERT INTO company(name,ofcAddress) VALUES('".trim($companyName)."','".$ofcAddress."')";
			if (mysqli_query($conn, $insertNewCmpySql)) {
				$companyId = mysqli_insert_id($conn);
				
				//check if email Id already exists
				$emailFound = checkDupEmail($email);
				if($emailFound["result"] == false) {
					//insert query
					$insertEmplSql = "INSERT INTO employee (name,companyName,jobRole,industry,location,website,companyId,email) VALUES('".$name."','".$companyName."','".$jobRole."','".$industry."','".$country."','".$website."','".$companyId."','".$email."')";
					
				}
				else {
					// update query
					$updateSql = 'UPDATE employee SET name = "'.$name.'" , companyName = "'.$companyName.'" , jobRole = "'.$jobRole.'" ,industry = "'.$industry.'" , location = "'.$country.'" , website = "'.$website.'" , companyId = "'.$foundCompnayId.'" WHERE email = "'.$email.'" ';
				}
				
				
				$responseArr["details"][$i]["loopNo"] = $i;
				if (mysqli_query($conn, $insertEmplSql)) {
					$c2->addMebmberToList($email,'d0a4dda674',$name,'','');
					$responseArr["details"][$i]["inserted"] = true;
					$responseArr["details"][$i]["name"] = $name;
					$responseArr["details"][$i]["listResponse"] = json_encode($c2);
					//echo "else if New Empl with new inserted company name Inserted successfully".$i."</br>";
				} else {
					//echo "</br>Error: " . $sql . "<br>" . mysqli_error($conn);
					$responseArr["details"][$i]["inserted"] = false;
					$responseArr["details"][$i]["name"] = $name;
					$responseArr["details"][$i]["reason"] = mysqli_error($conn);
				}
				
				//echo "New record created successfully".$i."</br>";
			} else {
				$responseArr["details"][$i]["inserted"] = false;
				$responseArr["details"][$i]["name"] = $name;
				$responseArr["details"][$i]["reason"] = mysqli_error($conn);
				//echo "</br>Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}

	}
	else {
		
		$insertEmplSql = "INSERT INTO employee (name,companyName,jobRole,industry,location,website,email) VALUES('".$name."','".$companyName."','".$jobRole."','".$industry."','".$country."','".$website."','".$email."')";
			
		$emailFound = checkDupEmail($email);
		if($emailFound["result"] == false) {
			//insert query
			$insertSql = "INSERT INTO employee (name,companyName,jobRole,industry,location,website,email) VALUES('".$name."','".$companyName."','".$jobRole."','".$industry."','".$country."','".$website."','".$email."')";
			
		}
		else {
			// update query
			$updateSql = 'UPDATE employee SET name = "'.$name.'" , companyName = "'.$companyName.'" , jobRole = "'.$jobRole.'" ,industry = "'.$industry.'" , location = "'.$country.'" , website = "'.$website.'" WHERE email = "'.$email.'" ';
		}
			
			$responseArr["details"][$i]["loopNo"] = $i;
		if (mysqli_query($conn, $insertEmplSql)) {
			$c2->addMebmberToList($email,'d0a4dda674',$name,'','');
			$responseArr["details"][$i]["listResponse"] = json_encode($c2);
			$responseArr["details"][$i]["inserted"] = true;
			$responseArr["details"][$i]["name"] = $name;
			//echo "outer New Empl with new inserted company name Inserted successfully".$i."</br>";
		} else {
			$responseArr["details"][$i]["inserted"] = false;
			$responseArr["details"][$i]["name"] = $name;
			$responseArr["details"][$i]["reason"] = mysqli_error($conn);
			//echo "</br>Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}

}

function checkDupEmail($email) {

	$DupEmailRes = array();
	$searchDuplicateEmail = "SELECT * FROM employee WHERE email='".$email."'";
	$searchDuplicateEmailResult = mysqli_query($conn, $searchDuplicateEmail);
	if (mysqli_num_rows($searchDuplicateEmailResult) > 0) {
		while($emailResultRow = mysqli_fetch_assoc($searchDuplicateEmailResult)) { 
			
			$DupEmailRes["result"] = true;
			$DupEmailRes["userId"] = $row["id"];
			return $DupEmailRes;
			
		}
	}
	else {
		$DupEmailRes["result"] = false;
		return $DupEmailRes;
	}
}

echo json_encode($responseArr);
?>