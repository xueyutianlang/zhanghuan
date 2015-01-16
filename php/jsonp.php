<?php
/**
 * description : ajax跨域请求jsonp
 * @author     : zhanghuan<xueyutianlang@163.com>
 * @date       : 2015-01-16  
 *
 **/
header("Content-type:text/html;charset=utf-8");
/*
 * @ajax跨域请求jsonp
 * @author : zhanghuan
 * @date   : 2015-01-16
 * @demo   : jsonData(),value : checkSub({"status":0,"error":"\u8fdd\u6cd5\u8bf7\u6c42"}); 
 *
 * @param  : [string] - $callback - 回调函数名称
 *         : [string] - $str      - 对话数组名称
 * @return : jsonp
 */
function jsonData()
{
	$arr = array(
		 'yaoqiu'=>array(0=>'快点去洗碗,洗快点',1=>'给我一首歌的时间'),
	     'reason'=>array(0=>'老墨迹了你,快点洗',1=>'我这首歌是北京欢迎你7分钟哩'),
   	     'song'=>array(0=>'快点我老困了',1=>'我马上唱完了')
	 );
    if(isset($_GET['callback']))
	{
		switch($_GET['str'])
		{
		     case 'yaoqiu' :
				 echo 	'checkSub(' . json_encode(array('status'=>1,'arr'=>$arr[$_GET['str']])) . ')';
				 break;
			 case 'reason' :
				 echo 	'checkSub(' . json_encode(array('status'=>1,'arr'=>$arr[$_GET['str']])) . ')';
				 break;
			 case 'song'  :
				 echo 	'checkSub(' . json_encode(array('status'=>1,'arr'=>$arr[$_GET['str']])) . ')';
				 break;
			 default :
				 echo   'checkSub(' . json_encode(array('status'=>2,'error'=>'没有相关数据')).')';
				 break;
		}
	}
    else
	{
		echo 'checkSub(' .json_encode(array('status'=>0,'error'=>'违法请求')). ')';
	}	
}
print_R(jsonData());
?>
