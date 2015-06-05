<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Uplugin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
       parent::__construct();
       $this->load->helper('image_config');
    }
	public function index()
    {
        $this->load->view('Up/index.html');
    }
    public function upload()
    {
        echo 11111;die;
        if (!empty($_FILES)) 
        {
            $uid = intval( $_REQUEST['uid'] );
            $ext = pathinfo($_FILES['Filedata']['name']);
            $ext = strtolower($ext['extension']);
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = IMG_UP;
            //$targetPath   = ROOT_PATH . 'uploads/';
            if( !is_dir($targetPath) )
            {
                mkdir($targetPath,0777,true);
            }
            $new_file_name = 'avatar_ori.'.$ext;
            $targetFile = $targetPath . $new_file_name;
            move_uploaded_file($tempFile,$targetFile);
            if( !file_exists( $targetFile ) )
            {
                $ret['result_code'] = 0;
                $ret['result_des'] = 'upload failure';
            } 
            elseif( !$imginfo=getImageInfo($targetFile) ) 
            {
                $ret['result_code'] = 101;
                $ret['result_des'] = 'File is not exist';
            } 
            else 
            {
                $img = $targetFile;
                //$img = 'uploads/'.$new_file_name;
                resize($img);
                $ret['result_code'] = 1;
                $ret['result_des'] = $img;
            }
        } 
        else 
        {
            $ret['result_code'] = 100;
            $ret['result_des'] = 'No File Given';
        }
        exit( json_encode( $ret ) );
        //$this->load->helper('upload');
    }
    
    function resize()
    {
        if( !$image = $_POST["img"] )
        {
            $ret['result_code'] = 101;
            $ret['result_des'] = "图片不存在";
        } 
        else 
        {
            $image = IMG_UP . $image;
            $info = getImageInfo( $image);
            if( !$info )
            {
                $ret['result_code'] = 102;
                $ret['result_des'] = "图片不存在";
            } 
            else 
            {
                $x = $_POST["x"];
                $y = $_POST["y"];
                $w = $_POST["w"];
                $h = $_POST["h"];
                $width = $srcWidth = $info['width'];
                $height = $srcHeight = $info['height'];
                $type = empty($type)?$info['type']:$type;
                $type = strtolower($type);
                unset($info);
                // 载入原图
                $createFun = 'imagecreatefrom'.($type=='jpg'?'jpeg':$type);
                $srcImg     = $createFun($image);
                //创建缩略图
                if($type!='gif' && function_exists('imagecreatetruecolor'))
                    $thumbImg = imagecreatetruecolor($width, $height);
                else
                    $thumbImg = imagecreate($width, $height);
                // 复制图片
                if(function_exists("imagecopyresampled"))
                    imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth,$srcHeight);
                else
                    imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height,  $srcWidth,$srcHeight);
                if('gif'==$type || 'png'==$type) 
                {

                    $background_color  =  imagecolorallocate($thumbImg,  0,255,0);
                    imagecolortransparent($thumbImg,$background_color);
                }
                // 对jpeg图形设置隔行扫描
                if('jpg'==$type || 'jpeg'==$type) 
                    imageinterlace($thumbImg,1);
                // 生成图片
                $imageFun = 'image'.($type=='jpg'?'jpeg':$type);
                $thumbname01 = str_replace("ori", "200", $image);
                $thumbname02 = str_replace("ori", "130", $image);
                $thumbname03 = str_replace("ori", "112", $image);
                $imageFun($thumbImg,$thumbname01,100);
                $imageFun($thumbImg,$thumbname02,100);
                $imageFun($thumbImg,$thumbname03,100);
                $thumbImg01 = imagecreatetruecolor(200,200);
                imagecopyresampled($thumbImg01,$thumbImg,0,0,$x,$y,200,200,$w,$h);

                $thumbImg02 = imagecreatetruecolor(130,130);
                imagecopyresampled($thumbImg02,$thumbImg,0,0,$x,$y,130,130,$w,$h);

                $thumbImg03 = imagecreatetruecolor(112,112);
                imagecopyresampled($thumbImg03,$thumbImg,0,0,$x,$y,112,112,$w,$h);

                $imageFun($thumbImg01,$thumbname01,100);
                $imageFun($thumbImg02,$thumbname02,100);
                $imageFun($thumbImg03,$thumbname03,100);
                imagedestroy($thumbImg01);
                imagedestroy($thumbImg02);
                imagedestroy($thumbImg03);
                imagedestroy($thumbImg);
                imagedestroy($srcImg);
                $ret['result_code'] = 1;
                $ret['result_des'] = array(
                    "big"   => str_replace(IMG_UP, "", $thumbname01),
                    "middle"=> str_replace(IMG_UP, "", $thumbname02),
                    "small" => str_replace(IMG_UP, "", $thumbname03)
                );
            }
        }
        echo json_encode($ret);
        exit();
    }
}
