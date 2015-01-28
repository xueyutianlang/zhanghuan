<?php
/**
 * description : php 常用数值处理函数
 * @author     : zhanghuan<xueyutianlang@163.com>
 * @date       : 2015-01-28
 *
 **/

/*
 * php定义：函数把格式化的字符串写写入一个变量中。
 *     可识别的格式
 *         %% - 返回百分比符号
 *         %b - 二进制数
 *         %c - 依照 ASCII 值的字符
 *         %d - 带符号十进制数
 *         %e - 科学计数法（比如 1.5e+3）
 *         %u - 无符号十进制数
 *         %f - 浮点数
 *         %F - 浮点数
 *         %o - 八进制数
 *         %s - 字符串
 *         %x - 十六进制数（小写字母）
 *         %X - 十六进制数（大写字母）
 *  sprintf在金额方面应用
 *
 */
function money()
{
	$money=123;
    return sprintf('%0.2f',$money);	
}
?>
