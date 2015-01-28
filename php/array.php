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
?>
