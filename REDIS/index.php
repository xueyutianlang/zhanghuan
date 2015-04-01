<?php 
/**
 * @descrition: redis 测试接口
 * @author    : zhanghuan<xueyutianlang@163.com>
 * @date      : 2015.04.01
 *
 **/
$redis = new Redis();
//链接redis
$redis -> connect('127.0.01',6379,1);
//$redis = new Client($server);
//print_r($redis);die;
//普通set/get操作
$redis->set(1, 2);
$retval = $redis->get(1);
echo $retval; //显示
?>
