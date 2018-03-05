<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailMgr
 *
 */
class EmailMgr {
    //put your code here
    public $apiKey;

    function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, charactersLength - 1)];
        }
        return $randomString;
    }    
   
    public function addList($name){
        $apiKey = $this->apiKey;
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists';

        $json = '{"name":"'
                . $name
                . $this->generateRandomString()
                . '","contact":{"company":"'
                . $name
                . '","address1":"Pune","address2":"NA","city":"Pune","state":"MH","zip":"311038","country":"IN","phone":""},"permission_reminder":"This is the mail from Mailchimp Campaign","campaign_defaults":{"from_name":"Shashank","from_email":"shashanksmf@gmail.com","subject":"Custom Subject","language":"en"},"email_type_option":true}';

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        curl_close($ch);

        return $result;
    }

        
        
    
function addMebmberToList($emails,$listId,$fName,$lName,$interest) {
    $apiKey = $this->apiKey;
    
    $memberId = md5(strtolower($emails));
    $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members';
    $json = '{"email_address":"'
            . $emails
            . '", "status":"subscribed"'
            . ',"merge_fields":{"FNAME":"'
            . $fName
            . '","LNAME":"'
            . $lName
            . '"}}';
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch);
    curl_close($ch);

    return $result;
}









   
    
function addCampaign($replyTo,$listId,$fromName,$subject) {
    $apiKey = $this->apiKey;
    //$listId = '94df52744b';

    $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/campaigns';
    $json = '{"recipients":{"list_id":"'
            . $listId
            . '"},"type":"regular","settings":{"subject_line":"'
            . $subject
            . '","reply_to":"'
            . $replyTo
            . '","from_name":"'
            . $fromName
            . '"}}';
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch);
    curl_close($ch);

    return $result;
}


 
    




   
    
function addCampaign2($replyTo,$listId,$fromName,$subject,$segId) {
    $apiKey = $this->apiKey;
    //$listId = '94df52744b';

    $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/campaigns';
    $json = '{"recipients":{"list_id":"'
            . $listId
            . '","segment_opts":{"saved_segment_id":'
            . $segId
            . '}},"type":"regular","settings":{"subject_line":"'
            . $subject
            . '","reply_to":"'
            . $replyTo
            . '","from_name":"'
            . $fromName
            . '"}}';
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch);
    curl_close($ch);

    return $result;
}


 
    
function updateHtmlToCampaign($campaignId,$html) {
    $apiKey = $this->apiKey;
    $html = addslashes($html);
    $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/campaigns/'.$campaignId.'/content';
            
    $json = '{"html": "'
            . $html
            . '"}';
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch);
    curl_close($ch);

    return $result;
}




    
function runCampaign($campaignId) {
    $apiKey = $this->apiKey;
    $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/campaigns/'.$campaignId.'/actions/send';
             
   
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                                                            

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch);
    curl_close($ch);

    return $result;
}


public function getTemplates(){
        $apiKey = $this->apiKey;
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/templates';

        
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                                                        

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        curl_close($ch);

        return $result;
    }

    

public function getHtml($id){
        $apiKey = $this->apiKey;
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
       // $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/templates/'.$id;
        $url = 'https://cdn-images.mailchimp.com/template_screenshots/educate.png';
        
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                                                        

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        curl_close($ch);

        return $result;
    }

    


public function getList(){
        $apiKey = $this->apiKey;
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/';
       // $url = 'https://cdn-images.mailchimp.com/template_screenshots/educate.png';
        
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                                                        

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        curl_close($ch);

        $js = json_decode($result);
        
        $returns = $result->lists[0]->id;
        return $result;
    }

    


public function getActivityList($campaignId){
        $apiKey = $this->apiKey;
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        //$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/reports/'.$campaignId.'/email-activity';
        $url = 'https://us15.api.mailchimp.com/3.0/reports/c45257dbfe';
        
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                                                        

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        curl_close($ch);

        $js = json_decode($result);
        
        //$returns = $result->lists[0]->id;
        return $result;
    }

    




    

    public function addSegment($name) {
        //echo 'name :' .$name;
        $apiKey = $this->apiKey;
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/d0a4dda674/segments';

        $json = '{"name": "'
                . $name
                . '",'
                . '"static_segment":'
                . '["sankuwars@gmail.com","shankie1990@gmail.com"]'
                . '}';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        curl_close($ch);

        return $result;
    }


    public function addSegment2($name) {
        //echo 'name :' .$name;
        $apiKey = $this->apiKey;
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/d0a4dda674/segments';

        $json = '{"name": "'
                . $name
                . '",'
                . '"static_segment":'
                . '["sankuwars@gmail.com","shankie1990@gmail.com"]'
                . '}';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        curl_close($ch);

        return $result;
    }


    public function updateSegment($emails,$segId) {
        //echo 'name :' .$name;
        $apiKey = $this->apiKey;
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/d0a4dda674/segments/'
                . $segId
                . '/members';

        $json = '{"email_address" : "'
                . $emails
                . '", "status" : "subscribed"}';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch);
        curl_close($ch);

        return $result;
    }
    
    
    
    
}
