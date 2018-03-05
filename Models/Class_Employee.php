<?php
 header("Access-Control-Allow-Origin: *");

require_once("Class_Company.php");

class Employee{
	
	private $id;
	private $companyId;
	private $name;
	private $title;
	private $industry;
	private $location;
	private $ratings;
	private $foundIn;
	
	
	public function __construct ( $Id, $CompanyId, $Name, $Title, $Industry, $Location, $Ratings, $FoundIn) {
		$this->id = $Id;
		$this->companyId = $CompanyId;
		$this->name = $Name;
		$this->title = $Title;
		$this->industry = $Industry;
		$this->location = $Location;
		$this->ratings = $Ratings;
		$this->foundIn = $FoundIn;
  }
	
	public function getId(){
		return $this->id;
	}
	public function getCompanyId(){
		return $this->companyId;
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
}




?>