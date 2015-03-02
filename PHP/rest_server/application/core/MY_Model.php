<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 数据层基类，提供基本的CRUD操作
 *
 * @author: zg
 * @date: 2013-11-06
 */

class MY_Model extends CI_Model
{
	//表名
	protected $_table;
	//主键
	protected $_pkey;
	protected $_orderPrivate;
    protected $_testing = 0;  //1代表开发测试环境，会记录查询、更新、添加的数据进入sqlog表
	
	public function __construct()
	{
		parent::__construct();
        $this->_pkey = 'id';
        $this->_charset = 'utf8';
    }

    function show()
    {
        $sql = 'SELECT database() AS dbname';
        $query = $this->mydb->query($sql)->row();
        $c = get_called_class();
        echo '<br/>in '. $c .' show :';
        echo '<br/>databaseName : ';
        var_dump($query->dbname);
        echo '<br/>';
    }

    /**
     * 初始化model的数据库句柄
     *
     * @param string - $type 'mis'/'order'
     * @param mixed - $merchantId 'share'/id
     * @return null
     */
    public function init($type='mis', $merchantId='share')
    {
        if(empty($type) || !is_string($type) || !in_array($type, array('mis', 'orderPrivate', 'orderShare','dining','members')))
        {
            exit('class: '.__CLASS__.' function : ' .__FUNCTION__. ' say: bad param');
        }
        switch($type)
        {
            case 'mis':
                $this->mydb = $this->switchdb->connectMis();
                break;
            case 'orderPrivate':
                $this->mydb = $this->switchdb->connectOrder($merchantId);
                break;
            case 'orderShare':
                $this->mydb = $this->switchdb->connectOrder();
                break;
            case 'dining':
                $this->mydb = $this->switchdb->connectDining();
                break;
			case 'members':
                $this->mydb = $this->switchdb->connectMembers();
                break;
            default:
                return false;
                break;
        }
        $this->_set_names();
        $this->_chk_table_exists(); //检查表是否存在
    }

    private function _set_names()
    {
        $sql = 'SET NAMES '. $this->_charset;
        $this->mydb->query($sql);
        log_message('debug', 'set names');
    }

    //检查表是否存在
    private function _chk_table_exists()
    {
        if(!$this->mydb->table_exists($this->_table))
        {
            exit('the table `'. $this->_table .'` not exists in database '. $this->mydb->database);
        }
    }
    /**
     * 通过主键，得到某一字段数据
     *
     * @param int - $id 主键值
     * @param int - $field 要得到的字段名
     * @return string - 字段的值
     */
	public function getFieldById($id, $field)
	{
        if( empty($id) || !is_int($id) || empty($field) )
        {
            return false;
        }
		$this->mydb->select($field)->where($this->_pkey, (int)$id);
		$arr = $this->mydb->get($this->_table)->row();
        return empty($arr->$field) ? '' : $arr->$field;
    }


    private function sqlStatmentStore($sqlstring)
    {
        $con = mysql_connect("localhost:3306","common","common") or die("sqlStatmentStore can not connect mysql server");
        mysql_select_db("errorlog",$con);
        $sql = "insert into sqlog values(null,'".$sqlstring."','".date("Y-m-d H:i:s")."')";
        $res = mysql_query($sql);
    }

	/**
     * 通过主键，得到一条记录
     *
     * @param int - $id 主键值
     * @return mixed - 一条记录的数组/失败
     */
	public function getOne($id,$field="*")
	{
        if( empty($id) || !is_int($id) )
        {
            return false;
        }
		$query = $this->mydb->select($field)->where($this->_pkey, (int)$id)->get($this->_table);
        (1==$this->_testing) && $this->sqlStatmentStore(addslashes($this->mydb->last_query()));
		return ($query->num_rows() > 0) ? $query->row_array() : false;
    }
   	
