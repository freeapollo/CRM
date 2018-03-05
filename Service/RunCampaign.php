<?php

require('../libs/mandril/Mandrill.php');
 require('../Controller/Class_Group_Controller.php');
 require('../Controller/Class_Campaign_Controller.php');
 require ('../Controller/Class_Template_Controller.php');
       $campaignId = $_GET['id'];
       
       $resAr = array();
       $camps = new CampaignController();
       
       
       
       $groupId = $camps->getCampaignList($campaignId)[0]->groupId;
       $tempId = $camps->getCampaignList($campaignId)[0]->tempId;
       $subject = $camps->getCampaignList($campaignId)[0]->subject;
       
       $template = "";
       $templateC = new TemplateController(); 
       $template = $templateC->getTemplateList($tempId)[0]->html;
       $to = "";
       $toName = "";
       
       $grp = new GroupController();
       $list = $grp->getGroupList($groupId);
       
       
       
       $empls = $grp->getUserList($list[0]->getMembers());
       $ii = 0;
       foreach($empls as $empl) {
           
             $template = str_replace("CHANGETHISNAME", $empl->getName(), $template);
             $template = str_replace("ADDBODYHERE", $camps->getCampaignList($campaignId)[0]->body, $template);
       
       
       
	try {
    $mandrill = new Mandrill('zXgKhQkDREZr-GmCdkorpw');
    $message = array(
        'html' => $template,
        'text' => 'Example text content',
        'subject' => $subject,
        'from_email' => 'info@raffia.co',
        'from_name' => 'Online Support Mail',
        'to' => array(
            array(
                'email' => $empl->getEmail(),
                'name' => $empl->getName(),
                'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => 'info@raffia.co'),
        'important' => false,
        'track_opens' => null,
        'merge' => true,
        'merge_language' => 'mailchimp',
        'global_merge_vars' => array(
            array(
                'name' => 'name',
                'content' => 'merge1 content'
            ),
			array(
                'name' => 'email',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        )
    );
    $async = false;
    $ip_pool = 'Main Pool';
   // $send_at = '24/03/2017';
    $result = $mandrill->messages->send($message, $async, $ip_pool, @$send_at);
    $resAr[$ii] = $result;
    $ii++;
    //header('Content-Type: application/json');
	
    //echo json_encode($result);
    
    
    //print_r($result);
    /*
    Array
    (
        [0] => Array
            (
                [email] => recipient.email@example.com
                [status] => sent
                [reject_reason] => hard-bounce
                [_id] => abc123abc123abc123abc123abc123
            )
    
    )
    */
} catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
}

    
           
        }
       // print_r($resAr);
        $jsonStr = '{"responce":true,"result":[';
        $i=count($resAr);
                
        foreach ($resAr as $value) {
             $jsonStr.='{';
                    $jsonStr.='"email":"'.$value[0]['email'].'",';
                    $jsonStr.='"status":"'.$value[0]['status'].'"}';
                    $i--;
                    if($i!=0){
                            $jsonStr.=',';
                    }
        }
        $jsonStr.=']}';
        header('Content-Type: application/json');
        echo $jsonStr;
        
?>
