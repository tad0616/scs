<?php
use Xmf\Request;
use XoopsModules\Scs\Scs_consult;
use XoopsModules\Scs\Scs_students;
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
$op = Request::getString('op');
$stu_id = Request::getString('stu_id');
$start = Request::getString('start');
$end = Request::getString('end');

if (empty($stu_id)) {
    redirect_header($_SERVER['HTTP_REFERER'], 3, '未指定學生');
}

Tools::chk_consult_power(__FILE__, __LINE__, 'download', $stu_id);

$stu = Scs_students::get($stu_id);
$stu_all_data = Scs_consult::get_all('', $stu_id, $start, $end);

$pdf_title = "個別輔導表";

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

$pdf->Cell(12, $col_h['行高'], '班級', 'TB', 0, "C", false);
$pdf->Cell(8, $col_h['行高'], '座號', 'TB', 0, "C", false);
$pdf->Cell(18, $col_h['行高'], '姓名', 'TB', 0, "C", false);
$pdf->Cell(20, $col_h['行高'], "會談日期", 'TB', 0, "C", false);
$pdf->Cell(18, $col_h['行高'], '會談時間', 'TB', 0, "C", false);
$pdf->Cell(18, $col_h['行高'], '輔導員', 'TB', 0, "C", false);
$pdf->Cell(18, $col_h['行高'], '來談動機', 'TB', 0, "C", false);
$pdf->Cell(41, $col_h['行高'], '問題類別', 'TB', 0, "C", false);
// $pdf->Cell(46, $col_h['行高'], '主要原因', 'TB', 0, "C", false);
$pdf->Cell(41, $col_h['行高'], '處理方式', 'TB', 1, "C", false);

foreach ($stu_all_data as $c) {

    if (Tools::chk_consult_power(__FILE__, __LINE__, 'show', $stu_id, $c['consult_id'], $c['consult_uid'], 'return')) {
        $pdf->Cell(12, $col_h['行高'], "{$c['stu_grade']}-{$c['stu_class']}", 'TB', 0, "C", false);
        $pdf->Cell(8, $col_h['行高'], $c['stu_seat_no'], 'TB', 0, "C", false);
        $pdf->Cell(18, $col_h['行高'], $c['stu_name'], 'TB', 0, "C", false);
        $pdf->Cell(20, $col_h['行高'], $c['consult_cdate'], 'TB', 0, "C", false);
        $pdf->Cell(18, $col_h['行高'], $c['consult_start'], 'TB', 0, "C", false);
        $pdf->Cell(18, $col_h['行高'], $c['consult_name'], 'TB', 0, "C", false);
        $pdf->Cell(18, $col_h['行高'], $c['consult_motivation'], 'TB', 0, "C", false);
        $pdf->Cell(41, $col_h['行高'], $c['consult_kind'], 'TB', 0, "C", false);
        // $pdf->Cell(46, $col_h['行高'], '', 'TB', 0, "C", false);
        $pdf->Cell(41, $col_h['行高'], $c['consult_method'], 'TB', 1, "C", false);

        $pdf->Cell(18, $col_h['行高'], '主要原因：', 0, 0, "C", false);
        // $pdf->MultiCell(176, $col_h['行高'], $c['consult_reason'], 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', false);
        $pdf->Cell(176, $col_h['行高'], $c['consult_reason'], 0, 1, "L", false);

        $pdf->Cell(18, $col_h['行高'], '會談紀錄：', 0, 0, "C", false);
        $pdf->MultiCell(176, $col_h['行高'], $c['consult_note'], 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', false);
    }
}

$date = $start_txt = $end_txt = "";
if ($start) {
    $start_txt = "{$start}起";
}

if ($end) {
    $end_txt = "{$end}止";
}

if ($start or $end) {
    $date = "（{$start_txt}{$end_txt}）";
}

$pdf->Output(" {$pdf_title}-{$stu['stu_name']}{$date}.pdf", "D");
// $pdf->Output();
