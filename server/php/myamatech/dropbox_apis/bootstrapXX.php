<?php

/**
 * A bootstrap for the Dropbox SDK usage examples
 * @link https://github.com/BenTheDesigner/Dropbox/tree/master/examples
 */
 
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

$consumerKey = 'vwwoh2n631ll2du';
$consumerSecret = 'qv195gn4biwy153';
*/


// Prevent access via command line interface
if (PHP_SAPI === 'cli') {
	exit('bootstrap.php must not be run via the command line interface');
}

// Don't allow direct access to the boostrap
if(basename($_SERVER['REQUEST_URI']) == 'bootstrap.php'){
	exit('bootstrap.php does nothing on its own. Please see the examples provided');
}

// Set error reporting
error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('html_errors', 'On');

// Register a simple autoload function
spl_autoload_register(function($class){
	$class = str_replace('\\', '/', $class);
	require_once('' . $class . '.php');
});



//Garry App folder	AntonisDropbox2
//$key      = 'katmc2qj9gprixl';
//$secret   = 't2orzegzwpneub9';

//Garry AntonisTestApps 2mail
//$key      = '7f0gb6kcklp8kww';
//$secret   = '590b3lfk6t0u3vx';


// Set your consumer key, secret and callback URL
//testapp2012ampa
$key      = 'ki54sltq39vf11k'; //=> auto diko mou
$secret   = 'jipowugd4oenfwx';  //=> auto diko mou



// Check whether to use HTTPS and set the callback URL
$protocol = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http';
$callback = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Instantiate the required Dropbox objects
$encrypter = new \Dropbox\OAuth\Storage\Encrypter('jipowugd4oenfwx');
$storage = new \Dropbox\OAuth\Storage\Session($encrypter);
$OAuth = new \Dropbox\OAuth\Consumer\Curl($key, $secret, $storage, $callback);
$dropbox = new \Dropbox\API($OAuth);

?>