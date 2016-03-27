<?php
echo "<h1>Connect to dropbox</h1>";
include("functions.php");

//echo "<h1>Connect to dropbox</h1>";

//include("accountInfo.php");

//include("putFile.php");

//init
require_once('bootstrap.php');


$maxTime = ini_get("max_execution_time");
ini_set("max_execution_time",1000);


//$last_id = $myClass->getLastId();
$upload_handler->myamatech_uploaded_id = $last_id;
$upload_handler->MyClass = $myClass;

if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
	$upload_handler->delete();
} else {
	$upload_handler->post();
}




$foldername = "Folder_".time();
if( strlen($company) ){
	$foldername = $company;
}else{
	$foldername = $first_name."_".$last_name;
}

$subfolder  = $foldername."/".$order_type."_".date('y-m-d')."_".date('h');//date('h-i-s');

//Check if folder exists

//$info = $dropbox->getFile("api_upload_test.txt");
try
{
	$info = $dropbox->metaData($foldername);
	//print_r($info);
	
	$jsonData = $info['body'];
	
	echo "<br>JSON<BR>";
	echo "<br>IS DIR:<br>";
	echo $jsonData->is_dir;
	echo "<br>revision<br>";
	echo $jsonData->revision;
	echo "<br>";
	
	
	if( $jsonData->is_dir == 1 )
	{
		echo "<br>IS DIR!! Create Folder<br>";
		//folder exists
		/*$i = 1;
		$foldername = findFolderName_v2($dropbox,$foldername,$i,$myClass);
		echo "<br>NewFolderName:".$foldername;
		$var = $dropbox->create($foldername);		
		*/
		
		//********* Create Subfolder :)  ************************//
		$subfolder  = $foldername."/".$order_type."_".date('y-m-d')."_".date('h');
		try
		{
			$info = $dropbox->metaData($subfolder);
			$jsonDataSub = $info['body'];
			if( $jsonDataSub->is_dir == 1 )
			{
				//Do nothing folder exists
			}
			else
			{
				$varSubFolder = $dropbox->create($subfolder,$foldername);		
			}
		}
		catch (Exception $e) 
		{
			$catch_error = 'addToDropbox.php line 86 '. 'Caught exception: '. $e->getMessage(). "\n<br>";
			
			$subfolder  = $foldername."/".$order_type."_".date('y-m-d')."_".date('h');
			$varSubFolder = $dropbox->create($subfolder,$foldername);	
			
			$myClass->catchErrors( $catch_error );	
		}
		//********* END Subfolder :)  ************************//
		
		
	}
	else
	{
		$var = $dropbox->create($foldername);	
		
		$varSubFolder = $dropbox->create($subfolder,$foldername);
	}

}
catch (Exception $e) {
    $catch_error = 'addToDropbox.php line 75: '. 'Caught exception: '. $e->getMessage(). "\n<br>";
	$var = $dropbox->create($foldername);	
	
	//echo "<br>subfolder:".$subfolder;
	$varSubFolder = $dropbox->create($subfolder,$foldername);
	
	$myClass->catchErrors( $catch_error );	
}

//****************** Upladoed Files *******************************************//

//Get Files
$sql = "SELECT upload_files_filename
		FROM upload_files
		WHERE upload_files_upload_id = '".$last_id."'
		";
$res_f = $myClass->excQuery($sql);

for( $k=0;$k<count($res_f);$k++ )
{
	echo "<br>Filename:".$res_f[$k]['upload_files_filename'];	
	
	$filename = $res_f[$k]['upload_files_filename'];
	
	//include("putFiles_v2.php");
	
	$tmp = tempnam('/tmp', 'dropbox');
	$myFile = "files/".$filename;
	//$myFile = "HydrangeasA.jpg";
	$fh = fopen($myFile, "rb");
	$data = fread($fh, filesize($myFile));
	fclose($fh);
	
	file_put_contents($tmp, $data);
	
	//************* Upload the file with an alternative filename  ********************//
	
	//******** check if file exist  ***************//
	try
	{
		$existsFile = $dropbox->getFile($subfolder."/".$filename); //$subfolder
		$string = $existsFile['mime'];
		if( strlen($string)>0  )
		{
			//file exists	Find othername
			$i = 1;
			$filename = findFileName($dropbox,$filename,$subfolder,$i,$myClass);
			$put = $dropbox->putFile($tmp,$filename,$subfolder); 
		}
		else
		{
			//file doesnt exists	
			$put = $dropbox->putFile($tmp,$filename,$subfolder); //$filename
		}
	}
	catch(Exception $e)
	{
		
		//file doesnt exists	
		$put = $dropbox->putFile($tmp,$filename,$subfolder); //$filename
		
		$catch_error = 'addToDropbox.php line 151: '. 'Caught exception: '. $e->getMessage(). "\n<br>";
		$myClass->catchErrors( $catch_error );	
		
	}
	//******** END check if file exist  ***************//
	
	
	//$put = $dropbox->putFile($tmp,"AB.jpg"); //$filename
	
	
	// Unlink the temporary file
	//unlink($tmp);
	
	// Dump the output
	//var_dump($put);
	
	//************* END Upload the file with an alternative filename  ********************//
}
	
//****************** END Upladoed Files ****************************************//

ini_set("max_execution_time",$maxTime);
?>
