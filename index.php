<?php
// 可以为任意目录
$application = 'app';

// smarutil系统目录
$system = 'smarutil';

// 扩展名
define('EXT', '.php');
/*
 * 开发环境，希望有完整错误提示和严格检查，请使用: E_ALL | E_STRICT
 *
 * 产品环境，忽略提示级别错误，请使用: E_ALL ^ E_NOTICE
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
	
if ( ! is_dir($application) AND is_dir(DOCROOT.$application))
	$application = DOCROOT.$application;
	
// Define the absolute paths for configured directories
define('APPPATH', realpath($application).DIRECTORY_SEPARATOR);
define('SYSPATH', realpath($system).DIRECTORY_SEPARATOR);

// Clean up the configuration vars, because of global var
unset($application, $system);

// Bootstrap the application
require APPPATH.'bootstrap'.EXT;

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