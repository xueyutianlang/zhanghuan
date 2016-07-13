<?php
/**
 * descrition : 随机生成规律(首位和第三位是字母)的字符串 例如: a3r6
 * @author    : zhanghuan<xueyutianlang@163.com>
 * @date      : 2015-1-4
 * @demo      : 随机生成规律字符串demo, 例如: randstring(); value: g7a4
 *
 * @param     : [none]
 * @return    : [string] - $string
 * 
 **/
function randstring()
{
	$string = '';
	$num = '';
	$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$strnum = '123456789';
	$length = strlen($string.$strnum)-1;
	for($i = 0; $i<= $length; $i++)
	{
         if($i%2 == 0)
		 {
			 $tmp = $strnum[mt_rand(0,8)];
			 if(!strpos($string,$tmp))
			 {
				 $string .= $tmp; 
			 }
		 }
		 else
		 {
			 $tmpstr = $str[mt_rand(0,51)];
			 if(!strpos($string,$tmpstr))
			 {
				 $string .= $tmpstr;
			 }
		 }
         //$arr = str_split($string);
	     $arr = array_unique(str_split($string));
	     $string = implode('',$arr);
		 if(strlen($string) >= 4 )
		 {
			 break;
		 }
		
	}
	return $string;

}
print_r(randstring());
?>
