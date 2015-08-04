<?php
/**
 * @desc PHPEXCEL导入
 * return array();
 */
header("content_type:text/html;charset=utf-8");
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
 
$res = importExcel('hrdata.xls');
$string = '';
$name = '';
foreach($res as $value)
{
        $string .= ',\''.trim($value[1]).'\'';
}
$newStr = substr($string,1);

$sql = "select user_chinese_name from card_users where user_chinese_name not in(".$newStr.")";
$delres = importExcel('deletedata.xls');
foreach($delres as $val)
{
    $delstring .= ',\''.trim($val[0]).'\''; 
}
$delstr = substr($delstring,1);
$sql = "delete from card_users where user_chinese_name in(".$delstr.")";
echo $sql;






