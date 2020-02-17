<?php
use XoopsModules\Scs\Scs_brother_sister;
use XoopsModules\Scs\Scs_general;
use XoopsModules\Scs\Scs_guardian;
use XoopsModules\Scs\Scs_parents;
use XoopsModules\Scs\Scs_students;
use XoopsModules\Tadtools\TadUpFiles;
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
if (!empty($_SESSION['stu_id'])) {
    header("location: index.php");
    exit;
}
require_once XOOPS_ROOT_PATH . '/modules/tadtools/tcpdf/tcpdf.php';

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$stu_id = system_CleanVars($_REQUEST, 'stu_id', '', 'stu_id');

$general = Scs_general::get($stu_id);
$stu = Scs_students::get($stu_id);
$parents = Scs_parents::get($stu_id);
$guardian = Scs_guardian::get($stu_id);
$brother_sister = Scs_brother_sister::get($stu_id);

$TadUpFiles = new TadUpFiles("scs");
$TadUpFiles->set_col("stu_id", $stu_id);
$stu['photo'] = $TadUpFiles->get_pic_file('images', 'url');

if (empty($stu)) {
    redirect_header($_SERVER['HTTP_REFERER'], 3, '無資料');
}

$pdf_title = "{$xoopsModuleConfig['school_name']}綜合資料紀錄表(A)";

$pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8', false);
$pdf->setPrintHeader(false); //不要頁首
$pdf->setPrintFooter(false); //不要頁尾
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM); //設定自動分頁
$pdf->setFontSubsetting(true); //產生字型子集（有用到的字才放到文件中）

$w['文件寬'] = 210;
$w['左邊界'] = 5;
$w['右邊界'] = 5;

$pdf->SetTopMargin(0);
$pdf->SetLeftMargin($w['左邊界']);
$pdf->SetAutoPageBreak('off');
$pdf->AddPage('P', 'A4');

$pdf->SetFont('twkai98_1', 'B', 18);
$pdf->Cell(180, 10, $pdf_title, 0, 1, "C");

$cell_10 = 10;
$y['最上列'] = $pdf->getY();
$pdf->SetFont('twkai98_1', '', 12);
// 左上第一列的標題寬
$w['學號欄'] = 25;
// 左上第一列的值寬
$w['學號值'] = 55;
$w['學號欄1'] = 15;
$w['學號值1'] = $w['學號值'] - $w['學號欄'] - $w['學號欄1'];
$pdf->Cell($w['學號欄'], $cell_10, '學    號', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['學號值'], $cell_10, $stu['stu_no'], 1, 1, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['學號欄'], $cell_10, '姓    名', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['學號欄'], $cell_10, $stu['stu_name'], 1, 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['學號欄1'], $cell_10, '性別', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['學號值1'], $cell_10, $stu['stu_sex'], 1, 1, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['學號欄'], $cell_10, '初填日期', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['學號值'], $cell_10, $general[1]['fill_date'], 1, 1, "C");

// 補個粗框線
$pdf->setXY($w['左邊界'], $y['最上列']);
$w['學號框'] = $w['學號欄'] + $w['學號值'];
$h['學號框'] = $cell_10 * 3;
$pdf->SetLineWidth(0.5);
$pdf->Cell($w['學號框'], $h['學號框'], '', 1, 0, "C");
$pdf->SetLineWidth(0.2);

// 計算班級的x位置
$x['班級左'] = $w['左邊界'] + $w['學號欄'] + $w['學號值'];
$pdf->setXY($x['班級左'], $y['最上列']);
$cell_6 = 6;
// 班級寬
$w['班級寬'] = 18;
// 座號寬
$w['座號寬'] = 12;
// 導師寬
$w['導師寬'] = 20;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['班級寬'], $cell_6, '班級', 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, '座號', 1, 0, "C");
$pdf->Cell($w['班級寬'], $cell_6, '班級', 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, '座號', 1, 0, "C");
$pdf->Cell($w['導師寬'], $cell_6, '導師姓名', 1, 1, "C");

$pdf->setX(85);
$pdf->SetTextColor(0, 0, 255);
$stu_grade_class = !empty($general[1]['stu_class']) ? "{$general[1]['stu_grade']}-{$general[1]['stu_class']}" : '';
$pdf->Cell($w['班級寬'], $cell_6, $stu_grade_class, 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, $general[1]['stu_seat_no'], 1, 0, "C");
$pdf->Cell($w['班級寬'], $cell_6, $stu_grade_class, 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, $general[1]['stu_seat_no'], 1, 0, "C");
$pdf->Cell($w['導師寬'], $cell_6, $general[1]['class_tea'], 1, 1, "C");

$pdf->setX(85);
$stu_grade_class = !empty($general[2]['stu_class']) ? "{$general[2]['stu_grade']}-{$general[2]['stu_class']}" : '';
$pdf->Cell($w['班級寬'], $cell_6, $stu_grade_class, 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, $general[2]['stu_seat_no'], 1, 0, "C");
$pdf->Cell($w['班級寬'], $cell_6, $stu_grade_class, 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, $general[2]['stu_seat_no'], 1, 0, "C");
$pdf->Cell($w['導師寬'], $cell_6, $general[2]['class_tea'], 1, 1, "C");

$pdf->setX(85);
$stu_grade_class = !empty($general[3]['stu_class']) ? "{$general[3]['stu_grade']}-{$general[3]['stu_class']}" : '';
$pdf->Cell($w['班級寬'], $cell_6, $stu_grade_class, 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, $general[3]['stu_seat_no'], 1, 0, "C");
$pdf->Cell($w['班級寬'], $cell_6, $stu_grade_class, 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, $general[3]['stu_seat_no'], 1, 0, "C");
$pdf->Cell($w['導師寬'], $cell_6, $general[3]['class_tea'], 1, 1, "C");

$pdf->setX(85);
$stu_grade_class = !empty($general[4]['stu_class']) ? "{$general[4]['stu_grade']}-{$general[4]['stu_class']}" : '';
$pdf->Cell($w['班級寬'], $cell_6, $stu_grade_class, 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, $general[4]['stu_seat_no'], 1, 0, "C");
$pdf->Cell($w['班級寬'], $cell_6, $stu_grade_class, 1, 0, "C");
$pdf->Cell($w['座號寬'], $cell_6, $general[4]['stu_seat_no'], 1, 0, "C");
$pdf->Cell($w['導師寬'], $cell_6, $general[4]['class_tea'], 1, 1, "C");

