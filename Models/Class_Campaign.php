<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Class_Campaign
 *
 * @author sanwe
 */
class Campaign {
    public $id;
    public $name;
    public $createdBy;
    public $emails;
    public $subject;
    public $body;
    public $recievedBy;
    public $dates;
    public $replacingContent;
    public $tempId;
    public $isAdded;
    public $msg;
    
    function __construct($id, $name, $createdBy, $emails, $subject, $body, $recievedBy, $dates, $replacingContent,$tempId) {
        $this->id = $id;
        $this->name = $name;
        $this->createdBy = $createdBy;
        $this->emails = $emails;
        $this->subject = $subject;
        $this->body = htmlentities($body);
        $this->recievedBy = $recievedBy;
        $this->dates = $dates;
        $this->replacingContent = $replacingContent;
        $this->tempId = $tempId;
    }

    
    
    
}
