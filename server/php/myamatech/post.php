<?php
//@include("hinit.php");
$order_type = $_POST['order_type'];
$quantity = $_POST['quantity'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$company = $_POST['company'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];

//echo "<h1>Edo Imaste</h1>";

date_default_timezone_set('Europe/Athens');


$sql = "INSERT INTO upload
		(
			upload_order_type,
			upload_quantity,
			upload_firstname,
			upload_lastname,
			upload_company,
			upload_phone,
			upload_email,
			upload_message,
			upload_entry_date,
			upload_ip,
			upload_agent
		)
		VALUES
		(
			'".$order_type."',
			'".$myClass->checkForCorrectValue($quantity,0)."',
			'".htmlspecialchars($first_name, ENT_QUOTES)."',
			'".htmlspecialchars($last_name, ENT_QUOTES)."',
			'".htmlspecialchars($company, ENT_QUOTES)."',
			'".$phone."',
			'".$email."',
			'".htmlspecialchars($message, ENT_QUOTES)."',
			'".date('y-m-d h:i:s')."',
			'".$_SERVER['REMOTE_ADDR']."',
			'".$_SERVER['HTTP_USER_AGENT']."'
		)
		";
if( mysql_query($sql) != 1 )
{
	//Catch error
	$myClass->catchErrors( "post.php Line 46: ".mysql_error() );	
}

$last_id = $myClass->getLastId();




//include("dropbox_apis_v2/testConnectToDropbox.php");

//add to dropbox
include("dropbox_apis/addToDropbox.php");

//include("dropbox_apis/test_2.php");

//include("dropbox_apis/accountInfo.php");

?>