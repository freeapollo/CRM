<?php


 header("Access-Control-Allow-Origin: *");
class Group{
	
	public $id;
	private $name;
	private $details;
	private $admin;
	private $members;
	private $membersCount;
	private $createdOn;
	public $isGroupAdded;
	public $message;
	public $segId;
	
	public function __construct ( $Id,$Name,$Details,$Admin,$Members,$MembersCount,$createdOn,$segId) {
            $this->id = $Id;
            $this->name = $Name;
            $this->details = $Details;
            $this->admin = $Admin;
            $this->members = $Members;
            $this->membersCount = $MembersCount;
            $this->createdOn = $createdOn;
            $this->segId = $segId;
          }
	
	public function getId(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function getDetails(){
		return $this->details;
	}
	public function getAdmin(){
		return $this->admin;
	}
	public function getMembers(){
		return $this->members;
	}
	public function getMembersCount(){
		return $this->membersCount;
	}
	public function getOfcAddress(){
		return $this->ofcAddress;
	}
	public function getCreatedOn(){
		return $this->createdOn;
	}
	public function getSegmentId(){
		return $this->segId;
	}
	
}




?>