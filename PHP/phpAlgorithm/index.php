<?php
/**
 * @ php 几种常见的算法排序
 * @ author : xueyutianlang <xueyutianlang@163.com>
 * @ date   : 2016-03-28
 * @ version: 1.0.0
 **/

/*
 * @ 冒小泡排序
 *
 * @ 冒小泡原理 : 数组的排序像冒泡一样,数组的元素如同一串从底到顶由小变大的泡(冒小泡需要底下的小泡浮到顶部把大泡给压下去)，从底部的第一个元素开始触发冒泡，并与相邻的泡两两比较，
            大的泡挤到下面，小的泡上浮，最终冒出。依次类推
   @ 想象图:   key     value
                0      0(5)   0(1)   0(1)  0(1) 0(1)  
                1      0(4)   0(5)   0(2)  0(2) 0(2) 
                2      0(3)   0(4)   0(5)  0(3) 0(3)
                3      0(2)   0(3)   0(4)  0(4) 0(4)
 *              4      0(1)   0(2)   0(3)  0(5) 0(5)
 * @NOTICE : 上图中 0代表泡，非时间复杂度
 * @ 公式 :  冒泡排序 = 外层(n-1次) +内层循环
 * 
 **/
function smallBubblesort()
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

/**
 * @冒大泡排序
 * 
 * @冒大泡原理: 数据的排序像冒大泡一样，数据的键值如同一串从顶到底由小变大的泡(冒大泡需要顶上的小泡逐个到此串泡的最下面，慢慢把大泡顶起),从顶部最小的泡开始触发冒泡，冒泡过程中并与相邻的泡两两比较,大泡被顶起，最终冒出,依此类推。
 *
 *  @ 想象图:   key     value
                0      0(1)   0(2)   0(3)  0(4)  0(5) 
                1      0(2)   0(3)   0(4)  0(5)  0(4)
                2      0(3)   0(4)   0(5)  0(1)  0(3)
                3      0(4)   0(5)   0(1)  0(2)  0(2)
 *              4      0(5)   0(1)   0(2)  0(3)  0(1)
 * @NOTICE : 上图中 0代表泡，非时间复杂度
 * @ 公式 :  冒泡排序 = 外层(n-1次) +内层循环
 * 
 **/
function bigBubblesort()
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




