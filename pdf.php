<?php
use Xmf\Request;
use XoopsModules\Scs\Scs_brother_sister;
use XoopsModules\Scs\Scs_general;
use XoopsModules\Scs\Scs_guardian;
use XoopsModules\Scs\Scs_parents;
use XoopsModules\Scs\Scs_students;
use XoopsModules\Scs\Tools;
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

require_once XOOPS_ROOT_PATH . '/modules/tadtools/tcpdf/tcpdf.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$stu_id = Request::getInt('stu_id');

Tools::chk_scs_power(__FILE__, __LINE__, 'show', $stu_id);

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

$now_grade = Tools::array_key_last($general);
$fill_grade = ($now_grade >= 7) ? 7 : 1;

$stage_arr = ($now_grade >= 7) ? ['七' => 7, '八' => 8, '九' => 9] : ['一' => 1, '二' => 2, '三' => 3, '四' => 4, '五' => 5, '六' => 6];

$pdf_title = " {$xoopsModuleConfig['school_name']}綜合資料紀錄表(A)";

$pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8', false);
$pdf->setPrintHeader(false); //不要頁首
$pdf->setPrintFooter(false); //不要頁尾
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM); //設定自動分頁
$pdf->setFontSubsetting(true); //產生字型子集（有用到的字才放到文件中）

$col_w['文件寬'] = 210;
$col_w['左邊界'] = 5;
$col_w['右邊界'] = 5;

$pdf->SetTopMargin(0);
$pdf->SetLeftMargin($col_w['左邊界']);
$pdf->SetAutoPageBreak('off');
$pdf->AddPage('P', 'A4');

$pdf->SetFont('twkai98_1', 'B', 18);
$pdf->Cell(180, 10, $pdf_title, 0, 1, "C", false, '', 1);
$cell_6 = 6;
$cell_10 = 10;

// 年級數
$stage_count = count($stage_arr);

$class_h = ($stage_count > 3) ? 6 : 7;
$basic_h = ($class_h * ($stage_count + 1)) / 3;
$col_y['最上列'] = $pdf->getY();
$pdf->SetFont('twkai98_1', '', 12);
// 左上第一列的標題寬
$col_w['學號欄'] = 25;
// 左上第一列的值寬
$col_w['學號值'] = 55;
$col_w['學號欄1'] = 15;
$col_w['學號值1'] = $col_w['學號值'] - $col_w['學號欄'] - $col_w['學號欄1'];
$pdf->Cell($col_w['學號欄'], $basic_h, '學    號', 1, 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['學號值'], $basic_h, $stu['stu_no'], 1, 1, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['學號欄'], $basic_h, '姓    名', 1, 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['學號欄'], $basic_h, $stu['stu_name'], 1, 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['學號欄1'], $basic_h, '性別', 1, 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['學號值1'], $basic_h, $stu['stu_sex'], 1, 1, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['學號欄'], $basic_h, '初填日期', 1, 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['學號值'], $basic_h, $general[$fill_grade]['fill_date'], 1, 1, "C", false, '', 1);

// 補個粗框線
$pdf->setXY($col_w['左邊界'], $col_y['最上列']);
$col_w['學號框'] = $col_w['學號欄'] + $col_w['學號值'];
$col_h['學號框'] = $class_h * ($stage_count + 1);
$pdf->SetLineWidth(0.5);
$pdf->Cell($col_w['學號框'], $col_h['學號框'], '', 1, 0, "C", false, '', 1);
$pdf->SetLineWidth(0.2);

// 計算班級的x位置
$col_x['班級左'] = $col_w['左邊界'] + $col_w['學號欄'] + $col_w['學號值'];
$pdf->setXY($col_x['班級左'], $col_y['最上列']);

// 班級寬
$col_w['班級寬'] = 18;
// 座號寬
$col_w['座號寬'] = 12;
// 導師寬
$col_w['導師寬'] = 20;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['班級寬'], $class_h, '班級', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['座號寬'], $class_h, '座號', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['班級寬'], $class_h, '班級', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['座號寬'], $class_h, '座號', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['導師寬'], $class_h, '導師姓名', 1, 1, "C", false, '', 1);

$pdf->SetTextColor(0, 0, 255);
foreach ($stage_arr as $year => $stage) {
    $pdf->setX(85);
    $stu_grade_class = !empty($general[$stage]['stu_class']) ? "{$general[$stage]['stu_grade']}-{$general[$stage]['stu_class']}" : '';
    $pdf->Cell($col_w['班級寬'], $class_h, $stu_grade_class, 1, 0, "C", false, '', 1);
    $pdf->Cell($col_w['座號寬'], $class_h, $general[$stage]['stu_seat_no'], 1, 0, "C", false, '', 1);
    $pdf->Cell($col_w['班級寬'], $class_h, $stu_grade_class, 1, 0, "C", false, '', 1);
    $pdf->Cell($col_w['座號寬'], $class_h, $general[$stage]['stu_seat_no'], 1, 0, "C", false, '', 1);
    $pdf->Cell($col_w['導師寬'], $class_h, $general[$stage]['class_tea'], 1, 1, "C", false, '', 1);
}

$col_y['概況列'] = $pdf->getY();

// 補個粗框線
$pdf->setXY($col_x['班級左'], $col_y['最上列']);
$col_w['班級框'] = ($col_w['班級寬'] + $col_w['座號寬']) * 2 + $col_w['導師寬'];
$col_h['班級框'] = $class_h * ($stage_count + 1);
$pdf->SetLineWidth(0.5);
$pdf->Cell($col_w['班級框'], $col_h['班級框'], '', 1, 0, "C", false, '', 1);

// 相片
$col_x['相片左'] = $col_x['班級左'] + $col_w['班級框'];
$pdf->setXY($col_x['相片左'], $col_y['最上列']);
$col_w['相片框'] = $col_w['文件寬'] - $col_w['左邊界'] - $col_w['學號框'] - $col_w['班級框'] - $col_w['右邊界'];
$col_h['相片框'] = $class_h * ($stage_count + 1) + $cell_6 * 3;
$pdf->SetLineWidth(0.5);
if ($stu['photo']) {
    $pdf->Image($stu['photo'], $col_x['相片左'], $col_y['最上列'], $col_w['相片框'], $col_h['相片框'], '', '', '', true, 600, '', false, false, 0, true, false, false, false);
}
$pdf->Cell($col_w['相片框'], $col_h['相片框'], '', 1, 1, "C", false, '', 1);

