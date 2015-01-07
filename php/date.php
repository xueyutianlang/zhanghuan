<?php
/**
 *
 * @description : php 时间日期函数公共函数
 * @author      : zhanghuan<1163319581@qq.com>
 * @date        : 2015-1-4
 *
 **/

/*
 * @格式化时间字符串的'-'和':'去掉
 * @author : zhanghuan
 * @date   : 2015-1-4
 * @格式化时间字符串的demo,date_replace(),value: 20150104135612
 * @param  : [none]
 * @return : [string] 格式化时间字符串
 */
function date_replace()
{
   return str_replace(array('-',' ',':'),'',date('Y-m-d H:i:s'));
}

/*
 * @格式化时间日期字符串,显示星期
 * @author : zhanghuan
 * @date
 * */
function dates()
{
	$arr = array(
		0=>'星期日',
		1=>'星期一',
        2=>'星期二',
        3=>'星期三',
        4=>'星期四',
        5=>'星期五',
        6=>'星期六',
	);
	if(array_key_exists(date(w),$arr))
	{
		return "今天是".$arr[date(w)];
	}
	else
	{
		return "您好:),今天为您显示火星上的日期 ^_^";
	}
}
?>

?>
