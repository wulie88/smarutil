<?php
require 'smarutil.php';

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
 
#new test();