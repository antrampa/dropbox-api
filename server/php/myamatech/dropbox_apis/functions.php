<?php

function findFolderName_v2($dropbox,$foldername,$i,$myClass)
{
	$foldernameFinal = $foldername."(".$i.")";
	
	try
	{
			$info = $dropbox->metaData($foldernameFinal);
			//print_r($info);
			
			$jsonData = $info['body'];
			
			/*
			echo "<br>JSON<BR>";
			echo $jsonData->is_dir;
			echo "<br>revision<br>";
			echo "<br>revision<br>";
			echo $jsonData->revision;
			echo "<br>";
			*/
			
			//folder exists
			if( $jsonData->is_dir == 1 )
			{
				$i++;
				return findFolderName_v2($dropbox,$foldername,$i,$myClass);
			}
			else
			{
				return $foldernameFinal;
			}
	}
	catch (Exception $e) {
		
		$catch_error = 'functions.php Line 59:'.'Caught exception: '. $e->getMessage(). "\n<br>";
		$myClass->catchErrors( $catch_error );	
		//$var = $dropbox->create($foldername);	
		
		return $foldernameFinal;
	}
	return $foldernameFinal;
	
	
}


function findFileName($dropbox,$filename,$subfolder,$i,$myClass)
{
	
	//Finf extension
	//$ext = end(explode('.', $filename));
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	
	$arr = explode('.', $filename);
	$filenameWithoutExt = $arr[0];
	//$filenameWithoutExt = basename($filename, ".".$ext."").PHP_EOL;
	$filenameFinal = $filenameWithoutExt."(".$i.").".$ext;
	
	
	//$filenameFinal = $i."_".$filename;
	
	try
	{
			$put = $dropbox->getFile($subfolder."/".$filenameFinal); //,$subfolder
			//echo "<br>AAA:".$put['mime'];
			$string = $put['mime'];
			if( strlen($string)>0 )
			{
				$i++;
				return findFileName($dropbox,$filename,$subfolder,$i,$myClass);
			}
			else
			{
				return $filenameFinal;
			}
	}
	catch (Exception $e) {
		
		//$catch_error = 'functions.php Line 88:'.'Caught exception: '. $e->getMessage(). "\n<br>";
		//$myClass->catchErrors( $catch_error );	
		//$var = $dropbox->create($foldername);	
		
		return $filenameFinal;
	}
	return $filenameFinal;
	
	
}



?>