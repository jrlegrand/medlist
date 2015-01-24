<?php
$text = "3.1";
//$text = 'status';
$text = 'rank';
$number = "+8155453389";

$data = json_decode(file_get_contents('data.json'),true);

if(!array_key_exists($number, $data)) {
	$data[$number]["miles"] = 0.0;
	$data[$number]["name"] = $number;
}

if(is_numeric($text)) {
	$data[$number]["miles"] += $text;
	echo 'You have now exercised ' . $data[$number]["miles"] . ' miles!';
} elseif(strtoupper($text) === 'RANK') {
	usort($data, function($a, $b) {
		return $a["miles"] - $b["miles"];
	});
	foreach($data as $d) {
		echo $d["name"] . ' = ' . $d["miles"] . ' miles<br>';
	}
} elseif(strtoupper($text) === 'STATUS') {
	echo 'You have exercised ' . $data[$number]["miles"] . ' miles!';
}

file_put_contents('data.json', json_encode($data));
//print_r($data);
?>