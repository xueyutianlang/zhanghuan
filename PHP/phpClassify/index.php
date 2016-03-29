<?php

/**
 * @ 递归实现无限极分类
 * 
 *
 *
 **/
include './pdo.php';

$treeArr = array();

function getClassify($id=0)
{
    $arr = array();
    //获取父分类
    global $object;
    $sql = 'select * from class where pid='.$id;
    $result  = $object->getData($sql); 
    if($result)
    {
        foreach($result as $key =>$value)
        {
             $value['list'] = getClassify($value['id']);
             $arr[] = $value;
        }  
    }
    return $arr;
   
}

$sql = 'select * from class';
$dataInfo = $object->getData($sql);

/**
  * @ 引用传值实现无限极分类
 **/

function classifyTree($data)
{
   $tree = array();
   if(array_key_exists(0,$data))
   {
       $dataInfo = array();
       foreach($data as $key=>$val)
       {
           $dataInfo[$key+1] = $val;
       }
       unset($data);
       $data = $dataInfo;
   }
   $items = $data;

   //分类 start
   foreach($items as $item)
   {
      if(isset($items[$item['pid']])){
          $items[$item['pid']]['list'][] = &$items[$item['id']];
      }else{
          $tree[] = &$items[$item['id']];
	  }
   }

    return $tree;
    
}