// $pdf->SetLineWidth(0.2);

// 一、本人概況
$col_w['概況框'] = 7;
$col_h['概況框'] = $cell_6 * 10;
$pdf->setY($col_y['概況列']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($col_w['概況框'], $col_h['概況框'], '一 、 本  人  概  況', 1, 'C', false, 0, '', '', true, 0, false, true, $col_h['概況框'], 'M');

// $pdf->MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false );

// 1.身份證統一編號
$pdf->SetLineWidth(0.2);
$col_w['編號欄'] = 6;
$col_w['概況欄'] = 30;
$col_w['概況值'] = $col_w['文件寬'] - $col_w['左邊界'] - $col_w['概況框'] - $col_w['編號欄'] - $col_w['概況欄'] - $col_w['相片框'] - $col_w['右邊界'];
$col_w['概況欄1'] = 20;
$col_w['概況值1'] = 20;
$col_w['剩餘寬'] = $col_w['概況值'] - ($col_w['概況欄1'] + $col_w['概況值1']) * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '1.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '身份證統一編號', 'TB', 0, "L", false, '', 1);
// $pdf->MultiCell($col_w['概況欄'], $cell_6, '身份證統一編號', 1, 'J', false, 0, '', '', true, 1, false, true, $cell_6, 'M', true);

$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $stu['stu_pid'], 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['概況欄1'], $cell_6, '身份', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['概況值1'], $cell_6, $stu['stu_identity'], 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['概況欄1'], $cell_6, '僑居地', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['概況值1'], $cell_6, $stu['stu_residence'], 'TB', 1, "C", false, '', 1);

// 2.出生
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$col_x['概況欄'] = $col_w['左邊界'] + $col_w['概況框'];
$col_w['剩餘寬'] = $col_w['概況值'] - ($col_w['概況欄1'] * 2) - $col_w['概況值1'];
$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $cell_6, '2.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '出生', 'TB', 0, "L", false, '', 1);
$pdf->Cell($col_w['概況欄1'], $cell_6, '出生地', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['概況值1'], $cell_6, $stu['stu_birth_place'], 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['概況欄1'], $cell_6, '生日', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $stu['tw_birthday'], 'TB', 1, "C", false, '', 1);

// 3.血型
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$col_w['血型寬'] = 30;
$col_w['剩餘寬'] = $col_w['概況值'] - $col_w['概況欄1'] - $col_w['血型寬'];
$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $cell_6, '3.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '血型', 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['血型寬'], $cell_6, $stu['stu_blood'], 1, 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['概況欄1'], $cell_6, '宗教', 1, 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $stu['stu_religion'], 1, 1, "C", false, '', 1);

// 4.通訊處
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$col_w['內標題'] = 14;
$col_w['電話欄'] = 7;
$col_w['電話值'] = 35;
$col_h['通訊處'] = $cell_6 * 2;
$col_w['概況值'] = $col_w['文件寬'] - $col_w['左邊界'] - $col_w['概況框'] - $col_w['編號欄'] - $col_w['概況欄'] - $col_w['右邊界'];
$col_w['剩餘寬'] = $col_w['概況值'] - $col_w['內標題'] - $col_w['電話欄'] - $col_w['電話值'];
$col_x['概況值'] = $col_w['左邊界'] + $col_w['概況框'] + $col_w['編號欄'] + $col_w['概況欄'];
$col_y['通訊處'] = $pdf->getY();
$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $col_h['通訊處'], '4.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $col_h['通訊處'], '通訊處', 'TB', 0, "L", false, '', 1);
$pdf->Cell($col_w['內標題'], $cell_6, '永久：', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, "{$stu['stu_residence_zip']}{$stu['stu_residence_county']}{$stu['stu_residence_city']}{$stu['stu_residence_addr']}", 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($col_w['電話欄'], $col_h['通訊處'], '電話', 1, 'C', false, 0, '', '', true, 0, false, true, $col_h['通訊處'], 'M');
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['電話值'], $cell_6, $stu['stu_tel1'], 1, 2, "C", false, '', 1);
$col_y['現在欄'] = $pdf->getY();
$pdf->Cell($col_w['電話值'], $cell_6, $stu['stu_tel2'], 1, 1, "C", false, '', 1);
$pdf->SetXY($col_x['概況值'], $col_y['現在欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['內標題'], $cell_6, '現在：', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, "{$stu['stu_zip']}{$stu['stu_county']}{$stu['stu_city']}{$stu['stu_addr']}", 'TB', 2, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);

// 5.緊急聯絡人
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$col_w['姓名值'] = 22;
$col_w['電話值'] = 28;
$col_w['剩餘寬'] = $col_w['概況值'] - $col_w['姓名值'] - $col_w['電話值'] - $col_w['內標題'] * 3;
$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $cell_6, '5.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '緊急聯絡人', 'TB', 0, "L", false, '', 1);
$pdf->Cell($col_w['內標題'], $cell_6, '姓名：', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['姓名值'], $cell_6, $guardian['guardian_name'], 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['內標題'], $cell_6, '住址：', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $guardian['guardian_addr'], 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['內標題'], $cell_6, '電話：', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['電話值'], $cell_6, $guardian['guardian_tel'], 'TBR', 1, "L", false, '', 1);

// 6.學歷及就學
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$col_h['就學高'] = $cell_6 * 2;
$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $col_h['就學高'], '6.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $col_h['就學高'], '學歷及就學', 'TB', 0, "L", false, '', 1);

$pdf->writeHTMLCell($col_w['概況值'], $col_h['就學高'], '', '', "民國 <span style=\"color: blue\">{$stu['stu_education']['g_time']}</span> 年畢（肄）業於 <span style=\"color: blue\">{$stu['stu_education']['g_school']}</span> ，民國 <span style=\"color: blue\">{$stu['stu_education']['i_time']}</span> 年進入本校<br>
<span style=\"color: blue\">{$stu['stu_education']['o_time']}</span> 年自本校畢業，於 <span style=\"color: blue\">{$stu['stu_education']['jh_time']}</span> 年進入 <span style=\"color: blue\">{$stu['stu_education']['jh_school']}</span> 就讀", 1, 2, false, true, '', true);
// writeHTMLCell($w, $h, $x, $y, $html = '', $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);

// 7.身高及體重
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$col_w['身高寬'] = 12;
$col_w['年級寬'] = 7;
$col_w['剩餘寬'] = ($col_w['概況值'] - $col_w['身高寬'] * 2 - $col_w['年級寬'] * ($stage_count * 2)) / ($stage_count * 2);
$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $cell_6, '7.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '身高及體重', 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['身高寬'], $cell_6, '身高', 1, 0, "C", false, '', 1);

foreach ($stage_arr as $year => $stage) {
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $cell_6, $year, 'TB', 0, "C", false, '', 1);
    $pdf->SetTextColor(0, 0, 255);
    $unit = ($now_grade >= 7) ? '公分' : '';
    $stu_height = $general[$stage]['stu_height'] ? "{$general[$stage]['stu_height']}{$unit}" : '';
    $pdf->Cell($col_w['剩餘寬'], $cell_6, $stu_height, 'TB', 0, "C", false, '', 1);
}

$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['身高寬'], $cell_6, '體重', 1, 0, "C", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 1 : 0;
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $cell_6, $year, 'TB', 0, "C", false, '', 1);
    $pdf->SetTextColor(0, 0, 255);
    $unit = ($now_grade >= 7) ? '公斤' : '';
    $stu_weight = $general[$stage]['stu_weight'] ? "{$general[$stage]['stu_weight']}{$unit}" : '';
    $pdf->Cell($col_w['剩餘寬'], $cell_6, $stu_weight, 'TB', $new_line, "C", false, '', 1);
    $i++;
}

