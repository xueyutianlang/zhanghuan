<?php 
    /*ajax评论*/
    function ajax()
    {
        $star = '';/*偏移量*/
        $star = isset($_POST['start'])?  intval($_POST['start']) :0;
        $this->model = &m('test');
        $result = $this->model->get_all(array(),"$star,8");
        /*获取总记录条数*/
        $resultnum = $this->model->get_all();
        $dataNum = count($resultnum);
        $data['datanum'] = $dataNum;
		echo json_encode(array('status'=>1,'data'=>$data));
        }
        else
        {
            echo json_encode(array('status'=>2,'error'=>'no record or read table error'));
        }
	
