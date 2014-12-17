<html>
<body style="width:500px;"><p>
<?php

// GET USER TOKEN

$auth = array(
  "Username" => "LeGra-medlist-test",
  "Password" => "L%gR@nD1f209",
);

$url_send ="http://sunriselatestga.unitysandbox.com/Unity/UnityService.svc/json";

$url_token = "/GetToken";
$url_magic = "/MagicJson";

$str_auth = json_encode($auth, JSON_PRETTY_PRINT);

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

$token = sendPostData($url_send . $url_token, $str_auth);

echo "TOKEN: " . $token;

// AUTHENTICATE USER

$userAuth = array(
  "Action" => "GetUserAuthentication",
  "AppUserID" => "ACEP",
  "Appname" => "LeGrand.medlist.TestApp",
  "PatientID" => "",
  "Token" => $token,
  "Parameter1" => "allscripts2014",
  "Parameter2" => "",
  "Parameter3" => "",
  "Parameter4" => "",
  "Parameter5" => "",
  "Parameter6" => "",
  "Data" => "null"
);

$userJSON = json_encode($userAuth, JSON_PRETTY_PRINT);

echo "<br><br>USER AUTH JSON:   " . $userJSON;
echo "<br><br>USER AUTH RESULT: <br>" . sendPostData($url_send . $url_magic, $userJSON);

// RUN API FUNCTION

$data = array(
  "Action" => "GetMedications",
  "AppUserID" => "ACEP",
  "Appname" => "LeGrand.medlist.TestApp",
  "PatientID" => "200200",
  "Token" => $token,
  "Parameter1" => "Y",
  "Parameter2" => "",
  "Parameter3" => "",
  "Parameter4" => "",
  "Parameter5" => "",
  "Parameter6" => "",
  "Data" => "null"
);

$dataJSON = json_encode($data, JSON_PRETTY_PRINT);

echo "<br><br>API CALL JSON:   " . $dataJSON;
echo "<br><br>API CALL RESULT: <br>" . sendPostData($url_send . $url_magic, $dataJSON);

?>
</p></body>
</html>