// 8.生理缺陷
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$col_w['身高寬'] = 12;
$col_w['年級寬'] = 7;
$col_w['剩餘寬'] = ($col_w['概況值'] - $col_w['編號欄'] - $col_w['概況欄'] - $col_w['年級寬'] * 4) / 4;
$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $cell_6, '8.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '生理缺陷', 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['年級寬'], $cell_6, '1.', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $stu['physiological_defect'][1], 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['年級寬'], $cell_6, '2.', 'TBL', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $stu['physiological_defect'][2], 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '9.', 'TBR', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '曾患特殊疾病', 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['年級寬'], $cell_6, '1.', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $stu['special_disease'][1], 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['年級寬'], $cell_6, '2.', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $stu['special_disease'][2], 'TBR', 1, "L", false, '', 1);
$col_y['疾病值'] = $pdf->getY();

// 補個粗框線
$pdf->setXY($col_x['概況欄'], $col_y['概況列']);
$col_h['概況欄'] = $cell_6 * 10;
$pdf->SetLineWidth(0.5);
$pdf->Cell($col_w['編號欄'] + $col_w['概況欄'], $col_h['概況欄'], '', 1, 0, "C", false, '', 1);

$pdf->setXY($col_x['概況值'], $col_y['通訊處']);
$col_h['疾病值'] = $cell_6 * 7;
$pdf->Cell($col_w['概況值'], $col_h['疾病值'], '', 'RB', 0, "C", false, '', 1);
// $pdf->SetLineWidth(0.2);

