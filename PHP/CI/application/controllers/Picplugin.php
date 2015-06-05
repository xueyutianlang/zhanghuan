<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @description: picture demo .For more detailed example is simple 
 * @author     : zhanghuan<xueyutianlang@163.com>
 * @maker       : web
 *
 **/
class Picplugin extends CI_Controller {
	
    private $imgUrl;
    private $images;
    public function __construct()
    {
        parent::__construct();
        error_reporting(7);
        date_default_timezone_set("Asia/Shanghai");
        header("Content-type:text/html; Charset=utf-8");
        $this->load->helper('image');
        $this->images = new Images("file");
    }
    
    /*
     * @description: 初始化方法
     */
    public function index()
    {    
        
        switch($_GET['act'])
        {
            //上传需要将产生的图片路径放到img属性中
            case 'upload':
                if(!$_FILES)
                {
                    echo '<script>alert("请重新上传图片");window.location.href="/index.php/Picplugin/index"</script>';
                    die;
                } 
               $path = $this->images->move_uploaded();
               $this->images->thumb($path,false,0);							//文件比规定的尺寸大则生成缩略图，小则保持原样
               if($path == false)
               {
                   $this->imgUrl = $this->images->get_errMsg();
               }
               else
               {
                   $this->imgUrl = $path; 
               }
               break;
            case 'cut':
                //假如已经获取了路径
                if(!$_POST['finalImg'])
                {
                    echo '<script>alert("请重新上传图片");window.location.href="/index.php/Picplugin/index"</script>';
                    die;
                } 
                
                $image = substr($_POST['finalImg'],1);
                /*因页面展示路径和物理路径不同以此拼接成物理路径*/
                $res = $this->images->thumb($image,false,1);
                $res['big'] ='/'.$res['big'];
                $res['small'] ='/'.$res['small'];
                if($res == false){
                    echo "裁剪失败";
                }else
                {
                    $data['finalImg'] = 'yes';
                    $data['finalImg_big'] = $res['big'];
                    $data['finalImg_small'] = $res['small'];
                }
                break;
        }
        $data['disImg'] = empty($this->imgUrl) ? '':'/'.$this->imgUrl;
        $this->load->view('picture/index.html',$data);
    }
}
