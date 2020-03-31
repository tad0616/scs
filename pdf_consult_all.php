<?php
use XoopsModules\Scs\Scs_consult;
use XoopsModules\Scs\Tools;
use XoopsModules\Tadtools\Utility;
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

require_once XOOPS_ROOT_PATH . '/modules/tadtools/tcpdf/tcpdf.php';

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$consult_uid = system_CleanVars($_REQUEST, 'consult_uid', '', 'string');
$year = system_CleanVars($_REQUEST, 'year', '', 'string');
$month = system_CleanVars($_REQUEST, 'month', '', 'string');

if (empty($consult_uid)) {
    redirect_header($_SERVER['HTTP_REFERER'], 3, '未指定教師');
}

Tools::chk_consult_power('statistics', '', '', $consult_uid);

$consult = Scs_consult::statistics_by_month($consult_uid, $year, $month, 'return');

$pdf_title = "個別諮商期末報表";

$pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8', false);
$pdf->setPrintHeader(false); //不要頁首
$pdf->setPrintFooter(false); //不要頁尾
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM); //設定自動分頁
$pdf->setFontSubsetting(true); //產生字型子集（有用到的字才放到文件中）

$col_w['文件寬'] = 210;
$col_w['左邊界'] = 8;
$col_w['右邊界'] = 8;
$col_h['行高'] = 7;

$pdf->SetTopMargin(10);
$pdf->SetLeftMargin($col_w['左邊界']);
$pdf->SetAutoPageBreak('off');
$pdf->AddPage('P', 'A4');

$pdf->SetFont('twkai98_1', 'B', 20);
$pdf->Cell(180, 10, $xoopsModuleConfig['school_name'], 0, 1, "C", false, '', 1);
$pdf->SetFont('twkai98_1', 'B', 16);
$pdf->Cell(180, 10, $pdf_title, 0, 1, "C", false, '', 1);
$pdf->SetFont('twkai98_1', '', 11);

$pdf->Cell(194, $col_h['行高'], "輔導教師：{$consult['consult_name']}", 1, 1, "L", false);

$pdf->Cell(9, $col_h['行高'], '月份', 1, 0, "C", false);
$pdf->Cell(13, $col_h['行高'], '班級', 1, 0, "C", false);
$pdf->Cell(9, $col_h['行高'], '座號', 1, 0, "C", false);
$pdf->Cell(21, $col_h['行高'], "姓名", 1, 0, "C", false);
$pdf->Cell(19, $col_h['行高'], '會談日期', 1, 0, "C", false);
$pdf->Cell(19, $col_h['行高'], '會談日期', 1, 0, "C", false);
$pdf->Cell(19, $col_h['行高'], '會談日期', 1, 0, "C", false);
$pdf->Cell(19, $col_h['行高'], '會談日期', 1, 0, "C", false);
$pdf->Cell(19, $col_h['行高'], '會談日期', 1, 0, "C", false);
$pdf->Cell(19, $col_h['行高'], '會談日期', 1, 0, "C", false);
$pdf->Cell(19, $col_h['行高'], '會談日期', 1, 0, "C", false);
$pdf->Cell(9, $col_h['行高'], '次數', 1, 1, "C", false);

foreach ($consult['data_arr'] as $c) {
    $pdf->Cell(9, $col_h['行高'], $c['month'], 1, 0, "C", false);
    $pdf->Cell(13, $col_h['行高'], "{$c['stu_grade']}-{$c['stu_class']}", 1, 0, "C", false);
    $pdf->Cell(9, $col_h['行高'], $c['stu_seat_no'], 1, 0, "C", false);
    $pdf->Cell(21, $col_h['行高'], $c['stu_name'], 1, 0, "C", false);

    $times = sizeof($c['stu_consult']);
    foreach ($c['stu_consult'] as $stu_id => $stu) {
        $pdf->Cell(19, $col_h['行高'], $c['consult_cdate'], 1, 0, "C", false);
    }
    $need_times = 7 - $times;
    if ($need_times) {
        for ($i = 0; $i < $need_times; $i++) {
            $pdf->Cell(19, $col_h['行高'], '', 1, 0, "C", false);
        }
    }

    $pdf->Cell(9, $col_h['行高'], $consult['times'], 1, 1, "C", false);
}

$pdf_title = iconv("UTF-8", "Big5", $pdf_title . "-{$consult['consult_name']}");
// $pdf->Output($pdf_title . '.pdf', "D");
$pdf->Output();
