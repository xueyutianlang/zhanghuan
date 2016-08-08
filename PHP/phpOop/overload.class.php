<?php
/**
 * @description: 重载
 *
 * @author : snow wolf <xueyutianlang@163.com>
 * @date   : 2016-08-04
 **/

class Emplyee
{
    public $name = 'snow wolf';
    
    protected $sex = 'man';

    private $secret = 'There is no';

    private $hobby;

    /*访问并获取动态封装的类属性值*/
    public function __get($name)
    {
        //可以获取禁止访问的属性
        echo __METHOD__."属性{$name}:".$this->$name;
    }

    /*动态封装类的属性值*/
    public function __set($name,$value)
    {
        $this->$name = $value;
        echo __METHOD__."动态封装 属性{$name}:".$value;
    }
    
}
$test = new Emplyee;
$test->name;//没有调用__get 
//$test->sex;//Emplyee::__get属性sex:man
//$test->secret;//Emplyee::__get属性secret:There is no

/*首次调用 爱好*/
$test->hobby;//Emplyee::__get属性hobby:

/* 首次针对私有属性爱好进行赋值操作 */
$test->hobby = 'hahaha';//Emplyee::__set动态封装 属性hobby:hahaha

/* 再次调用 爱好 */

$test->hobby;//Emplyee::__get属性hobby:hahaha
