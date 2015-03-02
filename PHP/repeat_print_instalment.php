<?php
/**
* description: 重复打印-处理全款重复打印/部分(尾款)重复打印程序
* author: zhanghuan
* date: 2014-12-18
*/
include('./config/config.php');
/*接收参数合同号*/
$contractNumber = isset($_GET['contract']) ? $_GET['contract'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : ''; 
/*根据合同号查询该笔合同是否是全额付款*/
$Info = $rest_client->get('repeatPrintReceipt/startInit/',array('contractNumber'=>$contractNumber,'is_full_payment'=>0));
//print_R(); 
if(!isset($Info->status))
{
	/*若真实订单表中全额付款状态为1 代表全额付款*/
	//print_R($Info->orderReal->or_full_payment);die;  
	switch (intval($Info->orderReal->or_full_payment))
	{
	    case 1:
			if(($Info->proConsumeInfo->consume_cope_value < 0) && ($Info->proConsumeInfo->consume_fact_value < 0))
			{
				echo '该合同已退款,请在重复打印退款小票处打印';die;
			}
			echo "<script> window.location.href='print_receipt.php?id=".$Info->proConsumeInfo->consume_id."&type=1'</script>";
		    break;
	    default:
			/*调用数据接口*/
			if($action  == 'post' )
			{
				$id= $_POST['printRadio'] ? intval($_POST['printRadio']) : 0;
			    if(empty($id))
				{
                     echo '消费合同记录表主键丢失';die; 
				}
			    echo "<script> window.location.href='water_small_ticket.php?id=".$id."&type=1'</script>";	
			}else
			{
				$result['contractNumber'] = $contractNumber;
			     $InfoNew = $rest_client->get('repeatPrintReceipt/startInit/',array('contractNumber'=>$contractNumber,'is_full_payment'=>1));
				 $result['contract'] = $InfoNew->contractArr; 	
				 $tpl->assign('title','重复打印');
                 $tpl->display('header.html');
                 $tpl->display('repeat_print_instalment.html',$result);	
			}
			break;
	}	
}
else
{
    print_r($contractInfo);die;
}
?>
