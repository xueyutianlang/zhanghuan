<?php
/**
 * description:自动联想信息功能
 *
 * @author : zhanghuan<xueyutianlang@163.com>
 * @date   : 2014-06-18
 */
class AutoAssociation extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('usesession');
		$this->load->model('assocication_mdl','store');
	}

	/**
	 * description:页面初始化
	 */
	function index()
	{
		$this->load->view('data/data_goods_img_chose.html',$data);
	}
    
	/**
	 * ajax异步获取信息
	 *
	 * @author : zhanghuan
	 * @data   : 2014-06-18
	 * @param  : string - year [年份][不可为空]
	 * @param  : string - name [名称][不可为空]
	 * @return : json
	 * @example: Ajax(), value json($data)
	 */
	function Ajax()
	{
		$year = ($this->input->get_post('year') !==false)? $this->input->get_post('year') :'';/*年份*/
		$gname = ($this->input->get_post('name')!==false)? $this->input->get_post('name'):'';/*名称*/
		if($year == '' || $gname == '')
        {
			echo json_encode(array('status'=>0,'error'=>'重要参数丢失'));die;
		}
		$data = array();
		$data = $this->group->getTotal(array('year'=>$year), $limit=0, $offset=0, $order='',$where_in=array(),$where_like=array('group_name'=>$gname),$field="group_name");
		if(empty($data))
		{
		   echo json_encode(array('status'=>2,'error'=>'未查询到相关记录'));die;
		}
		echo json_encode(array('status'=>1,'data'=>$data));
	}
}	
