<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author sanwe
 */
class Message {
    public $id;
    private $from;
    private $to;
    private $message;
    private $timestamp;
    public $isMessageReaded;
    public $isMessageAdded;
    public $returnMsg;
	public $fromUserName;
	public $profilePic;
    
    function __construct($id, $from,$to, $message, $timestamp,$isMessageReaded,$fromUserName,$profilePic) {
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
        $this->message = $message;
        $this->timestamp = $timestamp;
        $this->isMessageReaded = $isMessageReaded;
		$this->fromUserName = $fromUserName;
		$this->profilePic = $profilePic;
    }

    function getId() {
        return $this->id;
    }

    function getFrom() {
        return $this->from;
    }

    function getTo() {
        return $this->to;
    }

    function getMessage() {
        return $this->message;
    }

    function getTimestamp() {
        return $this->timestamp;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTo($to) {
        $this->to = $to;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
	
	 function getFromUserName($fromUserName) {
        $this->fromUserName = $fromUserName;
    }
	
	function getProfilePic($profilePic) {
        $this->profilePic = $profilePic;
    }


}
