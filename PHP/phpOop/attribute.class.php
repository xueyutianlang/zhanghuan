<?php
/**
 * @description : 类属性作用域
 *
 * @author : snow wolf <xueyutianlang@163.com>
 * @date   : 2016-08-02
 **/

class attribute 
{
    public    $name = 'snow wolf';
    protected $sex  = 'man';
    private   $height= 2.26 ;
    protected static    $job  = 'phper';

    public function index()
    {
       $this->height='2.26';
       echo $this->height;
    }
}

//分别验证不同作用域的属性
//$obj = new attribute;
//echo $obj->name;
//echo $obj->sex;//PHP Fatal error:  Cannot access protected property attribute::$sex
//echo $obj->height;//PHP Fatal error:  Cannot access private property attribute::$height
//attribute::$job='程序猿';//Fatal error: Cannot access protected property attribute::$job
//echo attribute::$job;
 
/*分别验证不同作用域在类间继承与调用*/


class sonAttribute extends attribute
{
    function aa()
    {
        echo $this->sex;
        echo self::$job;
    }
}

//$sonObj = new sonAttribute;
//echo $sonObj->name;
//echo $sonObj->aa();//PHP Notice:  Undefined property: sonAttribute::$height
//echo $sonObj->index();//虽然父类私有属性不被继承，但可以通过继承父类调用私有属性的方法，来间接显示父类私有属性


/*验证 php 面向对象 是否可以定义final 属性*/

class Test
{
    final $age;
}

$obj = new Test;//PHP Fatal error:  Cannot declare property Test::$age final, the final modifier is allowed only for methods and classes








