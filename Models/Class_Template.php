<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassTemplate
 *
 * @author sanwe
 */
class Template {
    //put your code here
    public $id;
    public $name;
    public $html;
    public $addedBy;
    public $isAdded;
    public $msg;
    
    
    
    function __construct($id, $name, $html, $addedBy) {
        $this->id = $id;
        $this->name = $name;
        $this->html = $html;
        $this->addedBy = $addedBy;
    }

    
    
}
