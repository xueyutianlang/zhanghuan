<?php 
/**
 * descript :  php md5函数日常用法总结
 * @data    :  2015-01-12
 * @author  :  zhanghuan<xueyutianlang@163.com>
 * 
 **/

/*
 * @md5加密技术
 * @demo   : 
 *
 * @param  : [int] - $num - 数值
 * @return : [string] - $string - 32位加密后的字符串
 */
function numbers($num)
{
	$string = preg_match('/^\w{32}$/', $num) ? $num : md5($num);
	return $string;
}
?>
