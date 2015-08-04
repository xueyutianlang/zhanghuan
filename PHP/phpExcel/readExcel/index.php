<?php
/**
 * @description : PHPEXCEL 导出excel到数组
 * @author      : web
 * return array();
 */
class importData
{ 
    function __construct()
    {
        header("content_type:text/html;charset=utf-8");
    }

    /*
     * @description : 导出excel数据
     * @param       : [string] - $file
     * @return      : [array]  - array()
     */
    function importExcel($file)
    {
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        require_once 'Classes/PHPExcel/Reader/Excel5.php';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');//use 2007 for 2007 format
        $objPHPExcel = $objReader->load($file);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $excelData;
    }
} 

$resource = new importData('hrdata.xls');
//获取数组
$res = $resource->importExcel('hrdata.xls');
//根据业务逻辑拼写sql
$string = '';
$name = '';
foreach($res as $value)
{
        $string .= ',\''.trim($value[1]).'\'';
}
$newStr = substr($string,1);
$sql = "delete from user where id in(select id from(select id from users where user_ch_name not in(".$newStr.")) as union_id)";






