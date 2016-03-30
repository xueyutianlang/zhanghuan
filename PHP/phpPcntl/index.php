<?php

/**
 * @descrition: php实现多进程处理
 * 
 * @author  : xueyutianlang<xueyutianlang@163.com>
 * @date    : 2016-03-29
 * @version : 1.0.0
 *
 **/
ini_set('memory_limit','1280M');
include 'vendor/autoload.php';
class StatsPcntl
{
    protected static $instance;
    protected $config;
    protected $xxdb;
    protected $file;
    const     PATH = "/tmp/stats/";
    protected function __construct()
    {
        $this->config = new ArrayObject(include 'config/database.php', ArrayObject::ARRAY_AS_PROPS);
        $this->xxdb = Zend_Db::factory('PDO_MYSQL',$this->config->xxdb);
        $this->tableName = 'xx_xx_xx';
    }

    public function run()
    {
        //创建临时存放csv的文件目录
        is_dir(self::PATH) || mkdir(self::PATH,0755,true) && chmod(self::PATH,0755);
        $number = $this->getNumber($this->tableName);
        //根据线上数据考虑决定启动多进程
        $max = 360000;//50w 数据
        $workers = 12;//10个子进程修改
        $pids = array();//建立统计子进程pid的数组
        for($i = 0; $i< $workers; $i++)
        {
            $pids[$i] = pcntl_fork();
            //创建vip从库的多进程资源;
            $slave = 'xxslave_'.$i;
            $this->$slave = Zend_Db::factory('PDO_MYSQL',$this->config->xx_xx_db);
            switch($pids[$i])
            {
                //notice : 若为-1 则表示子进程fork出错。
                case -1: 
                echo "fork error : {$i} \r\n";
                exit;
                //pid 在子进程看是0 ，故此处为 子进程 逻辑代码块儿。
                case 0 :
                
                $limit = $max / $workers * $i;
                $length= 30000;
                if($i==($workers-1)) {$length = $number-($length*$i);}
                //创建csv 文件
                $this->file = self::PATH.date('Ymd').'--*'.$i.'*--'.$limit.'-'.$length.'.csv';
                $header = "\xEF\xBB\xBF"
                               .'主键,用户名,用户创建时间'.PHP_EOL;
                file_put_contents($this->file , $header );
                $this->doAction($this->file,$this->$slave,$limit,$length);
                exit;
                //pid 在父进程来看是大于0,故此处为父进行逻辑代码块儿。
                default:
                break;
            }       
        }
        foreach ($pids as $i => $pid) 
        {
            if($pid) 
            {
                pcntl_waitpid($pid, $status);
            }
        }
    }
    
    public function doAction($file,$slave,$limit,$length)
    {
        $result  = $this->getPageData($slave,$limit,$length);
        if($result)
        {
           $this->updateAction($result,$limit,$length);    
        }
    }
 
    public function updateAction($result,$limit,$length)
    {
         foreach($result as $value)
		 {
             $info = array(
                (int)$value['id'],
                (string)$value['username'],
                (string)date('Y-m-d H:i:s',$value['time']),
             );
             file_put_contents($file, implode(',',$info).PHP_EOL, FILE_APPEND);
         }    
    }
    
    /*
     * @封装error 
     * @param - int - $error eg: 1.param error; 其它情况 other error;
     * @param - int - $line
     */
    protected function errorMsg($line= 0,$error= 1)
    { 
        switch($error)
        {
        case '1' : $msg = 'param error';break;
        default  : $msg = 'other error';break;
        }
        echo '封装报错方法 '.$msg.': in '.__FILE__.' on line '.$line;die;
    }     

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }      

    private function __clone(){}
}

$object = LeduVipStats::getInstance();

var_dump($object->run());die;
?>
