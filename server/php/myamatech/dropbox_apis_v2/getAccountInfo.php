<?php
include("testConnectToDropbox.php");
//include("APITest.php");

//$consumerKey = 'vwwoh2n631ll2du';
//$consumerSecret = 'qv195gn4biwy153';

/*
App name	
App status	Development (Apply for production status)
App key	7g48p3wj0656mhw
App secret	37h90m6g7fmb50w
Access type	Full Dropbox
*/
$consumerKey = '7g48p3wj0656mhw';
$consumerSecret = '37h90m6g7fmb50w';

$oauthN = new Dropbox_OAuth_PHP($consumerKey, $consumerSecret);

// If the PHP OAuth extension is not available, you can try
// PEAR's HTTP_OAUTH instead.
// $oauth = new Dropbox_OAuth_PEAR($consumerKey,$consumerSecret);

$dropboxN = new Dropbox_API($oauth);

echo "<h1>getAccountInfo</h1>";
print_r( $dropboxN->getAccountInfo() );
?>