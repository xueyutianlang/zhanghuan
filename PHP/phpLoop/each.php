<?php
/**
 * @description: php each 循环
 * 
 * @author : snow wolf <xueyutianlang@163.com>
 *
 * @date   : 2016-07-19
 */

/* each 作用是返回当前数组的键值对，并将当前数组的指针向下移动一步,若内部指针越过了数组的末端返回false */

$array = range(1,2);

while($list = each($array))
{
    var_dump($list);
    sleep(1);
}

//因数组指针到达末端，返回false 所以未执行 第二次循环
while($list = each($array))
{
    var_dump($list);
    sleep(1);
}


echo '\n指针是否越过数组末端: ';
var_dump(each($array));

//因数组指针已到达末端,返回false 以下验证，数组赋值是否会重置原来的数组指针
$test = $array;

while($list = each($array))
{
    var_dump($list);
    sleep(1);
}
echo '\n 数组赋值测试指针是否越过数组末端: ';
var_dump(each($array));

/*全局化 array 数组,无形参，无传值,测试是否重置指针*/
function doEach()
{
    global $array;
    while($list = each($array))
    {
        var_dump($list);
        sleep(1);
    }

}

doEach($array);
doEach($array);

echo '\n 函数调用测试指针是否越过数组末端: ';
var_dump(each($array));

/*直接检测 函数方式，是否越过数组末端 */

function funEach($arr)
{
    while($list = each($arr))
    {
        var_dump($list);
        sleep(1);
    }
}

funEach($array);
funEach($array);

echo '\n 函数直接调用测试指针是否越过数组末端: ';
var_dump(each($array));



