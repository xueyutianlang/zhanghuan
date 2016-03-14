<?php
/**
 * @ php 几种常见的算法排序
 **/

function bigsort()
{
		for($i = 0;$i<count($arr)-1;$i++)
		{
				for($j=count($arr)-1;$j>$i;$j--)
				{
						if($arr[$j] > $arr[$j-1])
						{
								$tmp = $arr[$j];
								$arr[$j] = $arr[$j-1];
								$arr[$j-1] = $tmp;
						}
				}
		}
}

function smallsort()
{
		for($i = 1;$i<count($arr);$i++)
		{
				for($j=0; $j< count($arr)-$i;$j++)
				{
						if($arr[$j] > $arr[$j+1])
						{
								$tmp = $arr[$j];
								$arr[$j] = $arr[$j+1];
								$arr[$j+1] = $tmp;
						}
				}
		}
}

/*
 * @快速排序
 *
 * @原理:一组无序的数组,每趟都要把数组的值大小分别放在不同的数组中，这个过程是递归的，每趟开始之前必须要有一个标准 默认是每次的首个元素
 */
$array = array(49,38,65 ,97 ,76 ,13 ,27 ,49);

function quick_sort($array)
{
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

/*
 * @选择排序
 * 
 * @原理:一组无序的数组，每一趟选出一个最大或者最小的，按顺序放在已经排好的后面
 *
 */

/*function select_sort($arr)
{
    for($i=0;$i<count($arr);$i++)
    {
        $k = $i;
        for($j=$i+1;$j<count($arr);$j++)
        {
            if($arr[$k] >$arr[$j])
            {
                $k = $j;
            }
            if($k !=$i)
            {
                $tmp = $arr[$i];
                $arr[$i] = $arr[$k];
                $arr[$k] = $tmp;
            }
        }     
    }
    return $arr;   
   
}*/

function select_sort($arr){     
    $count = count($arr);     
    for($i=0; $i<$count; $i++){     
        $k = $i;     
        for($j=$i+1; $j<$count; $j++){     
            if ($arr[$k] > $arr[$j])     
                $k = $j;     
            if ($k != $i){     
                $tmp = $arr[$i];     
                $arr[$i] = $arr[$k];     
                $arr[$k] = $tmp;     
             }     
         }     
     }     
    return $arr;     
}    


$arr = array(49 ,38 ,65, 97, 76, 13, 27, 49);
var_dump(select_sort($arr));




