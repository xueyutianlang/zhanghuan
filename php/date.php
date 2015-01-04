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
?>
