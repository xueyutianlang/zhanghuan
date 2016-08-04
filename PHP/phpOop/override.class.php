<?php

/**
 * @description: 覆盖操作
 *
 * @author : snow wolf <xueyutianlang@163.com>
 * @date   : 2016-08-03
 * 
 **/

class People{

    private function index()
    {
        echo '人唱歌';
    }

    protected function dance()
    {
        echo '跳舞';
    }
}

class Woman extends People{

    /* 验证覆盖只能发生在继承了父类的方法里,此处只是子类定义与父类所有方法名中相同的一个新方法 */
    public function index()
    {
        // 子类没有继承父类私有的index 方法，更无法调用父类私有方法
        echo parent::index();//Fatal error: Call to private method people::index()
    }
    /* 验证子类覆盖父类方法，访问修饰符级别要大于等于父类*/
    private function dance()
    {
        echo parent::dance();//PHP Fatal error:  Access level to Woman::dance() must be protected (as in class People) or weaker
    }

    public function test()
    {
        $this->dance();
    }

}
$woman1=new woman();
$woman1->index();
$woman1->test();









