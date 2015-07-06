<?php
/**
 * Native（原生）支付-模式二-demo
 * ====================================================
 * 商户生成订单，先调用统一支付接口获取到code_url，
 * 此URL直接生成二维码，用户扫码后调起支付。
 * 
*/
class wechatpay
{
    function __construct()
    {
    
        include_once("WxPayPubHelper/WxPayPubHelper.php");
    }   

    function get_code($order)
    {
        
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub();

        //sign已填,商户无需重复填写
        $unifiedOrder->setParameter("body","张欢贡献一分钱");//商品描述
        //自定义订单号，此处仅作举例
        //$timeStamp = strtotime('2015-06-12 13:59:03');
        //$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
        $out_trade_no = $order;
        //$this->order_id = $out_trade_no; 
        $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
        $unifiedOrder->setParameter("total_fee","1");//总金额
        $unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
        $unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
        //获取统一支付接口结果
        $unifiedOrderResult = $unifiedOrder->getResult();
        //商户根据实际情况设置相应的处理流程
        if ($unifiedOrderResult["return_code"] == "FAIL") 
        {
            return array('status'=>0,'error'=>'通信 error');
            //商户自行增加处理流程
            //echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
        }
        elseif($unifiedOrderResult["result_code"] == "FAIL")
        {
            return array('status'=>2,'error'=>'预支付出错');
            //商户自行增加处理流程
            //echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
            //echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
        }
        elseif($unifiedOrderResult["code_url"] != NULL)
        {
            //从统一支付接口获取到code_url
            $code_url  = $unifiedOrderResult["code_url"];
            $prepay_id = $unifiedOrderResult['prepay_id'];
            $array = array(
                'code_url'=>$code_url,
                'prepay_id'=>$prepay_id
            );
            return array('status'=>1,'data'=>$array);
            //$this->codeurl = $code_url;
            
            //商户自行增加处理流程
            //......
        }
        //$this->disCode(); 
    }

    function disCode()
    {
    
    
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>微信安全支付</title>
</head>
<body>
    <div align="center" id="qrcode">
    </div>
    <div align="center">
        <p>订单号：<?php echo $this->order_id; ?></p>
    </div>
    <div align="center">
        <form  action="wechat/order_query.php" method="post">
            <input name="out_trade_no" type='hidden' value="<?php echo $this->order_id; ?>">
            <button type="submit" >查询订单状态</button>
        </form>
    </div>
    <br>
    <div align="center">
        <form  action="./refund.php" method="post">
            <input name="out_trade_no" type='hidden' value="<?php echo $this->order_id; ?>">
            <input name="refund_fee" type='hidden' value="1">
            <button type="submit" >申请退款</button>
        </form>
    </div>
    <br>
</body>
    <script src="WxPayPubHelper/qrcode.js"></script>
        <script>
        if(<?php echo $this->codeurl != NULL; ?>)
        {
            var url = "<?php echo $this->codeurl;?>";
            //参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
            var qr = qrcode(10, 'M');
            qr.addData(url);
            qr.make();
            var wording=document.createElement('p');
            wording.innerHTML = "扫我，扫我";
            var code=document.createElement('DIV');
            code.innerHTML = qr.createImgTag();
            var element=document.getElementById("qrcode");
            element.appendChild(wording);
            element.appendChild(code);
        }
        </script>
</html>

<?php 

    }
}

