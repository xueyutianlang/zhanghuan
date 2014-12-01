/**
 * 封装公共js
 * 
 * @author : zhanghuan<xueyutianlang@163.com>
 * @date   : 2014-12-1
 *
 */

/*javascript实现列表页跳页功能
 *
 * @author -- zhanghuan
 * @date -- 2014.12.01
 * @param -- jumpid: jumpid针对跳页input框 
 * @param -- urlone: 组成跳转链接的第一部分,例如:index.php/data/ceshi/index/goodsname=&goodsstatus=
 * @param -- totalpage: 获取分页的总页数 例如：totalpage为25页
 * @param -- per_page:
 */
function jumpGo(jumpId,urlone,totalpage,per_page)
{
	var jumpval = parseInt($('#'+jumpId+'').val());
	reg = /^\d+$/;
	//获取总页数
	var totalpage = parseInt(totalpage);
	//当输入页码格式正确，输入页码大于0同时满足 输入页码小于最大页码
	if(reg.test(jumpval) && jumpval > 0 )
	{
		var offerset = 0;
		if(jumpval <= totalpage)
		{
		     offerset = (jumpval-1)*10;
		}
		else
		{
		     offerset = (totalpage-1)*10;
		}
		window.location.href=""+urlone+"&"+per_page+"="+offerset+"&go="+jumpval;
	}
}

