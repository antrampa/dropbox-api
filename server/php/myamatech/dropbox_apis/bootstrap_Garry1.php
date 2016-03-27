<?php


/**
 * A bootstrap for the Dropbox SDK usage examples
 * @link https://github.com/BenTheDesigner/Dropbox/tree/master/examples
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
spl_autoload_register( function($class){ 
		$class = str_replace('\\', '/', $class); 
		require_once('/' . $class . '.php'); 
	}
);

// Set your consumer key, secret and callback URL
//$key      = 'xdx96anxt8zttlc';
//$secret   = 'qmcc4nd01e3msbv';

//Garry :: account garry_white@aol.com
/*
Dropbox account:
Login - garry_white@aol.com
Pass - 2010garry 
Application:  AntonisDropBox2012_v2
*/
$key      = '2fdvvhsm2gpeove';
$secret   = 'nimwmtd6ao80wm0';

// Check whether to use HTTPS and set the callback URL
$protocol = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http';
$callback = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Instantiate the required Dropbox objects
$encrypter = new \Dropbox\OAuth\Storage\Encrypter('asdwerty');
$storage = new \Dropbox\OAuth\Storage\Session($encrypter);
$OAuth = new \Dropbox\OAuth\Consumer\Curl($key, $secret, $storage, $callback);
$dropbox = new \Dropbox\API($OAuth);

?>