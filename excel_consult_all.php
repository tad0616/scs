<?php
use XoopsModules\Scs\Scs_consult;
use XoopsModules\Scs\Tools;
/**
 * Scs module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Scs
 * @since      2.5
 * @author     tad
 * @version    $Id $
 **/

/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$consult_uid = system_CleanVars($_REQUEST, 'consult_uid', '', 'string');
$start = system_CleanVars($_REQUEST, 'start', '', 'string');
$end = system_CleanVars($_REQUEST, 'end', '', 'string');

if (empty($consult_uid)) {
    redirect_header($_SERVER['HTTP_REFERER'], 3, '未指定教師');
}

Tools::chk_consult_power(__FILE__, __LINE__, 'statistics', '', '', $consult_uid);

$consult = Scs_consult::statistics_by_month($consult_uid, $start, $end, 'return');
// vv($consult);
$title = "個別諮商期末報表";

/** Error reporting */
error_reporting(E_ALL);

require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel.php'; //引入 PHPExcel 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php'; //引入 PHPExcel_IOFactory 物件庫
$objPHPExcel = new PHPExcel(); //實體化Excel
$objPHPExcel->createSheet(); //建立新的工作表，上面那三行再來一次，編號要改
$objPHPExcel->setActiveSheetIndex(0);
$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
$objActSheet->setTitle($title); //設定標題

$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);

$objActSheet->getColumnDimension('A')->setWidth(10);
$objActSheet->getColumnDimension('B')->setWidth(15);
$objActSheet->getColumnDimension('C')->setWidth(10);
$objActSheet->getColumnDimension('D')->setWidth(20);

$objActSheet->setCellValue('A1', "輔導教師：{$consult['consult_name']}");

$objActSheet->setCellValue('A2', '月份')
    ->setCellValue('B2', '班級')
    ->setCellValue('C2', '座號')
    ->setCellValue('D2', '姓名');
$n = 4;
for ($i = 1; $i <= $consult['max_times']; $i++) {
    $col = num2alpha($n);
    $objActSheet->setCellValue("{$col}2", "會談日期{$i}");
    $objActSheet->getColumnDimension($col)->setWidth(20);
    $n++;
}
$col = num2alpha($n);
$objActSheet->setCellValue("{$col}2", '次數');
$objActSheet->getStyle("A2:{$col}2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFBFE9F2');

$i = 2;
foreach ($consult['data_arr'] as $m => $data) {
    foreach ($data as $stu_id => $stu) {
        $i++;
        $objActSheet->setCellValue("A{$i}", $m)
            ->setCellValue("B{$i}", "{$stu[0]['stu_grade']}-{$stu[0]['stu_class']}")
            ->setCellValue("C{$i}", $stu[0]['stu_seat_no'])
            ->setCellValue("D{$i}", $stu[0]['stu_name']);
        $times = sizeof($stu);
        $n = 4;
        for ($j = 0; $j <= $consult['max_times']; $j++) {
            $col = num2alpha($n);
            $objActSheet->setCellValue("{$col}{$i}", $stu[$j]['consult_cdate']);
            $n++;
        }

        $objActSheet->setCellValue("{$col}{$i}", $times);

    }
}

$objActSheet->getStyle("A2:{$col}{$i}")->applyFromArray($styleArray);

$objActSheet->getStyle("A2:{$col}{$i}")->getAlignment()
    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER) //垂直置中
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //水平置中

$date = $start_txt = $end_txt = "";
if ($start) {
    $start_txt = "{$start}起";
}if ($end) {
    $end_txt = "{$end}止";
}
if ($start or $end) {
    $date = "（{$start_txt}{$end_txt}）";
}

$excel_title = $title . "-{$consult['consult_name']}{$date}";
$excel_title = (_CHARSET === 'UTF-8') ? iconv('UTF-8', 'Big5', $excel_title) : $excel_title;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename={$excel_title}.xlsx");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setPreCalculateFormulas(false);
$objWriter->save('php://output');
exit;

function num2alpha($n)
{
    for ($r = ""; $n >= 0; $n = intval($n / 26) - 1) {
        $r = chr($n % 26 + 0x41) . $r;
    }

    return $r;
}
