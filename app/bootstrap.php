<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Core class
require SYSPATH.'classes'.DIRECTORY_SEPARATOR.'core'.EXT;

date_default_timezone_set('Asia/Shanghai');

// Enable the auto-loader.
spl_autoload_register(array('Core', 'auto_load'));

// Enable the auto-loader for unserialization.
ini_set('unserialize_callback_func', 'spl_autoload_call');

if (isset($_SERVER['SMARUTIL_ENV']))
{
	Core::$environment = constant('Core::'.strtoupper($_SERVER['SMARUTIL_ENV']));
}


/**
 * Set the production status by the ip address.
 */
define('IN_PRODUCTION', FALSE);

if(IN_PRODUCTION){
	Core::init(array(
		'base_url'  => "http://{$_SERVER['SERVER_NAME']}/",
		'index_file'=> '',
		'charset'   => 'UTF-8',
		'errors'    => false
	));
} else {
	Core::init(array(
		'base_url'  => "http://{$_SERVER['SERVER_NAME']}/",
		'index_file'=> '',
		'charset'   => 'UTF-8',
		'errors'    => TRUE
	));
}