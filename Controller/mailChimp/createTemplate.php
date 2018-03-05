
<?php
  require_once("./../mailChimpTemplate.php");  
  
  function createTemplate($htmlStr,$mailChimpSubDomainInit,$mailChimpApiKey){

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
 require_once("./../MailChimpConfig.php");

 $mailChimpSubDomainInit = MailChimpConfig::$mailChimpSubDomainInit;
 $mailChimpApiKey = $mailChimpService->$mailChimpApiKey = getenv("mailChimpApiKey");
                   
 $createTemReq = createTemplate($htmlStr,$mailChimpSubDomainInit,$mailChimpApiKey);
 echo $createTemReq;

?>