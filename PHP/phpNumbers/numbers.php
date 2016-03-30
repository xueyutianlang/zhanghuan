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

/**
 * @ 获取质数
 *  @ param :int - $startNum 
 *  @ param :int - $endNum 
 * return : array
 */

function getNumber($startNum,$endNum)
{
    $data = array();
    if((int)$startNum > $endNum) 
    {
        return errorMsg(1,__LINE__);
    }
    $data['zhishu'] = array();
    $data['shaoyu'] = array();
    $data['duoyu']  = array();
	for($i=$startNum;$i<=$endNum;$i++)
	{
		$num = 0;   
		for($j=1;$j<=$i;$j++)
		{
			if(($i%$j) ===0) $num++;
		}
		if($num == 2)
		{
			array_push($data['zhishu'],$i);
		}
		else if($num < 2)
		{
			array_push($data['shaoyu'],$i);
		}
		else if($num > 2)
		{
			array_push($data['duoyu'],$i);   
		}
		else
		{
            return errorMsg('',__LINE__);
		}
	}
    return $data;
}

/**
  *@定义错误方法
  *@param - int - $type 默认值 1
  *@param - int - $line 
  *
  *return msg
  */

function errorMsg($type = 1,$line)
{
    switch($type)
    {
        case 1:
           $error = '参数错误';
           break;	
        default:
           $error = 'undefine error';
           break;
    }
    return 'Error Notice : in '.__FILE__.' '.$error.' in line: '.$line;
}

$res= getNumber(0,10);
var_dump($res);

?>
