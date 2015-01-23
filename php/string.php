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

/*
 * @php 安全比较二进制字符串
 * @date  : 2015-01-23
 *
 * @param : [string] - $str1 　- 字符串 1 
 *        : [string] - $str2 　- 字符串 2
 *        : [int]    - $offset - 偏移量，默认１
 *        : [int]    - $length - 长度，默认１
 * @return: [int]    - $int  　- 如果 str1 从偏移位置 offset 起的子字符串小于 str2，则返回小于 0 的数；如果大于 str2，则返回大于 0 的数；如果二者相等，则返回 0。如果 offset 大于等于 str1 的长度或 length 被设置为小于 1 的值 
 *
 */
function stringCompare($str1,$str2,$offset=1,$length=1)
{
	echo substr_compare($str1,$str2,$offset,$length);
}
?>


