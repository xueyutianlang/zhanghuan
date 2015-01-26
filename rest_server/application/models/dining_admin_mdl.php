<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 数据层模型admin, 后台账户表
 * 
 * @author: zhanghuan
 * @date: 2014-04-02
 */
class Dining_admin_mdl extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->_table='dining_admin';
		$this->_pkey = 'admin_id';
		$this->_charset = 'utf8';
	}
	
	/**
	  * 新增后台账户表信息
	  * 覆盖父类的insert方法
	  *
	  * @access public
      * @param array - $data 后台账号表信息 
	  * @return mixed - 主键id/false/参数错误提示
	  */
	/*public function insert($data=array())
	{
	    if(empty($data) || !is_array($data))
		{
			return false;
		}
		else
		{
			if(!empty($data['username']) && !empty($data['password']) && !empty($data['name']) && !empty($data['add_time']) && !empty($data['role_id']) && !empty($data['opeator']))
		    {
		    return parent::insert($data);
		    }
		    else
		    {
			return false;
		    }	
		}
	}*/

	/**
	  * 修改后台账户表信息
	  * 覆盖父类的update方法
	  *
	  * @access public
      * @param array - $data 后台账号表信息 
	  * @return mixed - 主键id/false/参数错误提示
	  */
	/*public function update($id,$data)
	{
	   if( empty($id) || !is_numeric($id) )
        {
            return false;
        }
		else
		{  
			if(isset($data['username']) && empty($data['username']))
			{
				return false;
			}
			else if(isset($data['password']) && empty($data['password']))
			{
				return false;
			}
			else if(isset($data['name']) && empty($data['name']))
			{
				return false;
			}
			else if(isset($data['add_time']) && empty($data['add_time']))
			{
				return false;
			}
			else if(isset($data['role_id']) && empty($data['role_id']))
			{
				return false;
			}
			else if(isset($data['opeator']) && empty($data['opeator']))
			{
				return false;
			}
			else
			{  
				return parent:: update($id, $data);
			}
		}	
	}*/

}
