#!/usr/local/php/bin/php
<?php
define('ROOT','/tmp/daemon/');
//脚本执行时间无限制
set_time_limit(0);

is_dir(ROOT) || mkdir(ROOT,0755,true) && chmod(ROOT,0755); 
$file = ROOT.'index.txt';
$contents =array(
   date('Y-m-d H:i:s',time()),
   '我爱北京天安门',
   'xueyutianlang',
);
while(1)
{
file_put_contents($file,implode('-*-',$contents).PHP_EOL,FILE_APPEND);
sleep(60);
}
?>
