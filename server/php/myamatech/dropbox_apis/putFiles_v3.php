<?php

/**
 * Upload a file to the authenticated user's Dropbox
 * @link https://www.dropbox.com/developers/reference/api#files-POST
 * @link https://github.com/BenTheDesigner/Dropbox/blob/master/Dropbox/API.php#L80-110
 */

// Require the bootstrap
//init
require_once('bootstrap.php');

// Create a temporary file and write some data to it
$tmp = tempnam('/tmp', 'dropbox');

//$data = 'This file was uploaded using the Dropbox API!AMPA';

$myFile = "../../files/"."Hydrangeas.jpg";//"../../files/".$filename;
$fh = fopen($myFile, "rb");
//$fh = fopen("../../files/admin_v0", 'r');
$data = fread($fh, filesize($myFile));
fclose($fh);

file_put_contents($tmp, $data);

// Upload the file with an alternative filename
$put = $dropbox->putFile($tmp, 'HydrangeasAB.jpg','myamatech(13)');

// Unlink the temporary file
unlink($tmp);

// Dump the output
var_dump($put);

?>