<?php
 header("Access-Control-Allow-Origin: *");

require_once("Class_Company.php");

class Employees{
	
	public $id;
	private $name;
	private $title;
	private $industry;
	private $location;
	private $ratings;
	private $companyId;
	private $skype;
	private $age;
	private $gender;
	private $officePhone;
	private $jobRole;
	private $phone;
	private $email;
	private $linkedin;
	private $twitter;
	private $facebook;
	private $notes;
	public $isUpdateSuccess;
	public $outMessage;
	public $foundIn;
	public $imgurl;
	public $extra;
	
	
	public function __construct ( $Id, $Name, $Title, $Industry, $Location, $Ratings, $FoundIn, $companyId, $skype, $age, $gender, $officePhone, $jobRole, $phone, $email, $linkedin, $twitter, $facebook,$notes,$Imgurl) {
		$this->id = $Id;
		$this->name = $Name;
		$this->title = $Title;
		$this->industry = $Industry;
		$this->location = $Location;
		$this->ratings = $Ratings;
		$this->foundIn = $FoundIn;
		
		
		$this->companyId = $companyId;
		$this->skype = $skype;
		$this->age = $age;
		$this->gender = $gender;
		$this->officePhone = $officePhone;
		$this->jobRole = $jobRole;
		$this->phone = $phone;
		$this->email = $email;
		$this->linkedin = $linkedin;
		$this->twitter = $twitter;
		$this->facebook = $facebook;
		$this->notes = $notes;
		$this->imgurl = $Imgurl;
  }
	
	public function getId(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function getTitle(){
		return $this->title;
	}
	public function getIndustry(){
		return $this->industry;
	}
	public function getLocation(){
		return $this->location;
	}
	public function getRatings(){
		return $this->ratings;
	}
	
	public function getFoundIn(){
		return $this->foundIn;
	}
	
	
	
	
	
	public function getCompanyId(){
		return $this->companyId;
	}
	public function getSkype(){
		return $this->skype;
	}
	public function getAge(){
		return $this->age;
	}
	public function getGender(){
		return $this->gender;
	}
	public function getOfficePhone(){
		return $this->officePhone;
	}
	public function getJobRole(){
		return $this->jobRole;
	}
	public function getPhone(){
		return $this->phone;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getLinkedin(){
		return $this->linkedin;
	}
	public function getTwitter(){
		return $this->twitter;
	}
	public function getFacebook(){
		return $this->facebook;
	}
	public function getNotes(){
		return $this->notes;
	}
}




?>