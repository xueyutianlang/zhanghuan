<?php
    //获取订单
    $order = $_POST['order_id'];
    include_once("wechatpay.php");
    $wechat = new wechatpay(); 
    $result = $wechat->get_code($order);
    switch(intval($result['status']))
    {
        case 1:
            //正常处理订单返回信息，并返回3个连接
            $str = $result['data']['prepay_id'];
            $data = array(
                'code_img_url'=>'https://wx.tenpay.com/cgi-bin/mmpayweb-bin/getpayqrcode?sign='.$str,
                'code_url'=>'https://login.weixin.qq.com/jspay?appid=wxc4095bf1ef081c5f&req_key='.$str,
                //'code_status'=>'https://login.weixin.qq.com/cgi-bin/mmwebwx-bin/login?sign=63d4967c637acc1629155ea743b16a8b'
                'code_status'=>'https://login.weixin.qq.com/cgi-bin/mmwebwx-bin/login?sign=1247162801150618964b07152d234b70'
            );
            echo json_encode($data);die;
      case 2:
          //预支付错误
          echo json_encode($result['error']);die;
      default:
          //调佣微信接口错误
          echo json_encode($result['error']);die;
    } 
?>

