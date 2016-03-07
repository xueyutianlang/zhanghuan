<?php
/** 
 * @description : php 递归小demo
 * @author      : zhanghuan <xueyutianlang@163.com>
 * @date        : 2016-03-07
 **/

 function add($n)
 {
    if($n < 1)
    {
       return ;
    }
    //执行过程
    return $n+add($n-1);
    //return $n+add($n-1);
}
//echo add(5);
 
//回显函数值，如果调用函数中是直接回显的话，则输出先于当前函数；

function aa()
{
    echo 'aa'.bb();
   
}

function bb()
{
     
    echo 'bb'.cc();
}

function cc()
{
    return 'cc';
}
echo aa();


