<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 用户模型
 *
 * @author : zhanghuan<xueyutianlang@163.com>
 * @date   : 2015-01-21
 *
 */
class Ecm_user_mdl extends CI_Model
{
     public function __construct()
	 {
		 parent::__construct();
	 }

	 /*
	  * 获取一条数据
	  *
	  *
	  */
	 public function getTotail()
	 {
		 $this->load->database();
		 $res = $this->db->get('admin');
		 return $res->result_array();
	 }

}	
?>
