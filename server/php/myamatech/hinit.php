<?php
@session_start();
include("define_file.php");								        //parameters of connection
include("classes/tbl_param_class_AddEditDelete.php");				//Classes					
//include("classes/myClasses.php");
include("classes/class_2.php.php");

/**** GlassApps_All ****/
$myClass = new TtblParamAddEditDeleteSecond(); //TtblParamAddEditDelete();
$myClass->TConnect();
																									
$myClass->setValue($database_host,$DB_dropbox,$db_user,$db_pass);												
$GlassAllconn_id = $myClass->connectToDatabase();
$error = $myClass->selectDatabase();



?>

