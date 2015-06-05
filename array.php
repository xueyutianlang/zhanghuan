<?php
/*统计数组中的异常*/
function error($array =array())
{
    $Fmsg = 0;
    $Sonmsg = 0;
    foreach($array as $key =>$value)
    {
        //如果是二维数组，对第二维护数组进行记录
        if(is_array($value))
        {
            foreach($value as $keys =>$vals)
            {
                //如果第二维数组中元素为空的话，记录异常信息 
                if(!$vals)
                {
                    $Sonmsg++;    
                }
            }
        }
        //若是二位数组且同时为空数组
        else if((is_array($value))&& empty($value))
        {
            $Fmsg++;
        }
        //若不是二维数组且同时为空 
        else
        {
           $Fmsg++;
        }
    }
}    

?>
