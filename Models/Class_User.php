<?php



class User{
	
	private $id;
	public $isSignedUp;
	public $isSignedIn;
	public $message;
	private $name;
	private $department;
	private $hireDate;
	private $dob;
	private $gender;
	private $homeAddress;
	private $email;
	private $phone;
	private $profilePic;
	
	public function __construct ($Id, $Name, $Department, $HireDate, $Dob, $Gender, $HomeAddress, $Email, $PhoneNumber, $ProfilePic) {
            $this->id = $Id;
            $this->name = $Name;
            $this->department = $Department;
            $this->hireDate = $HireDate;
            $this->dob = $Dob;
            $this->gender = $Gender;
            $this->homeAddress = $HomeAddress;
            $this->email = $Email;
            $this->phone = $PhoneNumber;
            $this->profilePic = $ProfilePic;
          }
	
	public function getName(){
		return $this->name;
	}
	
	public function getId(){
		return $this->id;
	}
	public function getDepartment(){
		return $this->department;
	}
	public function getHireDate(){
		return $this->hireDate;
	}
	public function getDob(){
		return $this->dob;
	}
	public function getGender(){
		return $this->gender;
	}
	public function getHomeAddress(){
		return $this->homeAddress;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getPhone(){
		return $this->phone;
	}
	public function getProfilePic(){
		return $this->profilePic;
	}
        public function getIsSignedIn(){
		return $this->isSignedIn;
	}
        public function getIsSignedUp(){
		return $this->isSignedUp;
	}
        public function getMessage(){
		return $this->message;
	}
}




?>