<?php
// 可以为任意文件
$system = 'smarutil';

// 扩展名
define('EXT', '.php');
/*
 * When developing your application, it is highly recommended to enable notices
 * and strict warnings. Enable them by using: E_ALL | E_STRICT
 *
 * In a production environment, it is safe to ignore notices and strict warnings.
 * Disable them by using: E_ALL ^ E_NOTICE
 *
 * When using a legacy application with PHP >= 5.3, it is recommended to disable
 * deprecated notices. Disable with: E_ALL & ~E_DEPRECATED
 */
error_reporting(E_ALL | E_STRICT);

// Set the full path to the docroot
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

// Make the application relative to the docroot, for symlink'd index.php
if ( ! is_dir($system) AND is_dir(DOCROOT.$system))
	$system = DOCROOT.$system;
	
// Define the absolute paths for configured directories
define('SYSTEMPATH', realpath($system).DIRECTORY_SEPARATOR);

// Bootstrap the application
require SYSTEMPATH.'bootstrap'.EXT;

//////////////////////////////////////////////////////////////////////////////////////////////////////////
////// 你的代码
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function a()
{
 
    echo "test1";
    return;
}
 
function b()
{
    class test {};
    echo "test3";
 
}
 
spl_autoload_register('a');
spl_autoload_register('b');
 
new test();