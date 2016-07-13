<?php
/**
 * @快速排序
 *
 * @原理:一组无序的数组,每趟都要把数组的值大小分别放在不同的数组中，这个过程是递归的，每趟开始之前必须要有一个标准 默认是每次的首个元素
 */
$array = array(49,38,65 ,97 ,76 ,13 ,27 ,49);

function quick_sort($array)
{
    //递归停止的标尺,即传的数组仅有一个元素时，否则变成死循环
    if(count($array) <=1) return $array;
    //找到标准
    $biaozhun = $array[0];
    //声明大小数组
    $bigArr = array();
    $smallArr = array();
    //循环开始,因为0做了标准，所以从1开始
    for($i=1;$i<count($array);$i++)
    {
        if($array[$i] > $biaozhun)
        {
            $bigArr[] = $array[$i];
        }
        else
        {
            $smallArr[] = $array[$i];
        } 
    }
    $bigArr = quick_sort($bigArr);
    $smallArr = quick_sort($smallArr);      
    return    array_merge($bigArr,array($biaozhun),$smallArr);   
}

