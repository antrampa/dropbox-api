<?php
/* Please supply your own consumer key and consumer secret */

//$consumerKey = 'ki54sltq39vf11k';
//$consumerSecret = 'jipowugd4oenfwx';


/*
Application was created in Dropbox.com:
App name - Testupup	
App status - Development
App key	- vwwoh2n631ll2du
App secret	- qv195gn4biwy153
Access type	- Full Dropbox

Dropbox account:
Login - garry_white@aol.com
Pass - 2010garry

Dropbox app address - https://www.dropbox.com/developers/apps
*/
$consumerKey = 'vwwoh2n631ll2du';
$consumerSecret = 'qv195gn4biwy153';


/*
//my
include 'Dropbox/Exception.php';
include 'Dropbox/OAuth.php';
include 'Dropbox/API.php';
include 'Dropbox/OAuth/PHP.php';
*/




include 'Dropbox/autoload.php';


session_start();
$oauth = new Dropbox_OAuth_PHP($consumerKey, $consumerSecret);

// If the PHP OAuth extension is not available, you can try
// PEAR's HTTP_OAUTH instead.
// $oauth = new Dropbox_OAuth_PEAR($consumerKey,$consumerSecret);

$dropbox = new Dropbox_API($oauth);


?>