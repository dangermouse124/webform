<?php
require_once 'contractorLogin.php';

$con = mysqli_connect($host,$user,$pass,$db);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

function rejig($row, $cnt) {
	$rejigged = array();
	foreach ($row as $key => $value) {
		$newkey = $key;
		if ($newkey[0] == "w") {
			$newkey = substr_replace($newkey, $cnt, 4, 1);
		}
		$rejigged[$newkey] = $value;
	}
	
    return $rejigged;
}


$sql = "SELECT * FROM week1 ORDER BY id DESC LIMIT 4 ";
$result = mysqli_query($con, $sql);

$rows = array();
$renamed = array();

$cnt = 2;
while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	$name = "week" . $cnt;
	$row = rejig($row, $cnt);
	$rows[$name] = $row;
	$cnt++;
}

mysqli_free_result($result);

$myJSON = json_encode($rows);
echo $myJSON;


mysqli_close($con);


?>