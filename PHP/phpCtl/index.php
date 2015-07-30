<?php
/**
 * @description: php 流程控制语句.流程控制语句顾名思义就是可以控制程序执行顺序或者状态的语言结构
 * @author     : zhanghuan <xueyutianlang@163.com>
 * @date       : 2015-07-30
 **/

//条件控制语句 ： if else if  switch
//循环控制语句 ： for ； do while ； while ；foreach
//转移控制语句 ： return continue break

// test1 : 制语句代替条件控制语句,不大简洁但可实现
// 条件控制语句的关键： 条件为 true 或 false 循环控制语句也需要判断条件,只需要模拟出不同结构的方法体而已。

//demo 1 测试 变量比较 相等符号
$i = 20;
if($i == 20)               
{                          
    echo 'if ok'; 
}
else
{
    echo 'if faild';
}

while($i == 20)
{
    echo 'while ok';
    break;
};
while($i!=20)
{
    echo 'while fail ok';
    break;
}

//demo 2 测试 变量比较 大于（小于类推）符号
$i = 20;
if($i > 20)
{
    echo 'yes'; 
}
else
{
    echo 'no';
}

while($i > 20)
{
    echo 'yes';
    break;
}
while($i <= 20)
{
    echo 'no';
    break;
}

// test2 : for 循环的变形
//
for($i==20;$i>=0;)
{
    echo 1;
    $i++;
}

// test3 : while 与do while 循环的区别
//
//
//
// test4 : 若逻辑过于复杂使用 swtich 性能比 if 好很多 
