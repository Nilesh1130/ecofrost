<?php
/*
 *  CONFIGURE EVERYTHING HERE
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
 /* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$servername = "localhost";
$username = "root";
$password = "Nilesh@1130";
$dbname = "test";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST)){
	$return_arr = array();
	$roomValue = $_POST['room'];
	$imeiValue = $_POST['imei'];
	$iccidValue = $_POST['iccid'];
	$power_supply = $_POST['power_supply'];
	$ice_core_units = $_POST['ice_core_units'];
	$slaves_number = $_POST['slaves_number'];
	$room = !empty($roomValue) ? "'$roomValue'" : "NULL";
	$imei = !empty($imeiValue) ? "'$imeiValue'" : "NULL";
	$iccid = !empty($iccidValue) ? "'$iccidValue'" : "NULL";

	$conn->query("INSERT INTO ecofrost_test (power_supply, ice_core_units, slaves_number, room, imei, iccid)
	VALUES ($power_supply,$ice_core_units,$slaves_number,$room,$imei,$iccid)")
	or die(mysqli_error($conn));

	if ($conn->affected_rows > 0) {
		$return_arr = array(
			"status" => 1,
            "data" => 'You have successfully submitted form'
        );
	} else {
		$return_arr = array(
			"status" => 0,
            "data" => 'Something went wrong.'
        );
	}
	$conn->close();
	echo json_encode($return_arr);
}

  // $query = mysqli_query($link,"INSERT INTO ecofrost_test (power_supply, ice_core_units, slaves_number, room, imei, iccid)
  // VALUES ($_POST['power_supply'],$_POST['ice_core_units'],$_POST['slaves_number'],$_POST['room'],$_POST['imei'],$_POST['iccid'])");
  // mysqli_query( $link, $query );