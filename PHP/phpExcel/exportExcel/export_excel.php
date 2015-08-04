<?php 
/*
 * description : php导出excel
 * @author     : zhanghuan<xueyutianlang@163.com>
 * @date       : 2015-01-16
 * 
 * @notice     : 你需要链接你本地的数据库来完成数据读取调用
 */
header('Content-Type:application/vnd.ms-excel');
//excel 文件名
header("Content-Disposition:attachment;filename=".urlencode('雪域天狼导出excel').".xls");
header('Content-type: text/html; charset=utf-8');
//输出内容如下：
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />    
		<title>雪域天狼导出excel</title>
		<style>
			td{text-align:center;font-size:12px;font-family:Arial, Helvetica, sans-serif;border:#1C7A80 1px solid;color:#152122;width:100px;}
			table,tr{border-style:none;}
			.title{background:#7DDCF0;color:#FFFFFF;font-weight:bold;}
		</style>	
		</head>
		<body>
				<table width='1200'>
					<tr>
					    <td>序号</td>
					    <td>姓名</td>
						<td>性别</td>
						<td>爱好</td>
					</tr>  
					";
/*链接mysql*/
$mysql_ip = 'localhost';
$mysql_user = 'xueyutianlang';
$mysql_password = '123456';
$con = mysql_connect($mysql_ip,$mysql_user,$mysql_password) or die('数据库连接失败');
mysql_select_db('db_xueyu', $con);
mysql_query('set names utf8');
/*取扣费表数据*/
$sql = 'SELECT user_name,sex,hobby FROM xueyu_admin order by id desc';
$query = mysql_query($sql);
unset($sql);
$array = array();
$sqlMerchant = '';
$merchantPact = array();
while($res = mysql_fetch_assoc($query))
{
	$array[] = $res;
}
unset($query);
/*遍历获取的数据*/
$i=1;
foreach($array as $k=>$v)
{
        echo ' <tr>
			<td>'.$i.'</td>
			<td>'.$v["merchant_resource"].'</td>
            <td>'.$v["con_id"].'</td>
            <td>&nbsp;'.$v["deduct_add_time"].'&nbsp;</td>
        </tr>  ';
        $i++;
}
echo ' </table></div></body></html> ';
?>

