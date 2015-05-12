<?php 
/**
 * @descrition: memcache 测试接口
 * @author    : zhanghuan<xueyutianlang@163.com>
 * @date      : 2015.05.12
 *
 **/
class TestModel extends Test_Model {

    private $_db = null;

    private $_cache;

    private $_key = 'test_';

    private $_table = 'test';

    public function __construct() {
        $this->_db = $this->loadDb('test');
        global $testConf;
        $this->_cache = new Memcache($testConf['cache']);
    }
    
    public function getList($where,$field, $order)
    {
        $arr = explode("'",$where);
        $keys = $this->_key.$arr['1'];
        $res = $this->_cache->get($keys);
        if(empty($res))
        {
            /*定义返回数据数组*/
            $result = array();
            $whereSql = '';
            if(!empty($where))
            {
                $whereSql .=' and '.$where;
            }
            $sql = " SELECT ".$field." FROM ".$this->_table;
            $sql.= ' WHERE 1 '.$whereSql;
            $sql.= ' order by '.$order;
            $result = $this->_db->fetchAll($sql); 
            if(!$result)
            {
                return $result;
            }
            $res = $this->_cache->set($keys,$result,20);
            return $result;
        }
        else
        {
            return $res;
        }
    }

    public function save($id=0, $data=array()) 
    {
        $keys = $this->_key.$data['tname'];
        $this->_cache->set($keys,Null,1);
        if($id) 
        {
            $where = 'tid='.$id;
            $this->_db->update($this->_table, $data, $where);
        } 
        else 
        {
            $this->_db->insert($this->_table, $data);
        }
    }
}
?>
