<?php 
/**
 * @description : php 变量作用域名测试
 * @author      : zhanghuan <xueyutianlang@163.com> 
 * @date        : 2015-07-29
 **/

// php 变量类型 ： 普通标量，特殊变量 ，常量，全局变量（global + 普通标量），超级全局变量(预定义变量)

//test 1 常量 
// 常量作用域：整个脚本，任何地方
define('APP','xueyutianlang');

//定义测试函数
function test($test)
{
    echo 'Function'.$test;
}
test(APP);
echo 'SECEND'.APP;

//test2 超级全局变量，适用于脚本任何地方。

//test2 全局变量
// 全局变量作用: 函数外声明，除函数内，其他可见；函数内声明，脚本全局均可见。
$str = 'hellow';
global $str;
function scopetest()
{
    echo $str;
    $a= 'hhhhh';
}
scopetest();
echo $a;



