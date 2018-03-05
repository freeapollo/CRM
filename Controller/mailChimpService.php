
<?php

//$email = 'shankie1990@gmail.com';
//$first_name = 'shashankGmail';
//$last_name = 'Jaiswal';

class MailChimpService {

  public function subscribeUser($email,$first_name,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id) {
     
    $auth = base64_encode( 'user:'.$mailChimpApiKey);
        
    $data = array(
        'apikey'        => $mailChimpApiKey,
        'email_address' => $email,
        'status'        => 'subscribed',
        'merge_fields'  => array(
            'FNAME' => $first_name
            )    
        );

    $json_data = json_encode($data);
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/'.md5(strtolower($email)));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
     
    $result = curl_exec($ch);
    return $result;
  } 

  //$subUser = subscribeUser($email,$first_name,$mailChimpApiKey,$mailChimpSubDomainInit,$list_id);
  //echo $subUser;

  //echo "<div>There is agap </div><br/>";


  public function unSubscribeUser(){
    //lowercase and md5 of email address is compulsory
  //  strtolower md5
  }

  public function readList($mailChimpSubDomainInit,$mailChimpApiKey,$list_id){

    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
    $result = curl_exec($ch);
    return $result;
  }

  //$rl = readList($mailChimpSubDomainInit,$mailChimpApiKey,$list_id);
  //echo "GAppy</br>".$rl;

  public function getMemberInfo($mailChimpSubDomainInit,$mailChimpApiKey,$email,$list_id){
  //  echo $mailChimpSubDomainInit.$mailChimpApiKey.$email.$list_id;
    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/'.md5(strtolower($email)));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
    $result = curl_exec($ch);
  }

  //$memberInfo = getMemberInfo($mailChimpSubDomainInit,$mailChimpApiKey,$email,$list_id);
  //echo "member Info".$memberInfo;
  //echo "<br/>".md5($email);
  //$result_obj = json_decode($result);
   
  public function createSegment($groupName,$mailChimpSubDomainInit,$emailArr,$list_id,$mailChimpApiKey) {
  //  print_r($emailArr);
    //echo $groupName."/".$mailChimpSubDomainInit."/".$list_id."/".$mailChimpApiKey;
    //exit();
    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $data = array(
      'name'        => $groupName,
      'static_segment' => $emailArr    
      );

    $json_data = json_encode($data);
    //echo $json_data;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
    $result = curl_exec($ch); 
  }

  //$emailArr = array('shankie1990@gmail.com');
  //$groupName = "USA-GDP";
  //$createSeg = createSegment($groupName,$mailChimpSubDomainInit,$emailArr,$list_id,$mailChimpApiKey);
  //echo "createsergment".$createSeg;

  public function getAllSegments($mailChimpSubDomainInit,$list_id,$mailChimpApiKey) {

    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    
    //$json_data = json_encode($data);
    //echo $json_data;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
    $result = curl_exec($ch); 
  }


  public function getSegmentById($mailChimpSubDomainInit,$list_id,$mailChimpApiKey,$segmentId) {

     $auth = base64_encode( 'user:'.$mailChimpApiKey);
    
    //$json_data = json_encode($data);
    //echo $json_data;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments/'.$segmentId);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
    $result = curl_exec($ch); 

  }

  //$getSegments = getAllSegments($mailChimpSubDomainInit,$list_id,$mailChimpApiKey);
  //echo "segments: ".$getSegments;

  public function addBulkMembersToSegment($membersArr,$segmentId,$list_id,$mailChimpApiKey,$mailChimpSubDomainInit) {
  //  echo json_encode($membersArr)."/".$segmentId."/".$list_id."/".$mailChimpApiKey.$mailChimpSubDomainInit;
    //exit();
    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $data = array(
        'members_to_add' => $membersArr  
      );
    $json_data = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments/'.$segmentId);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
    $result = curl_exec($ch);

  }

  public function getMemberbySegmentId($mailChimpSubDomainInit,$list_id,$mailChimpApiKey,$segmentId) {
    
    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments/'.$segmentId.'/members');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    return $result;

  }

  //$membersArr = array('shankie1990','shashanksmf@outlook.com');
  //$bulkMembersAddReq = addBulkMembersToSegment($membersArr,'29009',$list_id,$mailChimpApiKey,$mailChimpSubDomainInit);
  //echo $bulkMembersAddReq;

  public function removeBulkMembersFromSegment($removeMemArr,$segmentId,$list_id,$mailChimpApiKey,$mailChimpSubDomainInit){
    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $data = array(
        'members_to_remove' => $removeMemArr
      );
    $json_data = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/lists/'.$list_id.'/segments/'.$segmentId);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
    $result = curl_exec($ch);
  }

  //$removeMemArr = array('shankie1990@gmail.com');
  //$bulkMembersRemoveReq = removeBulkMembersFromSegment($removeMemArr,'29009',$list_id,$mailChimpApiKey,$mailChimpSubDomainInit);
  //echo $bulkMembersRemoveReq;

  public function createTemplate($htmlStr,$mailChimpSubDomainInit,$mailChimpApiKey){

    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $data = array(
        'name' => 'basic-template',
        'html' => $htmlStr
      );

    $json_data = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/templates');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
    $result = curl_exec($ch);
  }

  //$createTemReq = createTemplate($htmlStr,$mailChimpSubDomainInit,$mailChimpApiKey);
  //echo $createTemReq;

  public function createCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$list_id,$segmentId,$subject,$emailBodyText,$title,$fromName,$replyTo,$toName,$templateId) { 
    // echo $mailChimpSubDomainInit."/".$mailChimpApiKey."/".$list_id."/".$segmentId;
    // exit();
     $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $data = array(
        'type' => 'plaintext',
        'recipients' => array( 
          'list_id' => $list_id,
          'segment_opts' => array(
              'saved_segment_id' => $segmentId
            )
         ),
        'settings' => array(
            'subject_line' => $subject,
            'preview_text'=> $emailBodyText,
            'title' => $title,
            'from_name' => $fromName,
            'reply_to' => $replyTo,
            'to_name' => $toName,
            'template_id' => $templateId
          )
      );

    $json_data = json_encode($data);
    //echo $json_data;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/campaigns');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
    return $result = curl_exec($ch);

  }

  //$segmentId = 29009;
  //$createCamReq = createCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$list_id,$segmentId);
  //echo $createCamReq;

  public function getAllCampaigns($mailChimpSubDomainInit,$mailChimpApiKey) {
    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/campaigns');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
    $result = curl_exec($ch);

  }

  //$getAllCampaignReq = getAllCampaigns($mailChimpSubDomainInit,$mailChimpApiKey);
  //echo $getAllCampaignReq;

  public function runCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$campaignId){
   // echo $mailChimpSubDomainInit."/".$mailChimpApiKey."/".$campaignId;
    $auth = base64_encode( 'user:'.$mailChimpApiKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$mailChimpSubDomainInit.'api.mailchimp.com/3.0/campaigns/'.$campaignId.'/actions/send');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',  
      'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
    $result = curl_exec($ch);

  }

  //$campaignId = '08c993f8cb';
  //$runCampaignReq = runCampaign($mailChimpSubDomainInit,$mailChimpApiKey,$campaignId);
  //echo $runCampaignReq;
}
?>

