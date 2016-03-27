<?php
/*
* @group_4code_costing_gross_profit.php
*
* @Version		1.0
* @Date			14-04-2010
*
* @Created		14-04-2010
*
* @Owner        Glass Studio 2008
* @By Ambitos   (C)
*/

include("../define_file.php");								        //parameters of connection
include("tbl_param_class_AddEditDelete.php");				//Classes					
include("myClasses.php");


/**** GlassApps_All ****/
$myClass = new TtblParamAddEditDelete();
$myClass->TConnect();																				//Κλήση της κλάσης TConnect χωρίς ορίσματα 
																									//Εδώ η βάση παίρνει την θύρα 3306 ( by default ) τιμή
																									//της MySql
																									
$myClass->setValue($database_host,$DB_glass_apps_all,$db_user,$db_pass);										//Σύνδεση με την βάση																									
$GlassAllconn_id = $myClass->connectToDatabase();
$error = $myClass->selectDatabase();
/*****/

$connection_id = $_REQUEST['connection_id'];

$res = mysql_close( $connection_id );

echo $res."";


?>