// 二、家長狀況
$col_w['家長框'] = 7;
$col_h['家長框'] = $cell_6 * 20;
$pdf->setY($col_y['疾病值']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($col_w['家長框'], $col_h['家長框'], '二     、    家        長        狀        況', 1, 'C', false, 0, '', '', true, 0, false, true, $col_h['家長框'], 'M');
$col_y['家長框'] = $pdf->getY() + $col_h['家長框'];
// $pdf->MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false );

// 10.直系血親
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$col_h['直系欄'] = $cell_6 * 2;
$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $col_h['直系欄'], '10.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $col_h['直系欄'], '直系血親', 'TB', 0, "L", false, '', 1);
$col_x['直系欄'] = $pdf->GetX();
$col_y['直系欄'] = $pdf->GetY();
// $pdf->writeHTMLCell($col_w['概況值'], $col_h['直系欄'], '', '', "父 <span style=\"color: blue\">{$parents['f']['parent_name']}</span> [<span style=\"color: blue\">{$parents['f']['parent_survive']}</span>] <span style=\"color: blue\">{$parents['f']['parent_year']}</span> 年生 祖父 <span style=\"color: blue\">{$parents['f']['parent_gf_name']}</span> [<span style=\"color: blue\">{$parents['f']['parent_gf_survive']}</span>]<br>
// 母 <span style=\"color: blue\">{$parents['m']['parent_name']}</span> [<span style=\"color: blue\">{$parents['m']['parent_survive']}</span>] <span style=\"color: blue\">{$parents['m']['parent_year']}</span> 年生 祖母 <span style=\"color: blue\">{$parents['m']['parent_gm_name']}</span> [<span style=\"color: blue\">{$parents['m']['parent_gm_survive']}</span>] ", 1, 1, false, true, '', true);
$pdf->writeHTMLCell($col_w['概況值'], $col_h['直系欄'], '', '', "父 <span style=\"color: blue\">{$parents['f']['parent_name']}</span> [<span style=\"color: blue\">{$parents['f']['parent_survive']}</span>] <span style=\"color: blue\">{$parents['f']['parent_year']}</span> 年生 <br>
母 <span style=\"color: blue\">{$parents['m']['parent_name']}</span> [<span style=\"color: blue\">{$parents['m']['parent_survive']}</span>] <span style=\"color: blue\">{$parents['m']['parent_year']}</span> 年生 ", 1, 1, false, true, '', true);

// 11.父母教育程度
$pdf->SetLineWidth(0.2);
$pdf->SetTextColor(0, 0, 0);
$col_w['父母寬'] = 10;
$col_w['剩餘寬'] = ($col_w['概況值'] - ($col_w['父母寬'] * 2)) / 2;
$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $cell_6, '11.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '父母教育程度', 'TB', 0, "L", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['父母寬'], $cell_6, '父', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $parents['f']['parent_edu'], 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['父母寬'], $cell_6, '母', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $parents['m']['parent_edu'], 'TBR', 2, "C", false, '', 1);

// 12.家長
$col_w['稱謂寬'] = 10;
$col_w['姓名寬'] = 25;
$col_w['職業寬'] = 20;
$col_w['電話寬'] = 25;
$col_w['手機寬'] = 25;
$col_h['家長欄'] = $cell_6 * 4;
$col_w['剩餘寬'] = $col_w['概況值'] - $col_w['稱謂寬'] - $col_w['姓名寬'] - $col_w['職業寬'] - $col_w['電話寬'] - $col_w['手機寬'] - $col_w['家長欄'];
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $col_h['家長欄'], '12.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $col_h['家長欄'], '家長', 'TB', 0, "L", false, '', 1);
$pdf->Cell($col_w['稱謂寬'], $cell_6, '稱謂', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, '姓名', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['職業寬'], $cell_6, '職業', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, '工作機構與職稱', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['電話寬'], $cell_6, '公司電話', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['手機寬'], $cell_6, '手機', 1, 1, "C", false, '', 1);

$pdf->SetTextColor(0, 0, 255);
$pdf->SetX($col_x['概況值']);
$pdf->Cell($col_w['稱謂寬'], $cell_6, '父', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, $parents['f']['parent_name'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['職業寬'], $cell_6, $parents['f']['parent_job'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $parents['f']['parent_company'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['電話寬'], $cell_6, $parents['f']['parent_company_tel'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['手機寬'], $cell_6, $parents['f']['parent_phone'], 1, 1, "C", false, '', 1);

$pdf->SetX($col_x['概況值']);
$pdf->Cell($col_w['稱謂寬'], $cell_6, '母', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, $parents['m']['parent_name'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['職業寬'], $cell_6, $parents['m']['parent_job'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $parents['m']['parent_company'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['電話寬'], $cell_6, $parents['m']['parent_company_tel'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['手機寬'], $cell_6, $parents['m']['parent_phone'], 1, 1, "C", false, '', 1);

$col_w['電郵寬'] = 15;
$col_w['剩餘寬'] = ($col_w['概況值'] - $col_w['電郵寬'] * 2) / 2;
$pdf->SetX($col_x['概況值']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['電郵寬'], $cell_6, '父電郵', '1', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $parents['f']['parent_email'], '1', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['電郵寬'], $cell_6, '母電郵', '1', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $parents['m']['parent_email'], '1', 2, "C", false, '', 1);

// 13.監護人
$col_w['標題寬'] = 14;
$col_w['姓名寬'] = 16;
$col_w['性別寬'] = 8;
$col_w['關係寬'] = 10;
$col_h['監護人'] = $cell_6 * 2;
$col_w['剩餘寬'] = $col_w['概況值'] - $col_w['標題寬'] * 4 - $col_w['姓名寬'] - $col_w['性別寬'] - $col_w['關係寬'];
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $col_h['監護人'], '13.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $col_h['監護人'], '監護人', 'TB', 0, "L", false, '', 1);
$pdf->Cell($col_w['標題寬'], $col_h['監護人'], '姓名', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['姓名寬'], $col_h['監護人'], $guardian['guardian_name'], 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['標題寬'], $col_h['監護人'], '性別', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['性別寬'], $col_h['監護人'], $guardian['guardian_sex'], 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['標題寬'], $col_h['監護人'], '關係', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['關係寬'], $col_h['監護人'], $guardian['guardian_title'], 'TB', 0, "C", false, '', 1);
$col_x['通訊處'] = $pdf->getX();
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['標題寬'], $cell_6, '通訊處', 'T', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $guardian['guardian_addr'], 'TR', 1, "L", false, '', 1);
$pdf->setX($col_x['通訊處']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['標題寬'], $cell_6, '電  話', 'B', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $guardian['guardian_tel'], 'BR', 1, "L", false, '', 1);

// 14.兄弟姊妹
$col_w['稱謂寬'] = 10;
$col_w['姓名寬'] = 16;
$col_w['出生寬'] = 10;
$col_w['備註寬'] = 10;
$col_h['兄弟欄'] = $cell_6 * 3;
$col_w['剩餘寬'] = ($col_w['概況值'] - ($col_w['稱謂寬'] + $col_w['姓名寬'] + $col_w['出生寬'] + $col_w['備註寬']) * 2) / 2;
// $col_x['備註欄'] = $col_w['概況值'] - $col_w['剩餘寬'];
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '14.', 'T', 0, "R", false, '', 1);
$col_x['稱謂欄'] = $pdf->GetX();
$pdf->Cell($col_w['概況欄'], $cell_6, '兄弟姊妹', 'T', 0, "L", false, '', 1);
$pdf->Cell($col_w['稱謂寬'], $cell_6, '稱謂', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, '姓名', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, '畢業（肄）學校', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['出生寬'], $cell_6, '年次', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['備註寬'], $cell_6, '備註', 1, 0, "C", false, '', 1);
$col_x['備註欄'] = $pdf->GetX();
$pdf->Cell($col_w['稱謂寬'], $cell_6, '稱謂', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, '姓名', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, '畢業（肄）學校', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['出生寬'], $cell_6, '年次', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['備註寬'], $cell_6, '備註', 1, 1, "C", false, '', 1);
// $col_x['稱謂欄'] = $pdf->GetX();
// $col_y['稱謂欄'] = $pdf->GetY();
$pdf->SetX($col_x['概況欄']);

$pdf->Cell($col_w['編號欄'], $cell_6, '', 0, 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '(按出生序填寫)', 0, 0, "L", false, '', 1);

$col_y['備註欄'] = $pdf->GetY();

$pdf->SetTextColor(0, 0, 255);
$pdf->SetX($col_x['概況值']);
$pdf->Cell($col_w['稱謂寬'], $cell_6, $brother_sister[1]['bs_relationship'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, $brother_sister[1]['bs_name'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $brother_sister[1]['bs_school'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['出生寬'], $cell_6, $brother_sister[1]['bs_year'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['備註寬'], $cell_6, $brother_sister[1]['bs_note'], 1, 1, "C", false, '', 1);

$pdf->SetX($col_x['概況欄']);
$pdf->Cell($col_w['編號欄'], $cell_6, '', 0, 0, "R", false, '', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell($col_w['概況欄'], $cell_6, '', '', "我排行第 <span style=\"color: blue\">{$brother_sister['my_rank']}</span>", 0, 0, false, true, '', true);
$pdf->SetTextColor(0, 0, 255);
$pdf->SetX($col_x['概況值']);
$pdf->Cell($col_w['稱謂寬'], $cell_6, $brother_sister[2]['bs_relationship'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, $brother_sister[2]['bs_name'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $brother_sister[2]['bs_school'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['出生寬'], $cell_6, $brother_sister[2]['bs_year'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['備註寬'], $cell_6, $brother_sister[2]['bs_note'], 1, 1, "C", false, '', 1);

$pdf->SetX($col_x['概況值']);
$pdf->Cell($col_w['稱謂寬'], $cell_6, $brother_sister[3]['bs_relationship'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, $brother_sister[3]['bs_name'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $brother_sister[3]['bs_school'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['出生寬'], $cell_6, $brother_sister[3]['bs_year'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['備註寬'], $cell_6, $brother_sister[3]['bs_note'], 1, 1, "C", false, '', 1);

$pdf->SetX($col_x['備註欄']);
$pdf->SetY($col_y['備註欄']);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetTextColor(0, 0, 255);
$pdf->SetX($col_x['備註欄']);
$pdf->Cell($col_w['稱謂寬'], $cell_6, $brother_sister[4]['bs_relationship'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, $brother_sister[4]['bs_name'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $brother_sister[4]['bs_school'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['出生寬'], $cell_6, $brother_sister[4]['bs_year'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['備註寬'], $cell_6, $brother_sister[4]['bs_note'], 1, 1, "C", false, '', 1);

$pdf->SetX($col_x['備註欄']);
$pdf->Cell($col_w['稱謂寬'], $cell_6, $brother_sister[5]['bs_relationship'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, $brother_sister[5]['bs_name'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $brother_sister[5]['bs_school'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['出生寬'], $cell_6, $brother_sister[5]['bs_year'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['備註寬'], $cell_6, $brother_sister[5]['bs_note'], 1, 1, "C", false, '', 1);

$pdf->SetX($col_x['備註欄']);
$pdf->Cell($col_w['稱謂寬'], $cell_6, $brother_sister[6]['bs_relationship'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['姓名寬'], $cell_6, $brother_sister[6]['bs_name'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, $brother_sister[6]['bs_school'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['出生寬'], $cell_6, $brother_sister[6]['bs_year'], 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['備註寬'], $cell_6, $brother_sister[6]['bs_note'], 1, 1, "C", false, '', 1);

// 15.父母關係
$col_w['年級寬'] = 8;
$col_w['剩餘寬'] = ($col_w['概況值'] - $col_w['年級寬'] * $stage_count) / $stage_count;
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '15.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '父母關係', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 2 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $cell_6, $year, 'TB', 0, "C", false, '', 1);
    $pdf->SetTextColor(0, 0, 255);
    $pdf->Cell($col_w['剩餘寬'], $cell_6, $general[$stage]['parental_relationship'], $border, $new_line, "C", false, '', 1);
    $i++;
}

// 16.家庭氣氛
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '16.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '家庭氣氛', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 2 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $cell_6, $year, 'TB', 0, "C", false, '', 1);
    $pdf->SetTextColor(0, 0, 255);
    $pdf->Cell($col_w['剩餘寬'], $cell_6, $general[$stage]['family_atmosphere'], $border, $new_line, "C", false, '', 1);
    $i++;
}

// 17.父母管教方式
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '17.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '父母管教方式', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 2 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $cell_6, $year, 'TB', 0, "C", false, '', 1);
    $v = empty($general[$stage]['father_discipline']) ? '' : "父：<span style=\"color: blue\">{$general[$stage]['father_discipline']}</span> 母：<span style=\"color: blue\">{$general[$stage]['mother_discipline']}</span>";
    $pdf->writeHTMLCell($col_w['剩餘寬'], $cell_6, '', '', $v, $border, $new_line, false, true, '', true);
    $i++;
}

// 18.居住環境
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '18.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '居住環境', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 2 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $cell_6, $year, 'TB', 0, "C", false, '', 1);
    $pdf->SetTextColor(0, 0, 255);
    $pdf->Cell($col_w['剩餘寬'], $cell_6, $general[$stage]['environment'], $border, $new_line, "C", false, '', 1);

    $i++;
}

// 19.本人住宿
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '19.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '本人住宿', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 2 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $cell_6, $year, 'TB', 0, "C", false, '', 1);
    $pdf->SetTextColor(0, 0, 255);
    $pdf->Cell($col_w['剩餘寬'], $cell_6, $general[$stage]['accommodation'], $border, $new_line, "C", false, '', 1);

    $i++;
}

// 20.經濟狀況
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '20.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '經濟狀況', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 2 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $cell_6, $year, 'TB', 0, "C", false, '', 1);
    $pdf->SetTextColor(0, 0, 255);
    $pdf->Cell($col_w['剩餘寬'], $cell_6, $general[$stage]['economic'], $border, $new_line, "C", false, '', 1);

    $i++;
}

// 21.每週零用錢約
$pdf->SetX($col_x['概況欄']);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '21.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '每週零用錢約', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 2 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $cell_6, $year, 'TB', 0, "C", false, '', 1);
    $v = empty($general[$stage]['money']) ? '' : "<span style=\"color: blue\">{$general[$stage]['money']}</span> 我覺得 <span style=\"color: blue\">{$general[$stage]['feel']}</span>";
    $pdf->writeHTMLCell($col_w['剩餘寬'], $cell_6, '', '', $v, $border, $new_line, false, true, '', true);

    $i++;
}

// 補個粗框線
$pdf->setXY($col_x['概況欄'], $col_y['直系欄']);
$pdf->SetLineWidth(0.5);
$pdf->Cell($col_w['編號欄'] + $col_w['概況欄'], $col_h['家長框'], '', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['概況值'], $col_h['家長框'], '', 1, 1, "C", false, '', 1);

// 三、學習狀況
$col_w['學習框'] = 7;
$col_h['學習框'] = $cell_6 * 10;
$pdf->setY($col_y['家長框']);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($col_w['學習框'], $col_h['學習框'], '三 、 學  習  狀  況', 1, 'C', false, 0, '', '', true, 0, false, true, $col_h['學習框'], 'M');
// $pdf->MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false );

// 22.最喜歡的學科
$pdf->SetLineWidth(0.2);
$pdf->SetX($col_x['概況欄']);
$col_h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $col_h['學科欄'], '22.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $col_h['學科欄'], '最喜歡的學科', 'TB', 0, "L", false, '', 1);
$col_y['學科欄'] = $pdf->GetY();

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 1 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell($col_w['年級寬'], $col_h['學科欄'], $year . '年', '1', 'C', false, 0, '', '', true, 0, false, true, $col_h['學科欄'], 'M');
    $pdf->SetTextColor(0, 0, 255);
    $favorite_subject = implode('、', $general[$stage]['favorite_subject']);
    $pdf->MultiCell($col_w['剩餘寬'], $col_h['學科欄'], $favorite_subject, '1', 'C', false, $new_line, '', '', true, 0, false, true, $col_h['學科欄'], 'M');
    $i++;
}

// 23.最感困難的學科
$pdf->SetLineWidth(0.2);
$pdf->SetX($col_x['概況欄']);
$col_h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $col_h['學科欄'], '23.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $col_h['學科欄'], '最感困難的學科', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 1 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell($col_w['年級寬'], $col_h['學科欄'], $year . '年', '1', 'C', false, 0, '', '', true, 0, false, true, $col_h['學科欄'], 'M');
    $pdf->SetTextColor(0, 0, 255);
    $difficult_subject = implode('、', $general[$stage]['difficult_subject']);
    $pdf->MultiCell($col_w['剩餘寬'], $col_h['學科欄'], $difficult_subject, '1', 'C', false, $new_line, '', '', true, 0, false, true, $col_h['學科欄'], 'M');

    $i++;
}

// 24.特殊專長
$pdf->SetLineWidth(0.2);
$pdf->SetX($col_x['概況欄']);
$col_h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $col_h['學科欄'], '24.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $col_h['學科欄'], '特殊專長', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 1 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell($col_w['年級寬'], $col_h['學科欄'], $year . '年', '1', 'C', false, 0, '', '', true, 0, false, true, $col_h['學科欄'], 'M');
    $pdf->SetTextColor(0, 0, 255);
    $expertise = implode('、', $general[$stage]['expertise']);
    $pdf->MultiCell($col_w['剩餘寬'], $col_h['學科欄'], $expertise, '1', 'C', false, $new_line, '', '', true, 0, false, true, $col_h['學科欄'], 'M');
    $i++;
}

// 25.休閒興趣
$pdf->SetLineWidth(0.2);
$pdf->SetX($col_x['概況欄']);
$col_h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $col_h['學科欄'], '25.', 'TB', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $col_h['學科欄'], '休閒興趣', 'TB', 0, "L", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 1 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell($col_w['年級寬'], $col_h['學科欄'], $year . '年', '1', 'C', false, 0, '', '', true, 0, false, true, $col_h['學科欄'], 'M');
    $pdf->SetTextColor(0, 0, 255);
    $interest = implode('、', $general[$stage]['interest']);
    $pdf->MultiCell($col_w['剩餘寬'], $col_h['學科欄'], $interest, '1', 'C', false, $new_line, '', '', true, 0, false, true, $col_h['學科欄'], 'M');
    $i++;
}

// 26.參加校內社團擔任班級幹部
$pdf->SetLineWidth(0.2);
$pdf->SetX($col_x['概況欄']);
$col_h['學科欄'] = $cell_6 * 2;
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['編號欄'], $cell_6, '26.', 'T', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '參加校內社團及', 'T', 0, "L", false, '', 1);
$col_y['社團欄'] = $pdf->GetY() + $cell_6;
// $pdf->MultiCell($col_w['概況欄'], $col_h['學科欄'], "參加校內社團及\n擔任班級幹部", 'TB', 'L', false, 0, '', '', true, 1, false, true, $col_h['學科欄'], 'M', true);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 1 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell($col_w['年級寬'], $col_h['學科欄'], $year . '年', '1', 'C', false, 0, '', '', true, 0, false, true, $col_h['學科欄'], 'M');
    $v = empty($general[$stage]['club']) ? '' : "社團：<span style=\"color: blue\">{$general[$stage]['club']}</span><br>幹部：<span style=\"color: blue\">{$general[$stage]['cadre']}</span>";
    $pdf->writeHTMLCell($col_w['剩餘寬'], $col_h['學科欄'], '', '', $v, '1', $new_line, false, true, '', true);

    $i++;
}

$pdf->SetXY($col_x['概況欄'], $col_y['社團欄']);
$pdf->Cell($col_w['編號欄'], $cell_6, '', '0', 0, "R", false, '', 1);
$pdf->Cell($col_w['概況欄'], $cell_6, '擔任班級幹部', '0', 0, "L", false, '', 0);

// 補個粗框線
$pdf->setXY($col_x['概況欄'], $col_y['學科欄']);
$pdf->SetLineWidth(0.5);
$pdf->Cell($col_w['編號欄'] + $col_w['概況欄'], $col_h['學習框'], '', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['概況值'], $col_h['學習框'], '', 1, 1, "C", false, '', 1);

$pdf->AddPage('P', 'A4');

// 四、自傳
$pdf->setY(20);
$col_w['長概況'] = $col_w['概況欄'] + $col_w['概況值'];
$col_h['自傳框'] = $cell_6 * 17;
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($col_w['概況框'], $col_h['自傳框'], '四  、  自   傳', 1, 'C', false, 0, '', '', true, 0, false, true, $col_h['自傳框'], 'M');
// 補個粗框線
$col_x['瞭解我'] = $pdf->GetX();
$pdf->Cell($col_w['編號欄'] + $col_w['長概況'], $col_h['自傳框'], '', 1, 0, "C", false, '', 1);
$pdf->SetLineWidth(0.2);

// 1.家中最理解我的人是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '1.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "家中最理解我的人是： <span style=\"color: blue\">{$stu['stu_autobiography']['understand']}</span> 因為 <span style=\"color: blue\">{$stu['stu_autobiography']['understand_reason']}</span>", 'TB', 2, false, true, '', true);

// 2.家中指導我做功課的人是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '2.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "家中指導我做功課的人是： <span style=\"color: blue\">{$stu['stu_autobiography']['homework']}</span>", 'TB', 2, false, true, '', true);

// 3.我在家中最怕的人是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '3.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我在家中最怕的人是： <span style=\"color: blue\">{$stu['stu_autobiography']['afraid']}</span> 因為 <span style=\"color: blue\">{$stu['stu_autobiography']['afraid_reason']}</span>", 'TB', 2, false, true, '', true);

// 4.我覺得我家的優點是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '4.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我覺得我家的優點是： <span style=\"color: blue\">{$stu['stu_autobiography']['advantage']}</span>", 'TB', 2, false, true, '', true);

// 5.我覺得我家的缺點是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '5.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我覺得我家的缺點是： <span style=\"color: blue\">{$stu['disadvantage']['afraid']}</span>", 'TB', 2, false, true, '', true);

// 6.我最要好的朋友是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '6.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我最要好的朋友是： <span style=\"color: blue\">{$stu['stu_autobiography']['friend']}</span> 他是怎樣的人？ <span style=\"color: blue\">{$stu['stu_autobiography']['friend_reason']}</span>", 'TB', 2, false, true, '', true);

// 7.我最喜歡的國小老師是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '7.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我最喜歡的國小老師是： <span style=\"color: blue\">{$stu['stu_autobiography']['teacher']}</span> 他是怎樣的人？ <span style=\"color: blue\">{$stu['stu_autobiography']['teacher_reason']}</span>", 'TB', 2, false, true, '', true);

// 8.小學老師或同學常說我是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '8.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "小學老師或同學常說我是： <span style=\"color: blue\">{$stu['stu_autobiography']['impression']}</span>", 'TB', 2, false, true, '', true);

// 9.小學時我曾在班上擔任過的職務有：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '9.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "小學時我曾在班上擔任過的職務有： <span style=\"color: blue\">{$stu['stu_autobiography']['position']}</span>", 'TB', 2, false, true, '', true);

// 10.我在小學得過的獎有：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '10.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我在小學得過的獎有： <span style=\"color: blue\">{$stu['stu_autobiography']['award']}</span>", 'TB', 2, false, true, '', true);

// 11.我國小畢業時的智育成績是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '11.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我國小畢業時的智育成績是： <span style=\"color: blue\">{$stu['stu_autobiography']['iq']}</span> 我國小畢業時的德育成績是： <span style=\"color: blue\">{$stu['stu_autobiography']['eq']}</span>", 'TB', 2, false, true, '', true);

// 12.我覺得自己的過去最滿意的是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '12.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我覺得自己的過去最滿意的是： <span style=\"color: blue\">{$stu['stu_autobiography']['satisfaction']}</span>", 'TB', 2, false, true, '', true);

// 我覺得自己的過去最失敗的是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我覺得自己的過去最失敗的是： <span style=\"color: blue\">{$stu['stu_autobiography']['failure']}</span>", 'TB', 2, false, true, '', true);

// 13.我最喜歡做的事是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '13.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我最喜歡做的事是： <span style=\"color: blue\">{$stu['stu_autobiography']['like']}</span> 因為 <span style=\"color: blue\">{$stu['stu_autobiography']['like_reason']}</span>", 'TB', 2, false, true, '', true);

// 我最不喜歡做的事是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我最不喜歡做的事是： <span style=\"color: blue\">{$stu['stu_autobiography']['dislike']}</span> 因為 <span style=\"color: blue\">{$stu['stu_autobiography']['dislike_reason']}</span>", 'TB', 2, false, true, '', true);

// 14.我排遣休閒時間的方法是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '14.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我排遣休閒時間的方法是： <span style=\"color: blue\">{$stu['stu_autobiography']['leisure']}</span>", 'TB', 2, false, true, '', true);

// 15.我最難忘的一件事是：
$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['編號欄'], $cell_6, '15.', 'TB', 0, "R", false, '', 1);
$pdf->writeHTMLCell($col_w['長概況'], $cell_6, '', '', "我最難忘的一件事是： <span style=\"color: blue\">{$stu['stu_autobiography']['memorable']}</span>", 'TB', 1, false, true, '', true);

// 五、自我認識
$line = $stage_count > 3 ? 1 : 2;
$col_h['認識欄'] = $cell_6 * $line;
$col_h['認識框'] = $cell_6 * ($stage_count * $line) + $cell_6;

$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($col_w['概況框'], $col_h['認識框'], '五、自 我 認 識', 1, 'C', false, 0, '', '', true, 0, false, true, $col_h['認識框'], 'M');

// 補個粗框線
$col_x['瞭解我'] = $pdf->GetX();
$pdf->Cell($col_w['編號欄'] + $col_w['長概況'], $col_h['認識框'], '', 1, 0, "C", false, '', 1);
$pdf->SetLineWidth(0.2);

$col_w['年級寬'] = 20;
$col_w['優點寬'] = 40;
$col_w['改進寬'] = 40;
$col_w['日期寬'] = 28;
$col_w['剩餘寬'] = $col_w['編號欄'] + $col_w['長概況'] - $col_w['年級寬'] - $col_w['優點寬'] - $col_w['改進寬'] - $col_w['日期寬'];

$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['年級寬'], $cell_6, '年級', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, '我的個性（如：溫和、急躁）', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['優點寬'], $cell_6, '我的優點', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['改進寬'], $cell_6, '我需要改進的地方', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['日期寬'], $cell_6, '填寫日期', 1, 1, "C", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 1 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetX($col_x['瞭解我']);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $col_h['認識欄'], $year . '年級', 1, 0, "C", false, '', 1);
    $pdf->SetTextColor(0, 0, 255);

    $pdf->MultiCell($col_w['剩餘寬'], $col_h['認識欄'], $general[$stage]['stu_personality'], 1, 'L', false, 0, '', '', true, 0, false, true, null, 'M');
    $pdf->MultiCell($col_w['優點寬'], $col_h['認識欄'], $general[$stage]['stu_advantage'], 1, 'L', false, 0, '', '', true, 0, false, true, null, 'M');
    $pdf->MultiCell($col_w['改進寬'], $col_h['認識欄'], $general[$stage]['stu_improve'], 1, 'L', false, 0, '', '', true, 0, false, true, null, 'M');
    $pdf->Cell($col_w['日期寬'], $col_h['認識欄'], $general[$stage]['fill_date'], 1, 1, "C", false, '', 1);
    $i++;
}

// 六、生活感想
$line = $stage_count > 3 ? 1 : 2;
$col_h['認識欄'] = $cell_6 * $line;
$col_h['認識框'] = $cell_6 * ($stage_count * $line) + $cell_6;

$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($col_w['概況框'], $col_h['認識框'], '六、生 活 感 想', 1, 'C', false, 0, '', '', true, 0, false, true, $col_h['認識框'], 'M');

// 補個粗框線
$col_x['瞭解我'] = $pdf->GetX();
$pdf->Cell($col_w['編號欄'] + $col_w['長概況'], $col_h['認識框'], '', 1, 0, "C", false, '', 1);
$pdf->SetLineWidth(0.2);

$col_w['年級寬'] = 20;
$col_w['剩餘寬'] = ($col_w['編號欄'] + $col_w['長概況'] - $col_w['年級寬']) / 2;

$pdf->setX($col_x['瞭解我']);
$pdf->Cell($col_w['年級寬'], $cell_6, '年級', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, '我目前遇到最大的困難是', 1, 0, "C", false, '', 1);
$pdf->Cell($col_w['剩餘寬'], $cell_6, '我目前最需要協助的是', 1, 1, "C", false, '', 1);

$i = 1;
foreach ($stage_arr as $year => $stage) {
    $new_line = $i == $stage_count ? 1 : 0;
    $border = $i == $stage_count ? 'TBR' : 'TB';
    $pdf->SetX($col_x['瞭解我']);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($col_w['年級寬'], $col_h['認識欄'], $year . '年級', 1, 0, "C", false, '', 1);
    $pdf->SetTextColor(0, 0, 255);
    $pdf->MultiCell($col_w['剩餘寬'], $col_h['認識欄'], $general[$stage]['stu_difficult'], 1, 'L', false, 0, '', '', true, 0, false, true, null, 'M');
    $pdf->MultiCell($col_w['剩餘寬'], $col_h['認識欄'], $general[$stage]['stu_need_help'], 1, 'L', false, 1, '', '', true, 0, false, true, null, 'M');
    $i++;
}

// 七、畢業後計畫
$col_h['畢業後'] = $cell_6 * 8;
$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($col_w['概況框'], $col_h['畢業後'], '七、畢業後計畫', 1, 'C', false, 0, '', '', true, 0, false, true, $col_h['畢業後'], 'M');

// 補個粗框線
$col_x['瞭解我'] = $pdf->GetX();
$pdf->Cell($col_w['編號欄'] + $col_w['長概況'], $col_h['畢業後'], '', 1, 0, "C", false, '', 1);
$pdf->SetLineWidth(0.2);

$col_w['標題寬'] = 42;
$col_h['內容值'] = $cell_6 * 2;
$col_w['剩餘寬'] = $col_w['編號欄'] + $col_w['長概況'] - $col_w['標題寬'];

$pdf->setX($col_x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($col_w['標題寬'], $col_h['內容值'], "升學意願\n（不升學者免填）", 1, 'C', false, 0, '', '', true, 4, false, true, $col_h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($col_w['剩餘寬'], $col_h['內容值'], $stu['post_graduation_plan']['further_education'], 1, 'L', false, 1, '', '', true, 0, false, true, $col_h['內容值'], 'M');

$pdf->setX($col_x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($col_w['標題寬'], $col_h['內容值'], "就業意願\n（升學者免填）", 1, 'C', false, 0, '', '', true, 4, false, true, $col_h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($col_w['剩餘寬'], $col_h['內容值'], $stu['post_graduation_plan']['employment'], 1, 'L', false, 1, '', '', true, 0, false, true, $col_h['內容值'], 'M');

$pdf->setX($col_x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($col_w['標題寬'], $col_h['內容值'], "如未能升學希望參加\n職業訓練種類及地區", 1, 'C', false, 0, '', '', true, 4, false, true, $col_h['內容值'], 'M');

$col_w['子標題'] = 25;
$col_w['剩餘寬'] = ($col_w['編號欄'] + $col_w['長概況'] - $col_w['標題寬'] - $col_w['子標題'] * 2) / 2;

$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['子標題'], $col_h['內容值'], '職訓種類：', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($col_w['剩餘寬'], $col_h['內容值'], $stu['post_graduation_plan']['training_kind'], 'TB', 'L', false, 0, '', '', true, 0, false, true, $col_h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['子標題'], $col_h['內容值'], '受訓地區：', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($col_w['剩餘寬'], $col_h['內容值'], $stu['post_graduation_plan']['training_zone'], 'TB', 'L', false, 1, '', '', true, 0, false, true, $col_h['內容值'], 'M');

$pdf->setX($col_x['瞭解我']);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell($col_w['標題寬'], $col_h['內容值'], "將來職業意願", 1, 'C', false, 0, '', '', true, 4, false, true, $col_h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['子標題'], $col_h['內容值'], '職業種類：', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($col_w['剩餘寬'], $col_h['內容值'], $stu['post_graduation_plan']['job_kind'], 'TB', 'L', false, 0, '', '', true, 0, false, true, $col_h['內容值'], 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($col_w['子標題'], $col_h['內容值'], '就業地區：', 'TB', 0, "C", false, '', 1);
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($col_w['剩餘寬'], $col_h['內容值'], $stu['post_graduation_plan']['job_zone'], 'TB', 'L', false, 1, '', '', true, 0, false, true, $col_h['內容值'], 'M');

// 八、備註
$col_h['備註欄'] = $cell_6 * 4;
$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->MultiCell($col_w['概況框'], $col_h['備註欄'], '八、備註', 1, 'C', false, 0, '', '', true, 0, false, true, $col_h['備註欄'], 'M');

// 補個粗框線
$col_x['瞭解我'] = $pdf->GetX();
$pdf->Cell($col_w['編號欄'] + $col_w['長概況'], $col_h['備註欄'], '', 1, 0, "C", false, '', 1);
$pdf->SetLineWidth(0.2);

$col_w['剩餘寬'] = $col_w['編號欄'] + $col_w['長概況'];

$pdf->setX($col_x['瞭解我']);
$pdf->SetTextColor(0, 0, 255);
$pdf->MultiCell($col_w['剩餘寬'], $col_h['備註欄'], $stu['note'], 1, 'L', false, 1, '', '', true, 0, false, true, $col_h['備註欄'], 'M');

$pdf_title = $pdf_title . "-{$stu['stu_no']}-{$stu['stu_name']}";
$pdf->Output($pdf_title . '.pdf', "D");
// $pdf->Output();
