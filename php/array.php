<?php
/**
 * description : php 常用数组函数
 * @author     : zhanghuan<xueyutianlang@163.com>
 * @date       : 2015-01-28
 *
 **/
/*
 * @统计数组中元素出现的个数，并将统计数组进行ksort 排序
 *  
 */
function statistical()
{
     $array = array('1','3','1','1','3','5');
     return array_count_values($array);
}

/*
 * @数组指针应用
   ★current():取得目前指针位置的内容资料。
   ★key():读取目前指针所指向资料的索引值（键值）。
   ★next():将数组中的内部指针移动到下一个单元。
   ★prev():将数组的内部指针倒回一位。
   ★end():将数组的内部指针指向最后一个元素。
   ★reset():将目前指针无条件移至第一个索引位置。
 *
 */   
function arrPoint()
{
      $array=array(1,2,3,4,5,6);
      echo key($array).'|'.current($array);
      next($array);
      echo key($array).'|'.current($array);
}

/*
 * @在数组中特定位置插入特定元素
 * @date : 2015-01-28
 */
function insert($arr=array(1,2,3,4,5),$i=3)
{
    $arrOne = array();
    $arrTwo = array();
    foreach($arr as $key=>$value)
    {
	    if($key<$i)
		{
			array_push($arrOne,$value);
		}
		else
		{
			array_push($arrTwo,$value);
		}
	}
	return array_merge($arrOne,$arrTwo);
}

?>
