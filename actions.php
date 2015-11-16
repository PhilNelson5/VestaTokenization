<!DOCTYPE html>
<?php
require('helpers.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Time out response                     4002432198795432
//Successful transaction                4200123456719012
//pended transaction                    4628610683834808
//  <ShoppingCart xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></ShoppingCart>
//    'ChargeAccountNumber'            => '4002432198795432',
//    PERSONAL ACCOUNT
//    'AccountName'              => BcI/eAaBXWvNozS3xMK5kw==
//    'Password'                 => WNkDUagtVq6w+37jmkcIzXjFGZ27pnp74GzCXcBi3OmH35zrXkNs6/lSaW2n1vx9
//    
//    VESTA ACCOUNT
//    'AccountName'              => c91yKKKHf+rCSzgwdeuD9g==
//    'Password'                 => HTp+CKx137DjQ/ojL+beveq0wWvrwJnsvxjuV/TMz8ue3kGyA5WIAGlkIGVl2J88
//    
//AccountName=>"pZ8H7jvp98+bR7vyskYLsA==“, 
//Password=>"lJKC1an4pEKHPMiko7lCI9au/8m4hasy3R0hqYElqIUZ19IdGYSaL96pKJyHIUci”

//Tokenization is happening client side using the tokenization js file and included in the post parameters in a hidden fiels.

//Strip empty tags from array because sandbox runs validation on these even if they are empty
$_POST = array_filter($_POST);

if(isset($_POST["api_method"]) AND $_POST["api_method"] == "ChargeSale") {

    debug_to_console('Using Tokenization, Inside Charge Sale:', $_POST);
    
    $webSessionID ='';
    $webSessionID = getSessionTags($_POST)['WebSessionID'];
    debug_to_console('Web session ID returned from GetSession Tags <br />', $webSessionID);
    
    $_POST['WebSessionID'] = $webSessionID;

    debug_to_console('ChargeSale calling callChargeSale with this post data:', $_POST);
    callChargeSale($_POST);
}
elseif(isset($_POST["api_method"]) AND $_POST["api_method"] == "GetSessionTags") {

    getSessionTags($_POST);
}
elseif(isset($_POST["api_method"]) AND $_POST["api_method"] == "ChargeAuthorize") {
    debug_to_console('Parameters sent to AuthorizePayment:', $_POST);

    $webSessionID ='';
    $webSessionID = getSessionTags($_POST)['WebSessionID'];
    debug_to_console('Web session ID returned from GetSession Tags <br />', $webSessionID);
    
    $_POST['WebSessionID'] = $webSessionID;

$query = http_build_query($_POST);
 
$url = 'https://paysafesandbox.ecustomersupport.com/GatewayProxy/Service/ChargeAuthorize';
 
$context = stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => "Connection: close\r\n"
                   . "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => $query
    )
));
 
$result = array();
parse_str(file_get_contents($url, false, $context), $result);

$error = null;
if ($result['ResponseCode'] == 0) {
    debug_to_console('Success in Charge Authorize<br />', $result);
} else {
    debug_to_console('Error in Charge Authorize<br />', $result);
}
}
else {
    echo 'Im Sorry, Something has gone wrong';
}

function getSessionTags($Post_Data) {
    $url = 'https://paysafesandbox.ecustomersupport.com/GatewayProxy/Service/GetSessionTags';
 
    debug_to_console('Post data sent to getSessionTags', $Post_Data);
 
$context = stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => "Connection: close\r\n"
                   . "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($Post_Data)
    )
));
 
$result = array();
 
parse_str(file_get_contents($url, true, $context), $result);
 
$error = null;
if ($result['ResponseCode'] == 0) {
    debug_to_console('Successfully called GetSessionTags<br />', $result);
    $fingerprintEndpoint = 'https://paysafesandbox.ecustomersupport.com/ThreatMetrixUIRedirector';
    $embedHtml = sprintf(       '<p style="background:url(%1$s/fp/clear.png?org_id=%2$s&session_id=%3$s&m=1);"></p> <img src="%1$s/fp/clear.png?org_id=%2$s&session_id=%3$s&m=2" /> <script type="text/javascript" src="%1$s/fp/check.js?org_id=%2$s&session_id=%3$s"></script> <object data="%1$s/fp/fp.swf?org_id=%2$s&session_id=%3$s" type="application/x-shockwave-flash" width="1" height="1"> <param value="%1$s/fp/fp.swf?org_id=%2$s&session_id=%3$s" name="movie" /> </object>'
            , $fingerprintEndpoint
        , $result['OrgID']
        , $result['WebSessionID']);
 
    echo $embedHtml;
} else {
    // An error occurred
    $error = $result['ResponseText'];
}
return $result;
}

function callChargeSale($Post_Data) {
     debug_to_console("callChargeSale Parameters", $Post_Data);
$query = http_build_query($Post_Data);
 
$url = 'https://paysafesandbox.ecustomersupport.com/GatewayProxy/Service/ChargeSale';
 
$context = stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => "Connection: close\r\n"
                   . "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => $query
    )
));
 
$result = array();
parse_str(file_get_contents($url, false, $context), $result);
 
$error = null;

if ($result['ResponseCode'] == 0) {
    
    debug_to_console("Successful call to ChargeSale:<br />", $result);
    
    return $result;
} else {
    $error = $result['ResponseText'];
   
    debug_to_console("OOPS, We have an error:<br />", $error);
    return $error;
}
}

function debug_to_console($message, $data) {
    if(is_array($data) || is_object($data))
	{
		echo("<script>console.log('PHP: $message ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('PHP: $message".$data."');</script>");
	}
}

