<?php
require_once 'contractorLogin.php';

$con = mysqli_connect($host,$user,$pass,$db);
if(!$con) {
	$returnMsg["message"] = "DB connection error";
	$jsonMsg = json_encode($returnMsg);
	echo $jsonMsg;
	exit(1);
}

$returnMsg = array();
//$currentWeekNumber = date('W');


$name1 = 'INSERT INTO week1 (';
$value1 = ' VALUES (';

//escapes special characters and builds sql query with POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	foreach($_POST as $key => $value) {
		$value = mysqli_real_escape_string($con, $value);
		$name1 = $name1 . $key . ",";
		$value1 = $value1 . "'" . $value . "'" . ",";
	}
} else {
	$returnMsg["message"] = "POST method error!";
	$jsonMsg = json_encode($returnMsg);
	echo $jsonMsg;
	exit(1);
}

//Gets rid of the last comma
$name1 = substr($name1, 0, -1);
$name1 = $name1 . ")";
$value1 = substr($value1, 0, -1);
$value1 = $value1 . ")";

$sql = $name1 . $value1;

//echo $sql;


if (mysqli_query($con, $sql)) {
	$returnMsg["message"] = "Successful DB entry!";
} else {
    $returnMsg["message"] = "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$jsonMsg = json_encode($returnMsg);
echo $jsonMsg;

mysqli_close($con);
	
?>