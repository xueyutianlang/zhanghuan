<?php
require_once('/root/zhanghuan/phpMailer/class.smtp.php');
require_once('/root/zhanghuan/phpMailer/class.phpmailer.php');

$path = '/tmp/Mail/';
$csvArr = array('c1.csv','c2.csv');

$mail = new PHPMailer(); //实例化
$mail->IsSMTP(); // 启用SMTP
$mail->Host = "smtp.163.com"; //SMTP服务器 以163邮箱为例子
$mail->Port = 25;  //邮件发送端口
$mail->SMTPAuth   = true;  //启用SMTP认证
$mail->CharSet  = "UTF-8"; //字符集
$mail->Encoding = "base64"; //编码方式
$mail->Username = "xueyutianlang@163.com";  //你的邮箱
$mail->Password = "asdfasdfasdf";  //你的密码
$mail->Subject = "周报数据"; //邮件标题
$mail->From = "xueyutianlang@163.com";  //发件人地址（也就是你的邮箱）
$mail->FromName = "雪域天狼";  //发件人姓名
$address = "xxxxxx@qq.com";//收件人email
$mail->AddAddress($address);//添加收件人（地址，昵称）
$mail->IsHTML(true); //支持html格式内容
$body = "<p>hi all：</p><p>&nbsp; &nbsp; &nbsp; 请验收。</p><p><br></p>";
$mail->AddAttachment($path.$csvArr[0]);
$mail->AddAttachment($path.$csvArr[1]);
$mail->Body = $body; //邮件主体内容
//发送
if(!$mail->Send()) {
    echo "发送失败: " . $mail->ErrorInfo;die;
}

