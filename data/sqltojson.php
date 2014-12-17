<?php
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

if (!mysql_select_db('rxnorm')) {
    die('Could not select database: ' . mysql_error());
}

$q = "SELECT CONCAT(UPPER(SUBSTRING(str, 1, 1)), SUBSTRING(str FROM 2)) AS name, rxcui FROM rxnconso WHERE sab = 'rxnorm' AND tty = 'sbd'";

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

file_put_contents('meds.json', $json);

mysql_close($link);
?>