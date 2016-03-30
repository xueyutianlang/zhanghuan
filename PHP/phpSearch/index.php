<?php

/**
 * @非递归二分查找
 * 
 * @原理: 对于需要查找的数组，首先需要定义高低位，和目标值。每次让中间值和目标值比较，若中间值大于目标值，说明目标值在中间值左边，则低位不变，高位= 中间值坐移一位;
          若中间值小于目标值的话说明目标值在中间值的右边，则高位不变，低位= 中间值右移一位，以此循环直到 高位比低位小为止。
 *
 **/

 function twoSearch($arr,$target)
{
    $low  = 0;
    $high = count($arr)-1;
    //若低位小于等于高位
    while($low<=$high)
    {
        $mid = floor(($low+$high)/2);
        if($arr[$mid] > $target)
        {
           $high = $mid-1; 
        }
        else if($arr[$mid] < $target)
        {
           $low =  $mid+1;
        }
        else
        {
            return $target;
        }
    } 
    return -1;
}




