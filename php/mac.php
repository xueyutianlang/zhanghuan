<?php
/*
 * description : 获取linux/unix/windows下mac地址
 * @author     : zhanghuan<xueyutianlang@163.com>
 *
 * @date       : 2014-12-25
 */
class getmacaddr
{
	    /*返回带有mac地址的字符串数组*/
	    var $return_array = array(); 
        var $mac_addr;
        
        function getmacaddr($os_type)
        {
                switch ( strtolower($os_type) )
                {
                        case "linux":
                                $this->forlinux();
                                break;
                        case "solaris":
                                break;
                        case "unix":
                                break;
                        case "aix":
                                break;
                        default:
                                $this->forwindows();
                                break;
                }
                
                $temp_array = array();
                foreach ( $this->return_array as $value )
                {
                        if ( preg_match( "/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i", $value, $temp_array ) )
                        {
                                $this->mac_addr = $temp_array[0];
                                break;
                        }
                }
                unset($temp_array);
                return $this->mac_addr;
        }
        function forwindows()
        {
                @exec("ipconfig /all", $this->return_array);
                if ( $this->return_array )
                        return $this->return_array;
                else{
                        $ipconfig = $_server["windir"]."system32ipconfig.exe";
                        if ( is_file($ipconfig) )
                                @exec($ipconfig." /all", $this->return_array);
                        else
                                @exec($_server["windir"]."systemipconfig.exe /all", $this->return_array);
                        return $this->return_array;
                }
        }
        function forlinux()
        {
                @exec("ifconfig -a", $this->return_array);
                return $this->return_array;
        }
}
/*实例化*/
$mac = new getmacaddr('linux');
echo $mac->mac_addr;