$y['概況列'] = $pdf->getY();

// 補個粗框線
$pdf->setXY($x['班級左'], $y['最上列']);
$w['班級框'] = ($w['班級寬'] + $w['座號寬']) * 2 + $w['導師寬'];
$h['班級框'] = $cell_6 * 5;
$pdf->SetLineWidth(0.5);
$pdf->Cell($w['班級框'], $h['班級框'], '', 1, 0, "C");

// 相片
$x['相片左'] = $x['班級左'] + $w['班級框'];
$pdf->setXY($x['相片左'], $y['最上列']);
$w['相片框'] = $w['文件寬'] - $w['左邊界'] - $w['學號框'] - $w['班級框'] - $w['右邊界'];
$h['相片框'] = $cell_6 * 8;
$pdf->SetLineWidth(0.5);
if ($stu['photo']) {
    $pdf->Image($stu['photo'], $x['相片左'], $y['最上列'], $w['相片框'], $h['相片框'], '', '', '', true, 600, '', false, false, 0, true, false, false, false);
}
$pdf->Cell($w['相片框'], $h['相片框'], '', 1, 1, "C");

// $pdf->SetLineWidth(0.2);

// 一、本人概況
$w['概況框'] = 7;
$h['概況框'] = $cell_6 * 10;
$pdf->setY($y['概況列']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['概況框'], $h['概況框'], '一 、 本  人  概  況', 1, 'C', false, 0, '', '', true, 0, false, true, $h['概況框'], 'M');

// $pdf->MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false );

// 1.身份證統一編號
$pdf->SetLineWidth(0.2);
$w['編號欄'] = 6;
$w['概況欄'] = 30;
$w['概況值'] = $w['文件寬'] - $w['左邊界'] - $w['概況框'] - $w['編號欄'] - $w['概況欄'] - $w['相片框'] - $w['右邊界'];
$w['概況欄1'] = 20;
$w['概況值1'] = 20;
$w['剩餘寬'] = $w['概況值'] - ($w['概況欄1'] + $w['概況值1']) * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '1.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '身份證統一編號', 'TB', 0, "L", false, '', 4);
// $pdf->MultiCell($w['概況欄'], $cell_6, '身份證統一編號', 1, 'J', false, 0, '', '', true, 1, false, true, $cell_6, 'M', true);

