<?php
/**
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




