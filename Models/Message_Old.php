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
    private $fromTo;
    private $message;
    private $timestamp;
    public $isMessageAdded;
    public $returnMsg;
    
    function __construct($id, $fromTo, $message, $timestamp) {
        $this->id = $id;
        $this->fromTo = $fromTo;
        $this->message = $message;
        $this->timestamp = $timestamp;
    }

    function getId() {
        return $this->id;
    }

    function getFromTo() {
        return $this->fromTo;
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

    function setFromTo($fromTo) {
        $this->fromTo = $fromTo;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }


}
