<?php
class dbClass
{
    protected static $_instance = null;
    protected $dns;
    protected $username;
    protected $password;
    protected $charset;
    protected $obj;
    private function __construct($dns,$username,$password,$charset)
    {
		try {
				$this->obj = new PDO($dns, $username, $password);
                //$this->obj->exec('SET character_set_connection='.$dbCharset.', character_set_results='.$dbCharset.', character_set_client=binary');
                $this->obj->exec('set names utf8');
         } catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
		 }
    }
    
    private function __clone(){}
    
    static public function instance($dns,$username,$password,$charset='gbk')
    {
         if(!self::$_instance)
         {
              self::$_instance = new self($dns,$username,$password,$charset);
         }
         return self::$_instance;         
    }
    
   /*
     * @获取数据
     */
    public function getData($strSql)
    {
         $recordInfo = $this->obj->query($strSql);
         $recordInfo->setFetchMode(PDO::FETCH_ASSOC);
         $result = $recordInfo->fetchAll();
         return $result;
    }
 
    /*
     *@ get 
     */
    public function get($strSql)
    {
        $record = $this->obj->prepare($strSql);
        $record->execute();
        return $record->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function insert()
    {
       $sql = "insert into goods (idcard,name,age) values('120','张',10)";
       //$res = $this->obj->prepare($sql);
       $info = $this->obj->exec($sql);
       if(!$info)
       {
           var_dump($this->obj->errorInfo());
           var_dump($this->obj->errorCode());
       }
       var_dump($info);die;
    }
}
$dns = 'mysql:host=localhost;dbname=zhanghuan';
$username = 'root';
$password='123456';
$charset = 'utf8';
$object =  dbClass::instance($dns,$username,$password,$charset);
?>
