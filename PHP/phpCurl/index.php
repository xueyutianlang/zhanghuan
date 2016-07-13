<?php
/**
 * @descrition: curl 进行post提交
 * @maker     : web
 * @author    : zhanghuan<xueyutianlang@163.com>
 * @date      : 2015-05-28
 **/

function comcurl($url,$data) 
{
    $curlObj = curl_init();
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => TRUE, //使用post提交
        CURLOPT_RETURNTRANSFER => TRUE, //接收服务端范围的html代码而不是直接浏览器输出
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($data), //post的数据
    );
    curl_setopt_array($curlObj, $options);
    $response = curl_exec($curlObj);
    curl_close($curlObj);
        return $response;
}