$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $stu['stu_pid'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['概況欄1'], $cell_6, '身份', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['概況值1'], $cell_6, $stu['stu_identity'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['概況欄1'], $cell_6, '僑居地', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['概況值1'], $cell_6, $stu['stu_residence'], 'TB', 1, "C");

// 2.出生
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$x['概況欄'] = $w['左邊界'] + $w['概況框'];
$w['剩餘寬'] = $w['概況值'] - ($w['概況欄1'] * 2) - $w['概況值1'];
$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $cell_6, '2.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '出生', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['概況欄1'], $cell_6, '出生地', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['概況值1'], $cell_6, $stu['stu_birth_place'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['概況欄1'], $cell_6, '生日', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $stu['tw_birthday'], 'TB', 1, "C");

// 3.血型
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$w['血型寬'] = 30;
$w['剩餘寬'] = $w['概況值'] - $w['概況欄1'] - $w['血型寬'];
$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $cell_6, '3.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '血型', 'TB', 0, "L", false, '', 4);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['血型寬'], $cell_6, $stu['stu_blood'], 1, 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['概況欄1'], $cell_6, '宗教', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $stu['stu_religion'], 1, 1, "C");

// 4.通訊處
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$w['內標題'] = 14;
$w['電話欄'] = 7;
$w['電話值'] = 35;
$h['通訊處'] = $cell_6 * 2;
$w['概況值'] = $w['文件寬'] - $w['左邊界'] - $w['概況框'] - $w['編號欄'] - $w['概況欄'] - $w['右邊界'];
$w['剩餘寬'] = $w['概況值'] - $w['內標題'] - $w['電話欄'] - $w['電話值'];
$x['概況值'] = $w['左邊界'] + $w['概況框'] + $w['編號欄'] + $w['概況欄'];
$y['通訊處'] = $pdf->getY();
$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $h['通訊處'], '4.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $h['通訊處'], '通訊處', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['內標題'], $cell_6, '永久：', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, "{$stu['stu_residence_zip']}{$stu['stu_residence_county']}{$stu['stu_residence_city']}{$stu['stu_residence_addr']}", 'TB', 0, "L");
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['電話欄'], $h['通訊處'], '電話', 1, 'C', false, 0, '', '', true, 0, false, true, $h['通訊處'], 'M');
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['電話值'], $cell_6, $stu['stu_tel1'], 1, 2, "C");
$y['現在欄'] = $pdf->getY();
$pdf->Cell($w['電話值'], $cell_6, $stu['stu_tel2'], 1, 1, "C");
$pdf->SetXY($x['概況值'], $y['現在欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['內標題'], $cell_6, '現在：', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, "{$stu['stu_zip']}{$stu['stu_county']}{$stu['stu_city']}{$stu['stu_addr']}", 'TB', 2, "L");
$pdf->SetTextColor(0, 0, 0);

// 5.緊急聯絡人
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$w['姓名值'] = 22;
$w['電話值'] = 28;
$w['剩餘寬'] = $w['概況值'] - $w['姓名值'] - $w['電話值'] - $w['內標題'] * 3;
$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $cell_6, '5.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '緊急聯絡人', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['內標題'], $cell_6, '姓名：', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['姓名值'], $cell_6, $guardian['guardian_name'], 'TB', 0, "L");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['內標題'], $cell_6, '住址：', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $guardian['guardian_addr'], 'TB', 0, "L");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['內標題'], $cell_6, '電話：', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['電話值'], $cell_6, $guardian['guardian_tel'], 'TBR', 1, "L");

// 6.學歷及就學
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$h['就學高'] = $cell_6 * 2;
$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $h['就學高'], '6.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $h['就學高'], '學歷及就學', 'TB', 0, "L", false, '', 4);

$pdf->writeHTMLCell($w['概況值'], $h['就學高'], '', '', "民國 <span style=\"color: blue\">{$stu['stu_education']['g_time']}</span> 年畢（肄）業於 <span style=\"color: blue\">{$stu['stu_education']['g_school']}</span> ，民國 <span style=\"color: blue\">{$stu['stu_education']['i_time']}</span> 年進入本校<br>
<span style=\"color: blue\">{$stu['stu_education']['o_time']}</span> 年自本校畢業，於 <span style=\"color: blue\">{$stu['stu_education']['jh_time']}</span> 年進入 <span style=\"color: blue\">{$stu['stu_education']['jh_school']}</span> 就讀", 1, 2, false, true, '', true);
// writeHTMLCell($w, $h, $x, $y, $html = '', $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);

// 7.身高及體重
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$w['身高寬'] = 12;
$w['年級寬'] = 7;
$w['剩餘寬'] = ($w['概況值'] - $w['身高寬'] * 2 - $w['年級寬'] * 6) / 6;
$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $cell_6, '7.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '身高及體重', 'TB', 0, "L", false, '', 4);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['身高寬'], $cell_6, '身高', 1, 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '一', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$stu_height = $general[1]['stu_height'] ? "{$general[1]['stu_height']}公分" : '';
$pdf->Cell($w['剩餘寬'], $cell_6, $stu_height, 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '二', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$stu_height = $general[2]['stu_height'] ? "{$general[2]['stu_height']}公分" : '';
$pdf->Cell($w['剩餘寬'], $cell_6, $stu_height, 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '三', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$stu_height = $general[3]['stu_height'] ? "{$general[3]['stu_height']}公分" : '';
$pdf->Cell($w['剩餘寬'], $cell_6, $stu_height, 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['身高寬'], $cell_6, '體重', 1, 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '一', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$stu_weight = $general[1]['stu_weight'] ? "{$general[1]['stu_weight']}公斤" : '';
$pdf->Cell($w['剩餘寬'], $cell_6, $stu_weight, 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '二', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$stu_weight = $general[2]['stu_weight'] ? "{$general[2]['stu_weight']}公斤" : '';
$pdf->Cell($w['剩餘寬'], $cell_6, $stu_weight, 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '三', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$stu_weight = $general[3]['stu_weight'] ? "{$general[3]['stu_weight']}公斤" : '';
$pdf->Cell($w['剩餘寬'], $cell_6, $stu_weight, 'TBR', 1, "C");

// 8.生理缺陷
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$w['身高寬'] = 12;
$w['年級寬'] = 7;
$w['剩餘寬'] = ($w['概況值'] - $w['編號欄'] - $w['概況欄'] - $w['年級寬'] * 4) / 4;
$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $cell_6, '8.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '生理缺陷', 'TB', 0, "L", false, '', 4);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '1.', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $stu['physiological_defect'][1], 'TB', 0, "L");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '2.', 'TBL', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $stu['physiological_defect'][2], 'TB', 0, "L");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '9.', 'TBR', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '曾患特殊疾病', 'TB', 0, "L", false, '', 4);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '1.', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $stu['special_disease'][1], 'TB', 0, "L");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '2.', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $stu['special_disease'][2], 'TBR', 1, "L");
$y['疾病值'] = $pdf->getY();

// 補個粗框線
$pdf->setXY($x['概況欄'], $y['概況列']);
$h['概況欄'] = $cell_6 * 10;
$pdf->SetLineWidth(0.5);
$pdf->Cell($w['編號欄'] + $w['概況欄'], $h['概況欄'], '', 1, 0, "C");

$pdf->setXY($x['概況值'], $y['通訊處']);
$h['疾病值'] = $cell_6 * 7;
$pdf->Cell($w['概況值'], $h['疾病值'], '', 'RB', 0, "C");
// $pdf->SetLineWidth(0.2);

// 二、家長狀況
$w['家長框'] = 7;
$h['家長框'] = $cell_6 * 20;
$pdf->setY($y['疾病值']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['家長框'], $h['家長框'], '二     、    家        長        狀        況', 1, 'C', false, 0, '', '', true, 0, false, true, $h['家長框'], 'M');
$y['家長框'] = $pdf->getY() + $h['家長框'];
// $pdf->MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false );

// 10.直系血親
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$h['直系欄'] = $cell_6 * 2;
$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $h['直系欄'], '10.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $h['直系欄'], '直系血親', 'TB', 0, "L", false, '', 4);
$x['直系欄'] = $pdf->GetX();
$y['直系欄'] = $pdf->GetY();
$pdf->writeHTMLCell($w['概況值'], $h['直系欄'], '', '', "父 <span style=\"color: blue\">{$parents['f']['parent_name']}</span> [<span style=\"color: blue\">{$parents['f']['parent_survive']}</span>] <span style=\"color: blue\">{$parents['f']['parent_year']}</span> 年生 祖父 <span style=\"color: blue\">{$parents['f']['parent_gf_name']}</span> [<span style=\"color: blue\">{$parents['f']['parent_gf_survive']}</span>]<br>
母 <span style=\"color: blue\">{$parents['m']['parent_name']}</span> [<span style=\"color: blue\">{$parents['m']['parent_survive']}</span>] <span style=\"color: blue\">{$parents['m']['parent_year']}</span> 年生 祖母 <span style=\"color: blue\">{$parents['m']['parent_gm_name']}</span> [<span style=\"color: blue\">{$parents['m']['parent_gm_survive']}</span>] ", 1, 1, false, true, '', true);
// writeHTMLCell($w, $h, $x, $y, $html = '', $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);

// 11.父母教育程度
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$w['父母寬'] = 10;
$w['剩餘寬'] = ($w['概況值'] - ($w['父母寬'] * 2)) / 2;
$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $cell_6, '11.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '父母教育程度', 'TB', 0, "L", false, '', 4);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['父母寬'], $cell_6, '父', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $parents['f']['parent_edu'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['父母寬'], $cell_6, '母', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $parents['m']['parent_edu'], 'TBR', 2, "C");

// 12.家長
$w['稱謂寬'] = 10;
$w['姓名寬'] = 25;
$w['職業寬'] = 20;
$w['電話寬'] = 25;
$w['手機寬'] = 25;
$h['家長欄'] = $cell_6 * 4;
$w['剩餘寬'] = $w['概況值'] - $w['稱謂寬'] - $w['姓名寬'] - $w['職業寬'] - $w['電話寬'] - $w['手機寬'] - $w['家長欄'];
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $h['家長欄'], '12.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $h['家長欄'], '家長', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['稱謂寬'], $cell_6, '稱謂', 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, '姓名', 1, 0, "C");
$pdf->Cell($w['職業寬'], $cell_6, '職業', 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, '工作機構與職稱', 1, 0, "C");
$pdf->Cell($w['電話寬'], $cell_6, '公司電話', 1, 0, "C");
$pdf->Cell($w['手機寬'], $cell_6, '手機', 1, 1, "C");

$pdf->SetTextColor(0, 0, 255);
$pdf->SetX($x['概況值']);
$pdf->Cell($w['稱謂寬'], $cell_6, '父', 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, $parents['f']['parent_name'], 1, 0, "C");
$pdf->Cell($w['職業寬'], $cell_6, $parents['f']['parent_job'], 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, $parents['f']['parent_company'], 1, 0, "C");
$pdf->Cell($w['電話寬'], $cell_6, $parents['f']['parent_company_tel'], 1, 0, "C");
$pdf->Cell($w['手機寬'], $cell_6, $parents['f']['parent_phone'], 1, 1, "C");

$pdf->SetX($x['概況值']);
$pdf->Cell($w['稱謂寬'], $cell_6, '母', 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, $parents['m']['parent_name'], 1, 0, "C");
$pdf->Cell($w['職業寬'], $cell_6, $parents['m']['parent_job'], 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, $parents['m']['parent_company'], 1, 0, "C");
$pdf->Cell($w['電話寬'], $cell_6, $parents['m']['parent_company_tel'], 1, 0, "C");
$pdf->Cell($w['手機寬'], $cell_6, $parents['m']['parent_phone'], 1, 1, "C");

$w['電郵寬'] = 15;
$w['剩餘寬'] = ($w['概況值'] - $w['電郵寬'] * 2) / 2;
$pdf->SetX($x['概況值']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['電郵寬'], $cell_6, '父電郵', '1', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $parents['f']['parent_email'], '1', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['電郵寬'], $cell_6, '母電郵', '1', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $parents['m']['parent_email'], '1', 2, "C");

// 13.監護人
$w['標題寬'] = 14;
$w['姓名寬'] = 16;
$w['性別寬'] = 8;
$w['關係寬'] = 10;
$h['監護人'] = $cell_6 * 2;
$w['剩餘寬'] = $w['概況值'] - $w['標題寬'] * 4 - $w['姓名寬'] - $w['性別寬'] - $w['關係寬'];
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $h['監護人'], '13.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $h['監護人'], '監護人', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['標題寬'], $h['監護人'], '姓名', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['姓名寬'], $h['監護人'], $guardian['guardian_name'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['標題寬'], $h['監護人'], '性別', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['性別寬'], $h['監護人'], $guardian['guardian_sex'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['標題寬'], $h['監護人'], '關係', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['關係寬'], $h['監護人'], $guardian['guardian_title'], 'TB', 0, "C");
$x['通訊處'] = $pdf->getX();
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['標題寬'], $cell_6, '通訊處', 'T', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $guardian['guardian_addr'], 'TR', 1, "L");
$pdf->setX($x['通訊處']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['標題寬'], $cell_6, '電  話', 'B', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $guardian['guardian_tel'], 'BR', 1, "L");

// 14.兄弟姊妹
$w['稱謂寬'] = 10;
$w['姓名寬'] = 16;
$w['出生寬'] = 10;
$w['備註寬'] = 10;
$h['兄弟欄'] = $cell_6 * 3;
$w['剩餘寬'] = ($w['概況值'] - ($w['稱謂寬'] + $w['姓名寬'] + $w['出生寬'] + $w['備註寬']) * 2) / 2;
// $x['備註欄'] = $w['概況值'] - $w['剩餘寬'];
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '14.', 'T', 0, "R", false, '', 2);
$x['稱謂欄'] = $pdf->GetX();
$pdf->Cell($w['概況欄'], $cell_6, '兄弟姊妹', 'T', 0, "L", false, '', 4);
$pdf->Cell($w['稱謂寬'], $cell_6, '稱謂', 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, '姓名', 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, '畢業（肄）學校', 1, 0, "C");
$pdf->Cell($w['出生寬'], $cell_6, '年次', 1, 0, "C");
$pdf->Cell($w['備註寬'], $cell_6, '備註', 1, 0, "C");
$x['備註欄'] = $pdf->GetX();
$pdf->Cell($w['稱謂寬'], $cell_6, '稱謂', 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, '姓名', 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, '畢業（肄）學校', 1, 0, "C");
$pdf->Cell($w['出生寬'], $cell_6, '年次', 1, 0, "C");
$pdf->Cell($w['備註寬'], $cell_6, '備註', 1, 1, "C");
// $x['稱謂欄'] = $pdf->GetX();
// $y['稱謂欄'] = $pdf->GetY();
$pdf->SetX($x['概況欄']);

$pdf->Cell($w['編號欄'], $cell_6, '', 0, 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '(按出生序填寫)', 0, 0, "L", false, '', 4);

$y['備註欄'] = $pdf->GetY();

$pdf->SetTextColor(0, 0, 255);
$pdf->SetX($x['概況值']);
$pdf->Cell($w['稱謂寬'], $cell_6, $brother_sister[1]['bs_relationship'], 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, $brother_sister[1]['bs_name'], 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, $brother_sister[1]['bs_school'], 1, 0, "C");
$pdf->Cell($w['出生寬'], $cell_6, $brother_sister[1]['bs_year'], 1, 0, "C");
$pdf->Cell($w['備註寬'], $cell_6, $brother_sister[1]['bs_note'], 1, 1, "C");

$pdf->SetX($x['概況欄']);
$pdf->Cell($w['編號欄'], $cell_6, '', 0, 0, "R", false, '', 2);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell($w['概況欄'], $cell_6, '', '', "我排行第 <span style=\"color: blue\">{$brother_sister['my_rank']}</span>", 0, 0, false, true, '', true);
$pdf->SetTextColor(0, 0, 255);
$pdf->SetX($x['概況值']);
$pdf->Cell($w['稱謂寬'], $cell_6, $brother_sister[2]['bs_relationship'], 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, $brother_sister[2]['bs_name'], 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, $brother_sister[2]['bs_school'], 1, 0, "C");
$pdf->Cell($w['出生寬'], $cell_6, $brother_sister[2]['bs_year'], 1, 0, "C");
$pdf->Cell($w['備註寬'], $cell_6, $brother_sister[2]['bs_note'], 1, 1, "C");

$pdf->SetX($x['概況值']);
$pdf->Cell($w['稱謂寬'], $cell_6, $brother_sister[3]['bs_relationship'], 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, $brother_sister[3]['bs_name'], 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, $brother_sister[3]['bs_school'], 1, 0, "C");
$pdf->Cell($w['出生寬'], $cell_6, $brother_sister[3]['bs_year'], 1, 0, "C");
$pdf->Cell($w['備註寬'], $cell_6, $brother_sister[3]['bs_note'], 1, 1, "C");

$pdf->SetX($x['備註欄']);
$pdf->SetY($y['備註欄']);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetTextColor(0, 0, 255);
$pdf->SetX($x['備註欄']);
$pdf->Cell($w['稱謂寬'], $cell_6, $brother_sister[4]['bs_relationship'], 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, $brother_sister[4]['bs_name'], 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, $brother_sister[4]['bs_school'], 1, 0, "C");
$pdf->Cell($w['出生寬'], $cell_6, $brother_sister[4]['bs_year'], 1, 0, "C");
$pdf->Cell($w['備註寬'], $cell_6, $brother_sister[4]['bs_note'], 1, 1, "C");

$pdf->SetX($x['備註欄']);
$pdf->Cell($w['稱謂寬'], $cell_6, $brother_sister[5]['bs_relationship'], 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, $brother_sister[5]['bs_name'], 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, $brother_sister[5]['bs_school'], 1, 0, "C");
$pdf->Cell($w['出生寬'], $cell_6, $brother_sister[5]['bs_year'], 1, 0, "C");
$pdf->Cell($w['備註寬'], $cell_6, $brother_sister[5]['bs_note'], 1, 1, "C");

$pdf->SetX($x['備註欄']);
$pdf->Cell($w['稱謂寬'], $cell_6, $brother_sister[6]['bs_relationship'], 1, 0, "C");
$pdf->Cell($w['姓名寬'], $cell_6, $brother_sister[6]['bs_name'], 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, $brother_sister[6]['bs_school'], 1, 0, "C");
$pdf->Cell($w['出生寬'], $cell_6, $brother_sister[6]['bs_year'], 1, 0, "C");
$pdf->Cell($w['備註寬'], $cell_6, $brother_sister[6]['bs_note'], 1, 1, "C");

// 15.父母關係
$w['年級寬'] = 8;
$w['剩餘寬'] = ($w['概況值'] - $w['年級寬'] * 3) / 3;
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '15.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '父母關係', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['年級寬'], $cell_6, '一', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[1]['parental_relationship'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '二', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[2]['parental_relationship'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '三', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[3]['parental_relationship'], 'TBR', 2, "C");

// 16.家庭氣氛
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '16.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '家庭氣氛', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['年級寬'], $cell_6, '一', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[1]['family_atmosphere'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '二', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[2]['family_atmosphere'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '三', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[3]['family_atmosphere'], 'TBR', 2, "C");

// 17.父母管教方式
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '17.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '父母管教方式', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['年級寬'], $cell_6, '一', 'TB', 0, "C");
$v1 = empty($general[1]['father_discipline']) ? '' : "父：<span style=\"color: blue\">{$general[1]['father_discipline']}</span> 母：<span style=\"color: blue\">{$general[1]['mother_discipline']}</span>";
$pdf->writeHTMLCell($w['剩餘寬'], $cell_6, '', '', $v1, 'TB', 0, false, true, '', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '二', 'TB', 0, "C");
$v2 = empty($general[2]['father_discipline']) ? '' : "父：<span style=\"color: blue\">{$general[2]['father_discipline']}</span> 母：<span style=\"color: blue\">{$general[2]['mother_discipline']}</span>";
$pdf->writeHTMLCell($w['剩餘寬'], $cell_6, '', '', $v2, 'TB', 0, false, true, '', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '三', 'TB', 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, $general[3]['father_discipline'], 'TBR', 2, "C");
$v3 = empty($general[3]['father_discipline']) ? '' : "父：<span style=\"color: blue\">{$general[3]['father_discipline']}</span> 母：<span style=\"color: blue\">{$general[3]['mother_discipline']}</span>";
$pdf->writeHTMLCell($w['剩餘寬'], $cell_6, '', '', $v3, 'TBR', 0, false, true, '', true);

// 18.居住環境
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '18.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '居住環境', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['年級寬'], $cell_6, '一', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[1]['environment'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '二', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[2]['environment'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '三', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[3]['environment'], 'TBR', 2, "C");

// 19.本人住宿
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '19.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '本人住宿', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['年級寬'], $cell_6, '一', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[1]['accommodation'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '二', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[2]['accommodation'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '三', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[3]['accommodation'], 'TBR', 2, "C");

// 20.經濟狀況
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '20.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '經濟狀況', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['年級寬'], $cell_6, '一', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[1]['economic'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '二', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[2]['economic'], 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '三', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($w['剩餘寬'], $cell_6, $general[3]['economic'], 'TBR', 2, "C");

// 21.每週零用錢約
$pdf->SetX($x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '21.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '每週零用錢約', 'TB', 0, "L", false, '', 4);
$pdf->Cell($w['年級寬'], $cell_6, '一', 'TB', 0, "C");
$v1 = empty($general[1]['money']) ? '' : "<span style=\"color: blue\">{$general[1]['money']}</span> 我覺得 <span style=\"color: blue\">{$general[1]['feel']}</span>";
$pdf->writeHTMLCell($w['剩餘寬'], $cell_6, '', '', $v1, 'TB', 0, false, true, '', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '二', 'TB', 0, "C");
$v2 = empty($general[2]['money']) ? '' : "<span style=\"color: blue\">{$general[2]['money']}</span> 我覺得 <span style=\"color: blue\">{$general[2]['feel']}</span>";
$pdf->writeHTMLCell($w['剩餘寬'], $cell_6, '', '', $v2, 'TB', 0, false, true, '', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $cell_6, '三', 'TB', 0, "C");
$v3 = empty($general[3]['money']) ? '' : "<span style=\"color: blue\">{$general[3]['money']}</span> 我覺得 <span style=\"color: blue\">{$general[3]['feel']}</span>";
$pdf->writeHTMLCell($w['剩餘寬'], $cell_6, '', '', $v3, 'TBR', 2, false, true, '', true);

// 補個粗框線
$pdf->setXY($x['概況欄'], $y['直系欄']);
$pdf->SetLineWidth(0.5);
$pdf->Cell($w['編號欄'] + $w['概況欄'], $h['家長框'], '', 1, 0, "C");
$pdf->Cell($w['概況值'], $h['家長框'], '', 1, 1, "C");

// 三、學習狀況
$w['學習框'] = 7;
$h['學習框'] = $cell_6 * 10;
$pdf->setY($y['家長框']);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($w['學習框'], $h['學習框'], '三 、 學  習  狀  況', 1, 'C', false, 0, '', '', true, 0, false, true, $h['學習框'], 'M');
// $pdf->MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false );

// 22.最喜歡的學科
$pdf->SetLineWidth(0.2);
$pdf->SetX($x['概況欄']);
$h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $h['學科欄'], '22.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $h['學科欄'], '最喜歡的學科', 'TB', 0, "L", false, '', 4);
$y['學科欄'] = $pdf->GetY();
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '一年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$favorite_subject = implode('、', $general[1]['favorite_subject']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $favorite_subject, '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '二年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$favorite_subject = implode('、', $general[2]['favorite_subject']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $favorite_subject, '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '三年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$favorite_subject = implode('、', $general[3]['favorite_subject']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $favorite_subject, '1', 'C', false, 1, '', '', true, 0, false, true, $h['學科欄'], 'M');

// 23.最感困難的學科
$pdf->SetLineWidth(0.2);
$pdf->SetX($x['概況欄']);
$h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $h['學科欄'], '23.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $h['學科欄'], '最感困難的學科', 'TB', 0, "L", false, '', 4);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '一年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$difficult_subject = implode('、', $general[1]['difficult_subject']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $difficult_subject, '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '二年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$difficult_subject = implode('、', $general[2]['difficult_subject']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $difficult_subject, '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '三年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$difficult_subject = implode('、', $general[3]['difficult_subject']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $difficult_subject, '1', 'C', false, 1, '', '', true, 0, false, true, $h['學科欄'], 'M');

// 24.特殊專長
$pdf->SetLineWidth(0.2);
$pdf->SetX($x['概況欄']);
$h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $h['學科欄'], '24.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $h['學科欄'], '特殊專長', 'TB', 0, "L", false, '', 4);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '一年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$expertise = implode('、', $general[1]['expertise']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $expertise, '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '二年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$expertise = implode('、', $general[2]['expertise']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $expertise, '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '三年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$expertise = implode('、', $general[3]['expertise']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $expertise, '1', 'C', false, 1, '', '', true, 0, false, true, $h['學科欄'], 'M');

// 25.休閒興趣
$pdf->SetLineWidth(0.2);
$pdf->SetX($x['概況欄']);
$h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $h['學科欄'], '25.', 'TB', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $h['學科欄'], '休閒興趣', 'TB', 0, "L", false, '', 4);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '一年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$interest = implode('、', $general[1]['interest']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $interest, '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '二年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$interest = implode('、', $general[2]['interest']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $interest, '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '三年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$pdf->SetTextColor(0, 0, 255);
$interest = implode('、', $general[3]['interest']);
$pdf->MultiCell($w['剩餘寬'], $h['學科欄'], $interest, '1', 'C', false, 1, '', '', true, 0, false, true, $h['學科欄'], 'M');

// 26.參加校內社團擔任班級幹部
$pdf->SetLineWidth(0.2);
$pdf->SetX($x['概況欄']);
$h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['編號欄'], $cell_6, '26.', 'T', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '參加校內社團及', 'T', 0, "L", false, '', 4);
$y['社團欄'] = $pdf->GetY() + $cell_6;
// $pdf->MultiCell($w['概況欄'], $h['學科欄'], "參加校內社團及\n擔任班級幹部", 'TB', 'L', false, 0, '', '', true, 1, false, true, $h['學科欄'], 'M', true);
$pdf->MultiCell($w['年級寬'], $h['學科欄'], '一年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$v1 = empty($general[1]['club']) ? '' : "社團：<span style=\"color: blue\">{$general[1]['club']}</span><br>幹部：<span style=\"color: blue\">{$general[1]['cadre']}</span>";
$pdf->writeHTMLCell($w['剩餘寬'], $h['學科欄'], '', '', $v1, '1', 0, false, true, '', true);

$pdf->MultiCell($w['年級寬'], $h['學科欄'], '二年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$v2 = empty($general[2]['club']) ? '' : "社團：<span style=\"color: blue\">{$general[2]['club']}</span><br>幹部：<span style=\"color: blue\">{$general[2]['cadre']}</span>";
$pdf->writeHTMLCell($w['剩餘寬'], $h['學科欄'], '', '', $v2, '1', 0, false, true, '', true);

$pdf->MultiCell($w['年級寬'], $h['學科欄'], '三年', '1', 'C', false, 0, '', '', true, 0, false, true, $h['學科欄'], 'M');
$v3 = empty($general[3]['club']) ? '' : "社團：<span style=\"color: blue\">{$general[3]['club']}</span><br>幹部：<span style=\"color: blue\">{$general[3]['cadre']}</span>";
$pdf->writeHTMLCell($w['剩餘寬'], $h['學科欄'], '', '', $v3, '1', 1, false, true, '', true);

$pdf->SetXY($x['概況欄'], $y['社團欄']);
$pdf->Cell($w['編號欄'], $cell_6, '', '0', 0, "R", false, '', 2);
$pdf->Cell($w['概況欄'], $cell_6, '擔任班級幹部', '0', 0, "L", false, '', 0);

// 補個粗框線
$pdf->setXY($x['概況欄'], $y['學科欄']);
$pdf->SetLineWidth(0.5);
$pdf->Cell($w['編號欄'] + $w['概況欄'], $h['學習框'], '', 1, 0, "C");
$pdf->Cell($w['概況值'], $h['學習框'], '', 1, 1, "C");

$pdf->AddPage('P', 'A4');

// 四、自傳
$pdf->setY(20);
$w['長概況'] = $w['概況欄'] + $w['概況值'];
$h['自傳框'] = $cell_6 * 17;
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['概況框'], $h['自傳框'], '四  、  自   傳', 1, 'C', false, 0, '', '', true, 0, false, true, $h['自傳框'], 'M');
// 補個粗框線
$x['瞭解我'] = $pdf->GetX();
$pdf->Cell($w['編號欄'] + $w['長概況'], $h['自傳框'], '', 1, 0, "C");
$pdf->SetLineWidth(0.2);

// 1.家中最理解我的人是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '1.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "家中最理解我的人是： <span style=\"color: blue\">{$stu['stu_autobiography']['understand']}</span> 因為 <span style=\"color: blue\">{$stu['stu_autobiography']['understand_reason']}</span>", 'TB', 2, false, true, '', true);

// 2.家中指導我做功課的人是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '2.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "家中指導我做功課的人是： <span style=\"color: blue\">{$stu['stu_autobiography']['homework']}</span>", 'TB', 2, false, true, '', true);

// 3.我在家中最怕的人是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '3.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我在家中最怕的人是： <span style=\"color: blue\">{$stu['stu_autobiography']['afraid']}</span> 因為 <span style=\"color: blue\">{$stu['stu_autobiography']['afraid_reason']}</span>", 'TB', 2, false, true, '', true);

// 4.我覺得我家的優點是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '4.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我覺得我家的優點是： <span style=\"color: blue\">{$stu['stu_autobiography']['advantage']}</span>", 'TB', 2, false, true, '', true);

// 5.我覺得我家的缺點是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '5.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我覺得我家的缺點是： <span style=\"color: blue\">{$stu['disadvantage']['afraid']}</span>", 'TB', 2, false, true, '', true);

// 6.我最要好的朋友是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '6.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我最要好的朋友是： <span style=\"color: blue\">{$stu['stu_autobiography']['friend']}</span> 他是怎樣的人？ <span style=\"color: blue\">{$stu['stu_autobiography']['friend_reason']}</span>", 'TB', 2, false, true, '', true);

// 7.我最喜歡的國小老師是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '7.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我最喜歡的國小老師是： <span style=\"color: blue\">{$stu['stu_autobiography']['teacher']}</span> 他是怎樣的人？ <span style=\"color: blue\">{$stu['stu_autobiography']['teacher_reason']}</span>", 'TB', 2, false, true, '', true);

// 8.小學老師或同學常說我是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '8.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "小學老師或同學常說我是： <span style=\"color: blue\">{$stu['stu_autobiography']['impression']}</span>", 'TB', 2, false, true, '', true);

// 9.小學時我曾在班上擔任過的職務有：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '9.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "小學時我曾在班上擔任過的職務有： <span style=\"color: blue\">{$stu['stu_autobiography']['position']}</span>", 'TB', 2, false, true, '', true);

// 10.我在小學得過的獎有：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '10.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我在小學得過的獎有： <span style=\"color: blue\">{$stu['stu_autobiography']['award']}</span>", 'TB', 2, false, true, '', true);

// 11.我國小畢業時的智育成績是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '11.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我國小畢業時的智育成績是： <span style=\"color: blue\">{$stu['stu_autobiography']['iq']}</span> 我國小畢業時的德育成績是： <span style=\"color: blue\">{$stu['stu_autobiography']['eq']}</span>", 'TB', 2, false, true, '', true);

// 12.我覺得自己的過去最滿意的是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '12.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我覺得自己的過去最滿意的是： <span style=\"color: blue\">{$stu['stu_autobiography']['satisfaction']}</span>", 'TB', 2, false, true, '', true);

// 我覺得自己的過去最失敗的是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我覺得自己的過去最失敗的是： <span style=\"color: blue\">{$stu['stu_autobiography']['failure']}</span>", 'TB', 2, false, true, '', true);

// 13.我最喜歡做的事是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '13.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我最喜歡做的事是： <span style=\"color: blue\">{$stu['stu_autobiography']['like']}</span> 因為 <span style=\"color: blue\">{$stu['stu_autobiography']['like_reason']}</span>", 'TB', 2, false, true, '', true);

// 我最不喜歡做的事是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我最不喜歡做的事是： <span style=\"color: blue\">{$stu['stu_autobiography']['dislike']}</span> 因為 <span style=\"color: blue\">{$stu['stu_autobiography']['dislike_reason']}</span>", 'TB', 2, false, true, '', true);

// 14.我排遣休閒時間的方法是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '14.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我排遣休閒時間的方法是： <span style=\"color: blue\">{$stu['stu_autobiography']['leisure']}</span>", 'TB', 2, false, true, '', true);

// 15.我最難忘的一件事是：
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['編號欄'], $cell_6, '15.', 'TB', 0, "R", false, '', 2);
$pdf->writeHTMLCell($w['長概況'], $cell_6, '', '', "我最難忘的一件事是： <span style=\"color: blue\">{$stu['stu_autobiography']['memorable']}</span>", 'TB', 1, false, true, '', true);

// 五、自我認識
$h['認識框'] = $cell_6 * 7;

$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($w['概況框'], $h['認識框'], '五、自 我 認 識', 1, 'C', false, 0, '', '', true, 0, false, true, $h['認識框'], 'M');

// 補個粗框線
$x['瞭解我'] = $pdf->GetX();
$pdf->Cell($w['編號欄'] + $w['長概況'], $h['認識框'], '', 1, 0, "C");
$pdf->SetLineWidth(0.2);

$w['年級寬'] = 20;
$w['優點寬'] = 40;
$w['改進寬'] = 40;
$w['日期寬'] = 28;
$w['剩餘寬'] = $w['編號欄'] + $w['長概況'] - $w['年級寬'] - $w['優點寬'] - $w['改進寬'] - $w['日期寬'];
$h['認識欄'] = $cell_6 * 2;
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['年級寬'], $cell_6, '年級', 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, '我的個性（如：溫和、急躁）', 1, 0, "C");
$pdf->Cell($w['優點寬'], $cell_6, '我的優點', 1, 0, "C");
$pdf->Cell($w['改進寬'], $cell_6, '我需要改進的地方', 1, 0, "C");
$pdf->Cell($w['日期寬'], $cell_6, '填寫日期', 1, 1, "C");

$pdf->SetX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $h['認識欄'], '一年級', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['認識欄'], $general[1]['stu_personality'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->MultiCell($w['優點寬'], $h['認識欄'], $general[1]['stu_advantage'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->MultiCell($w['改進寬'], $h['認識欄'], $general[1]['stu_improve'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->Cell($w['日期寬'], $h['認識欄'], $general[1]['fill_date'], 1, 1, "C");

$pdf->SetX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $h['認識欄'], '二年級', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['認識欄'], $general[2]['stu_personality'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->MultiCell($w['優點寬'], $h['認識欄'], $general[2]['stu_advantage'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->MultiCell($w['改進寬'], $h['認識欄'], $general[2]['stu_improve'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->Cell($w['日期寬'], $h['認識欄'], $general[2]['fill_date'], 1, 1, "C");

$pdf->SetX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $h['認識欄'], '三年級', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['認識欄'], $general[3]['stu_personality'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->MultiCell($w['優點寬'], $h['認識欄'], $general[3]['stu_advantage'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->MultiCell($w['改進寬'], $h['認識欄'], $general[3]['stu_improve'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->Cell($w['日期寬'], $h['認識欄'], $general[3]['fill_date'], 1, 1, "C");

// 六、生活感想
$h['認識框'] = $cell_6 * 7;

$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($w['概況框'], $h['認識框'], '六、生 活 感 想', 1, 'C', false, 0, '', '', true, 0, false, true, $h['認識框'], 'M');

// 補個粗框線
$x['瞭解我'] = $pdf->GetX();
$pdf->Cell($w['編號欄'] + $w['長概況'], $h['認識框'], '', 1, 0, "C");
$pdf->SetLineWidth(0.2);

$w['年級寬'] = 20;
$w['剩餘寬'] = ($w['編號欄'] + $w['長概況'] - $w['年級寬']) / 2;
$h['認識欄'] = $cell_6 * 2;
$pdf->setX($x['瞭解我']);
$pdf->Cell($w['年級寬'], $cell_6, '年級', 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, '我目前遇到最大的困難是', 1, 0, "C");
$pdf->Cell($w['剩餘寬'], $cell_6, '我目前最需要協助的是', 1, 1, "C");

$pdf->SetX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $h['認識欄'], '一年級', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['認識欄'], $general[1]['stu_difficult'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->MultiCell($w['剩餘寬'], $h['認識欄'], $general[1]['stu_need_help'], 1, 'L', false, 1, '', '', true, 0, false, true, $h['認識欄'], 'M');

$pdf->SetX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $h['認識欄'], '二年級', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['認識欄'], $general[2]['stu_difficult'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->MultiCell($w['剩餘寬'], $h['認識欄'], $general[2]['stu_need_help'], 1, 'L', false, 1, '', '', true, 0, false, true, $h['認識欄'], 'M');

$pdf->SetX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['年級寬'], $h['認識欄'], '三年級', 1, 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['認識欄'], $general[3]['stu_difficult'], 1, 'L', false, 0, '', '', true, 0, false, true, $h['認識欄'], 'M');
$pdf->MultiCell($w['剩餘寬'], $h['認識欄'], $general[3]['stu_need_help'], 1, 'L', false, 1, '', '', true, 0, false, true, $h['認識欄'], 'M');

// 七、畢業後計畫
$h['畢業後'] = $cell_6 * 8;
$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($w['概況框'], $h['畢業後'], '七、畢業後計畫', 1, 'C', false, 0, '', '', true, 0, false, true, $h['畢業後'], 'M');

// 補個粗框線
$x['瞭解我'] = $pdf->GetX();
$pdf->Cell($w['編號欄'] + $w['長概況'], $h['畢業後'], '', 1, 0, "C");
$pdf->SetLineWidth(0.2);

$w['標題寬'] = 42;
$h['內容值'] = $cell_6 * 2;
$w['剩餘寬'] = $w['編號欄'] + $w['長概況'] - $w['標題寬'];

$pdf->setX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['標題寬'], $h['內容值'], "升學意願\n（不升學者免填）", 1, 'C', false, 0, '', '', true, 4, false, true, $h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['內容值'], $stu['post_graduation_plan']['further_education'], 1, 'L', false, 1, '', '', true, 0, false, true, $h['內容值'], 'M');

$pdf->setX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['標題寬'], $h['內容值'], "就業意願\n（升學者免填）", 1, 'C', false, 0, '', '', true, 4, false, true, $h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['內容值'], $stu['post_graduation_plan']['employment'], 1, 'L', false, 1, '', '', true, 0, false, true, $h['內容值'], 'M');

$pdf->setX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['標題寬'], $h['內容值'], "如未能升學希望參加\n職業訓練種類及地區", 1, 'C', false, 0, '', '', true, 4, false, true, $h['內容值'], 'M');

$w['子標題'] = 25;
$w['剩餘寬'] = ($w['編號欄'] + $w['長概況'] - $w['標題寬'] - $w['子標題'] * 2) / 2;

$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['子標題'], $h['內容值'], '職訓種類：', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['內容值'], $stu['post_graduation_plan']['training_kind'], 'TB', 'L', false, 0, '', '', true, 0, false, true, $h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['子標題'], $h['內容值'], '受訓地區：', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['內容值'], $stu['post_graduation_plan']['training_zone'], 'TB', 'L', false, 1, '', '', true, 0, false, true, $h['內容值'], 'M');

$pdf->setX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($w['標題寬'], $h['內容值'], "將來職業意願", 1, 'C', false, 0, '', '', true, 4, false, true, $h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['子標題'], $h['內容值'], '職業種類：', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['內容值'], $stu['post_graduation_plan']['job_kind'], 'TB', 'L', false, 0, '', '', true, 0, false, true, $h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w['子標題'], $h['內容值'], '就業地區：', 'TB', 0, "C");
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['內容值'], $stu['post_graduation_plan']['job_zone'], 'TB', 'L', false, 1, '', '', true, 0, false, true, $h['內容值'], 'M');

// 八、備註
$h['備註欄'] = $cell_6 * 4;
$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($w['概況框'], $h['備註欄'], '八、備註', 1, 'C', false, 0, '', '', true, 0, false, true, $h['備註欄'], 'M');

// 補個粗框線
$x['瞭解我'] = $pdf->GetX();
$pdf->Cell($w['編號欄'] + $w['長概況'], $h['備註欄'], '', 1, 0, "C");
$pdf->SetLineWidth(0.2);

$w['剩餘寬'] = $w['編號欄'] + $w['長概況'];

$pdf->setX($x['瞭解我']);
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($w['剩餘寬'], $h['備註欄'], $stu['note'], 1, 'L', false, 1, '', '', true, 0, false, true, $h['備註欄'], 'M');

$pdf_title = iconv("UTF-8", "Big5", $pdf_title);
$pdf->Output($pdf_title . '.pdf', "D");
// $pdf->Output();
