<?php
use Xmf\Request;
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
$op = Request::getString('op');
$consult_uid = Request::getInt('consult_uid');
$start = Request::getString('start');
$end = Request::getString('end');

list($y, $m) = explode('-', $start);
$y = $y - 1911;

if (empty($consult_uid)) {
    redirect_header($_SERVER['HTTP_REFERER'], 3, '未指定教師');
}

Tools::chk_consult_power(__FILE__, __LINE__, 'statistics', '', '', $consult_uid);

$consult = Scs_consult::statistics_by_month($consult_uid, $start, $end, 'return');

$title = "教育部每月輔導統計";

/** Error reporting */
error_reporting(E_ALL);

require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel.php'; //引入 PHPExcel 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php'; //引入 PHPExcel_IOFactory 物件庫
$objPHPExcel = new PHPExcel(); //實體化Excel
$objPHPExcel->createSheet(); //建立新的工作表，上面那三行再來一次，編號要改
$objPHPExcel->setActiveSheetIndex(0);
$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
$objActSheet->setTitle('1.當月個案'); //設定標題

$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);

$objActSheet->getColumnDimension('A')->setWidth(10);
$objActSheet->getColumnDimension('B')->setWidth(10);
$objActSheet->getColumnDimension('C')->setWidth(10);
$objActSheet->getColumnDimension('D')->setWidth(10);
$objActSheet->getColumnDimension('E')->setWidth(10);
$objActSheet->getColumnDimension('F')->setWidth(10);
$objActSheet->getRowDimension('1')->setRowHeight(30);
$objActSheet->mergeCells("A1:F1")->setCellValue('A1', "[{$y}-{$m}] {$xoopsModuleConfig['school_name']} 輔導教師工作成果(當月個案填報)");

$objActSheet->setCellValue('A2', '教師編碼')
    ->setCellValue('B2', '學生年級')
    ->setCellValue('C2', '學生性別')
    ->setCellValue('D2', '個案類別')
    ->setCellValue('E2', '新案舊案')
    ->setCellValue('F2', '晤談次數');

$objActSheet->getStyle("A2:F2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFBFE9F2');

$i = 2;
foreach ($consult['data_arr'] as $m => $data) {
    foreach ($data as $stu_id => $stu) {
        $times = sizeof($stu);
        $i++;
        $consult_kind = substr($stu[0]['consult_kind'], 1, 2);
        $consult_kind = is_numeric($consult_kind) ? (int) $consult_kind : $stu[0]['consult_kind'];
        $objActSheet->setCellValue("A{$i}", $consult['consult_name'])
            ->setCellValue("B{$i}", $stu[0]['stu_grade'])
            ->setCellValue("C{$i}", $stu[0]['stu_sex'])
            ->setCellValue("D{$i}", $consult_kind)
            ->setCellValue("E{$i}", '')
            ->setCellValue("F{$i}", $times);
    }
}

$objActSheet->getStyle("A2:F{$i}")->applyFromArray($styleArray);

$objActSheet->getStyle("A1:F{$i}")->getAlignment()
    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER) //垂直置中
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //水平置中

$objPHPExcel->createSheet(); //建立新的工作表，上面那三行再來一次，編號要改
$objPHPExcel->setActiveSheetIndex(1);
$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
$objActSheet->setTitle('2.相關服務'); //設定標題

$objActSheet->getColumnDimension('A')->setWidth(10);
$objActSheet->getColumnDimension('B')->setWidth(10);
$objActSheet->getColumnDimension('C')->setWidth(10);
$objActSheet->getColumnDimension('D')->setWidth(15);
$objActSheet->getColumnDimension('E')->setWidth(15);
$objActSheet->getRowDimension('1')->setRowHeight(30);
$objActSheet->mergeCells("A1:E1")->setCellValue('A1', "[{$y}-{$m}] {$xoopsModuleConfig['school_name']} 輔導教師工作成果(相關服務填報)");

$objActSheet->setCellValue('A2', '教師編碼')
    ->setCellValue('B2', '服務項目')
    ->setCellValue('C2', '對象')
    ->setCellValue('D2', '服務人次(男)')
    ->setCellValue('E2', '服務人次(女)');

$objActSheet->getStyle("A2:E2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFBFE9F2');

$consult_stu = [];
foreach ($consult['data_arr'] as $m => $data) {
    foreach ($data as $stu_id => $stu) {
        $stu_grade = $stu[0]['stu_grade'];
        $stu_sex = $stu[0]['stu_sex'];
        $consult_stu[$stu_grade][$stu_sex]++;
    }
}

$i = 2;
foreach ($consult_stu as $stu_grade => $stu_grade_arr) {
    foreach ($consult_stu as $stu_grade => $stu_sex) {

        $i++;
        $objActSheet->setCellValue("A{$i}", $consult['consult_name'])
            ->setCellValue("B{$i}", 11)
            ->setCellValue("C{$i}", $stu_grade)
            ->setCellValue("D{$i}", (int) $stu_sex['男'])
            ->setCellValue("E{$i}", (int) $stu_sex['女']);
    }
}

$objActSheet->getStyle("A2:E{$i}")->applyFromArray($styleArray);

$objActSheet->getStyle("A1:E{$i}")->getAlignment()
    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER) //垂直置中
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //水平置中

$objPHPExcel->setActiveSheetIndex(0);

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
