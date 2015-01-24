<?php


/*
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

if (!mysql_select_db('rxnorm')) {
    die('Could not select database: ' . mysql_error());
}

$str = $_GET['str'];

$q = "SELECT rxcui, str FROM rxnconso WHERE sab = 'rxnorm' AND tty = 'sbd' AND str = '$str'";

$r = mysql_query($q);

if (!$r) {
    die('Could not query:' . mysql_error());
}

$rs = array();

while($row = mysql_fetch_assoc($r)) {
    $rs[] = $row;
}



$json = json_encode($rs);

echo $json;

mysql_close($link);
*/
?>