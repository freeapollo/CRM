<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Class_Email
 *
 * @author sanwe
 */
class Email {
    
    public $id;
    public $sender;
    public $reciever;
    public $subject;
    public $body;
    public $name;
    public $mailKey;
    public $isAdded=FALSE;
    public $message="";
    
    

    function __construct($id, $sender, $reciever, $subject, $body, $name, $mailKey) {
        $this->id = $id;
        $this->sender = $sender;
        $this->reciever = $reciever;
        $this->subject = $subject;
        $this->body = $body;
        $this->name = $name;
        $this->mailKey = $mailKey;
    }

    

}
