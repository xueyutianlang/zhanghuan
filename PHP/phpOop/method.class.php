<?php
/**
 * @description : 类方法 
 *
 * @author : snow wolf <xueyutianlang@163.com>
 * @date   : 2016-08-02
 **/

class people
{
    public $name = 'your name';

    public function index()
    {
        echo '起名字'.$this->name;
    }
    final protected function song()
    {
        echo '唱歌';
    }

    protected static function dance()
    {
        echo '跳舞';
    }

    private function skills()
    {
        echo '特异功能';
    }
}


class personal extends people 
{
    /*验证个人派生类会继承人类里的方法*/
    public function __construct()
    {
        $this->index();//起名字your name
        $this->song();//唱歌
        //$this->skills();//PHP Fatal error:  Call to private method people::skills() from context 'personal'
        self::dance();
    }
    
    /*验证派生类method 访问级别小于父类 method*/

    //protected function index()//PHP Fatal error:  Access level to personal::index() must be public (as in class people)
    public function index()
    {
        //验证在父类方法的基础上执行新的业务
        parent::index();
        echo "\n my name is snow wolf";//起名字your name
                                       //my name is snow wolf 
    }

    /* 验证静态方法的继承与覆盖 */
    protected static function dance()
    {
        parent::dance();
        echo "\n American street dance";//跳舞
         //American street dance
    }

    /* 验证 final 方法是否可以被覆盖 */

    public function song()
    {
        parent:: song();
        echo "\n English Song";//PHP Fatal error:  Cannot override final method people::song()
    }

}
$test = new personal;



