<?php 
/**
 * @description: php 文件操作函数
 * @author     : zhanghuan <xueyutianlang@163.com>
 * @date       : 2015-06-10
 **/

/*将数组元素压入文件中
function fileArray()
{
    $content = array();
    $string = '1,你猜,2,我想';
    $content = explode(',',$string);
    $fp = fopen('./a.log', 'a+b');
    fwrite($fp,print_r($content,true));
    fclose($fp);
}
?>
