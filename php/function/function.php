<?php
/**
 * 封装列表页面,页面跳转方法
 *
 * @author : zhanghuan<xueyutianlang@163.com>
 * @data   : 2014-12-1
 *
 */

/**
  * 封装跳页方法
  * @param string - jumpurl[跳页的路径,例如:/index.php/virtual_data\index?a=1&b=2][不可为空]
  * @param int - totalrow[总记录数][不可为空]
  * @param string - pageinfo[分页信息,例如: 首页 上一页 1 2 3 下一页 尾页][不可为空]
  * @param string - jumppagetype[定义偏移量是谁,例如:per_page][不可为空]
  * @param string - go[跳页的内容,例如: 跳转到第1页][不可为空]
  * @param int - pagenum[页面记录的条数,例如:一页中记录的条数为10条][不可为空]
  * @return mix - string/error
  */
function goJump($jumpurl='',$totalrow=0,$jumppagetype='',$pagenum=10)
{
    $CI = &get_instance();
	$totalrow = intval($totalrow);
	//获取跳转input框的值go
	$getgo = $CI->input->get_post('go');
	//计算出总页数
	$totalPage = ceil($totalrow/$pagenum);
	$go = !empty($getgo)? intval($getgo):'';
	if(empty($jumpurl))
	{
        echo '输入跳转的路径错误';die;
	}
	if(empty($jumppagetype))
	{
		echo '输入偏移量类型,例如:per_page';die;
	}
	if(empty($pagenum))
	{
		echo '请输入正确的页面记录条数,例如：10';die;
	}
	if($totalrow > $pagenum)
	{
	    return "<span style=\"height:17px;\">
                跳转到：
                <input type='text' id='jumpval' style='width:30px;color:#333;font-weight:bold;border:#999 solid 1px;text-align:center;height:18px;line-height:18px;margin:0 0 2px 0 ' value='".$go."'/>
				<input onclick=\"javascript:jumpGo('jumpval','".$jumpurl."','".$totalPage."','".$jumppagetype."');\" type= 'button' value= 'GO' style= 'background:#5593FF;color:#fff;border:none;width:40px;text-align:center;height:20px;line-height:20px; margin:0 0 2px 0 ' />
               </span>
			  ";
	}
}
?>
