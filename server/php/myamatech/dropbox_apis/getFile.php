<?php

/**
 * Upload a file to the authenticated user's Dropbox
 * @link https://www.dropbox.com/developers/reference/api#files-POST
 * @link https://github.com/BenTheDesigner/Dropbox/blob/master/Dropbox/API.php#L80-110
 */

// Require the bootstrap
//init
require_once('bootstrap.php');


// Upload the file with an alternative filename
$put = $dropbox->getFile("myamatech/Option3_12-03-17_09/DesertAAA.jpg");
echo "string:".$put['mime'];//['string'];

// Dump the output
//var_dump($put);

?>