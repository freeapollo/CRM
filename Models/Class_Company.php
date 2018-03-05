<?php


 header("Access-Control-Allow-Origin: *");
class Company{
	
        public $id;
	private $name;
	private $areaOfWork;
	private $establised;
	private $employees;
	private $revenue;
	private $ofcAddress;
	private $email;
	private $phone;
	private $logo;
	private $fb;
	private $tw;
        public  $isUpdateSuccess;
        public $outMessage;
        public $extra;


        public function __construct ( $Id, $Name, $AreaOfWork, $Establised, $Employees, $Revenue, $OfcAddress, $Email, $Phone, $Logo, $Fb, $Tw) {
            $this->id= $Id;
            $this->name = $Name;
            $this->areaOfWork = $AreaOfWork;
            $this->establised = $Establised;
            $this->employees = $Employees;
            $this->revenue = $Revenue;
            $this->ofcAddress = $OfcAddress;
            $this->email = $Email;
            $this->phone = $Phone;
            $this->fb = $Fb;
            $this->tw = $Tw;
            $this->logo = $Logo;
          }
	
	public function getName(){
		return $this->name;
	}
	public function getAreaOfWork(){
		return $this->areaOfWork;
	}
	public function getEstablised(){
		return $this->establised;
	}
	public function getEmployees(){
		return $this->employees;
	}
	public function getRevenue(){
		return $this->revenue;
	}
	public function getOfcAddress(){
		return $this->ofcAddress;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getPhone(){
		return $this->phone;
	}
	public function getLogo(){
		return $this->logo;
	}
	public function getFb(){
		return $this->fb;
	}
	public function getTw(){
		return $this->tw;
	}
}

?>