<?php
/**
 * description : 创建目录公共函数
 * @author     : zhanghuan<xueyutianlang@163.com>
 * @date       : 2015-1-4
 *
 **/

/*
 * @一级目录创建/多级目录创建
 * @date   : 2015-01-04
 * @demo   : createPath();value : /a/b/c
 *
 * @param  : [string] - $dir       - 创建的目录
 * @param  : [int]    - $mode      - 设置权限数值
 * @param  : [bool]   - $recursive - 创建的目录
 * @return : [bool] true/false
 */
function createPath($dir,$mode,$recursive=false)
{
	if(is_dir($dir) || @mkdir($dir,$mode,$recursive)) return true;
}

/*
 * @多级递归创建目录
 * @author : web 
 * @date   : 2015-01-05
 * @demo   : mkdirs();value : a/b/c
 *
 * @param  : [string] - $dir  - 创建的目录
 * @param  : [int]    - $mode - 设置权限数值
 * @return : [bool]   - true/false
 */
function mkdirs($dir,$mode=0777){
	if(is_dir($dir)||@mkdir($dir,$mode)){
		return true;
	}
	if(!mkdirs(dirname($dir),$mode)){
		return false;
	}
	return @mkdir($dir,$mode);
}
?>