    /**
     * 得到符合条件的记录
     *
     * @param array - $where 条件，如：array('status'=>1)
     * @param int - $limit 最多返回条数
     * @param int - $offset 偏移量
     * @param string - $order 排序信息，如：'sort DESC'
     * @param array - $where_in 对应关键字IN，如：array('user_id'=>'1,2,5')
     * @param array - $where_like 对应关键字LIKE，如：array('user'=>'某某')
     * @return array - 所有记录的数组
     */
	public function getTotal($where=array(), $limit=0, $offset=0, $order='',$where_in=array(),$where_like=array(),$field="*",$group_by='')
    {
        if(!empty($field))$this->mydb->select($field);
		if(!empty($where))$this->mydb->where($where);
		if(!empty($order))$this->mydb->order_by($order);
        if((int)$limit) $this->mydb->limit($limit);
        if((int)$offset) $this->mydb->offset($offset);
        if(!empty($where_in)) $this->mydb->where_in($where_in['field'],$where_in['values']); 
		if(!empty($group_by))$this->mydb->group_by($group_by);
        //liangxifeng 2014-06-26 添加whereLike匹配符的位置情况
        if(!empty($where_like))
        {
            //如果自定义通配符位置
            if(isset($where_like['wildcardPosition']))
            {
                $pos = $where_like['wildcardPosition'];
                $this->mydb->like($pos['field'],$pos['value'],$pos['position']);
            }else
            {
                $this->mydb->like($where_like);
            }
        }
        $res = $this->mydb->get($this->_table);
        (1==$this->_testing) && $this->sqlStatmentStore(addslashes($this->mydb->last_query()));
		return $res->result_array();
	}

    /**
     * 得到符合条件的记录的总条数
     *
     * @param array - $where 条件，如：array('status'=>1)
     * @param array - $where_in 对应关键字IN，如：array('user_id'=>'1,2,5')
     * @param array - $where_like 对应关键字LIKE，如：array('user'=>'某某')
     * @return int - 条数
     */
	public function getTotalNum($where=array(),$where_in=array(),$where_like=array())
	{
        if( !empty($where) )
        {
            $this->mydb->where($where);
        }
        if( !empty($where_in) )
        {
           $this->mydb->where_in($where_in['field'],$where_in['values']); 
        }
        //liangxifeng 2014-06-26 添加whereLike匹配符的位置情况
        if(!empty($where_like))
        {
            //如果自定义通配符位置
            if(isset($where_like['wildcardPosition']))
            {
                $pos = $where_like['wildcardPosition'];
                $this->mydb->like($pos['field'],$pos['value'],$pos['position']);
            }else
            {
                $this->mydb->like($where_like);
            }
        }
        $res = $this->mydb->count_all_results($this->_table);
        (1==$this->_testing) && $this->sqlStatmentStore(addslashes($this->mydb->last_query()));
        return  $res;
	}

    /**
     * 新增记录
     *
     * @param array - $data 记录内容数组，如：array('id'=>null, 'status'=>1)
     * @return mixed - 记录主键/false
     */
    public function insert($data=array())
	{
        if( empty($data) || !is_array($data) )
        {
            return false;
        }
        (1==$this->_testing) && $this->sqlStatmentStore(addslashes($this->mydb->insert_string($this->_table,$data)));
		return ($this->mydb->insert($this->_table, $data)) ? $this->mydb->insert_id() : false;
		//$this->mydb->insert($this->_table, $data);
		//return $this->mydb->last_query();
	}

	/**
     * 通过主键，更新记录
     *
     * @param int - - $id 主键值
     * @param array - $data 记录内容数组，如：array('status'=>0)
     * @return boolean - 成功/失败
     */
    public function update($id, $data)
	{
        if( empty($id) || !is_int($id) )
        {
            return false;
        }
        (1==$this->_testing) && $this->sqlStatmentStore(addslashes($this->mydb->update_string($this->_table,$data,$this->_pkey.'='.$id)));
        /* 人工控制返回值，防止因为update变化引起返回值变化*/
		return ($this->mydb->update($this->_table, $data, array($this->_pkey => (int)$id))) ? true : false;
	}
	
	/**
     * 通过主键，删除记录
     *
     * @param int - $id 主键值
     * @return boolean - 成功/失败
     */
	public function del($id)
	{
        if( empty($id) || !is_int($id) )
        {
            return false;
        }
		return ($this->mydb->delete($this->_table, array($this->_pkey => (int)$id))) ? true : false;
	}
	
}
