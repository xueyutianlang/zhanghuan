<?php 
/**
 * description : php string 函数常用功能总结
 * @author     : zhanghuan<xueyutianlang@163.com>
 * @date       : 2015-01-12
 *
 **/

/*
 * @php string 常用比较函数
 * @author : zhanghuan
 * @date   : 2015-01-12
 * @demo   : stringDiff(abc,abc) ,value : 1
 * 
 * @param  : [string] - $str1   - 字符串1
 *         : [string] - $str2   - 字符串2
 *         : [int]    - $length - 规定比较的长度
 *         : [string] - $mod    - 选择使用的函数 对应函数名使用对应函数,例如: strcmp,strcmp();
 * @return : [bool]   - bool    - str1小于str2返回 < 0；如果str1大于str2 返回 > 0;如果两者相等，返回 0 
 */
function stringDiff($str1,$str2,$length=0,$mod='strcmp')
{
	switch ($mod)
	{
		case 'strcmp' :
		     /*二进制安全字符串比较(区分大小写)*/
			 return strcmp($str1,$str2);
			 break;
		case 'strcasecmp' :
			 /*二进制安全字符串比较(不区分大小写)*/
			 return strcasecmp($str1,$str2);
			 break;
		case 'strncmp' :
			 /*二进制安全字符串比较可控制比较长度(区分大小写)*/
			 return strncmp($str1,$str2,$length);
             break;
		case 'strncasecmp':
			 /*二进制安全字符串比较可控制比较长度(不区分大小写)*/
			 return strncasecmp($str1,$str2,$length);
			 break;
		default :
			 return '请输入合法的参数';
			 break;
	}
}

/*
 * @php 舍弃字符串最后一个字符
 * @date   : 2015-01-23
 *
 * @param  : [array] - $arr - 数组
 * @return : [string] - $string - 字符串 
 */
function substring($arr)
{	
	$string = '';
	foreach($arr as $value)
	{
        $string .=$value.',';
	}
	return substr($string,0,-1);
}

?>


