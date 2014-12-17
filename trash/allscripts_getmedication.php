<?php
// GLOBALS
$API_USER     = "ACEP";
$API_PASS     = "allscripts2014";
$APP_NAME     = "LeGrand.medlist.TestApp";
$APP_USER     = "LeGra-medlist-test";
$APP_PASS     = "L%gR@nD1f209";
$MRN          = $_GET['mrn'];
$PATIENT_NAME = $_GET['pname'];

// URL STUFFS
$url_send ="http://sunriselatestga.unitysandbox.com/Unity/UnityService.svc/json";

$url_token = "/GetToken";
$url_magic = "/MagicJson";

// POST FUNCTION
function sendPostData($url, $post){
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  $result = curl_exec($ch);
  curl_close($ch);  // Seems like good practice
  return $result;
}

// GET USER TOKEN
$app_auth = array(
  "Username" => $APP_USER,
  "Password" => $APP_PASS,
);

$app_json = json_encode($app_auth, JSON_PRETTY_PRINT);
$token = sendPostData($url_send . $url_token, $app_json);

// AUTHENTICATE USER
$user_auth = array(
  "Action" => "GetUserAuthentication",
  "AppUserID" => $API_USER,
  "Appname" => $APP_NAME,
  "PatientID" => "",
  "Token" => $token,
  "Parameter1" => $API_PASS,
  "Parameter2" => "",
  "Parameter3" => "",
  "Parameter4" => "",
  "Parameter5" => "",
  "Parameter6" => "",
  "Data" => "null"
);

$user_json = json_encode($user_auth, JSON_PRETTY_PRINT);
sendPostData($url_send . $url_magic, $user_json);

// GET PATIENT MEDICATION INFO
if ( ! isset($MRN) ) {
$search = array(
  "Action" => "SearchPatients",
  "AppUserID" => $API_USER,
  "Appname" => $APP_NAME,
  "PatientID" => "",
  "Token" => $token,
  "Parameter1" => $PATIENT_NAME,
  "Parameter2" => "",
  "Parameter3" => "",
  "Parameter4" => "",
  "Parameter5" => "",
  "Parameter6" => "",
  "Data" => "null"
);

$search_json = json_encode($search, JSON_PRETTY_PRINT);
sendPostData($url_send . $url_magic, $search_json);
}
else {
$meds = array(
  "Action" => "GetMedications",
  "AppUserID" => $API_USER,
  "Appname" => $APP_NAME,
  "PatientID" => $MRN,
  "Token" => $token,
  "Parameter1" => "",
  "Parameter2" => "",
  "Parameter3" => "",
  "Parameter4" => "",
  "Parameter5" => "",
  "Parameter6" => "",
  "Data" => "null"
);

$meds_json = json_encode($meds, JSON_PRETTY_PRINT);
$patient_meds = sendPostData($url_send . $url_magic, $meds_json);
}

$patient_meds_json = json_decode($patient_meds, JSON_PRETTY_PRINT);
echo var_dump($patient_meds_json);
echo $patient_meds_json->{'ChartGuid'};
?>
