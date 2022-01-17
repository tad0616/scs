<?php
use Xmf\Request;
use XoopsModules\Scs\Scs_general;
use XoopsModules\Scs\Scs_guardian;
use XoopsModules\Scs\Scs_parents;
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
$GLOBALS['xoopsOption']['template_main'] = 'scs_adm_main.tpl';
require_once __DIR__ . '/header.php';
if (!class_exists('XoopsModules\Scs\Tools')) {
    require XOOPS_ROOT_PATH . '/modules/scs/preloads/autoloader.php';
}
require_once dirname(__DIR__) . '/function.php';
$_SESSION['scs_adm'] = true;

/*-----------功能函數區----------*/

//匯入 Excel（國中版）
function scs_import_excel_jh($mode = 'scs_import_excel')
{
    global $xoopsTpl, $xoopsModuleConfig;

    $stu_blood_arr = explode(';', $xoopsModuleConfig['stu_blood']);

    require XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
    $reader = \PHPExcel_IOFactory::createReader('Excel2007');
    $PHPExcel = $reader->load($_FILES['userfile']['tmp_name']); // 檔案名稱

    $sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
    $highestRow = $sheet->getHighestRow(); // 取得總列數
    $colString = $sheet->getHighestDataColumn();
    $highestColumn = \PHPExcel_Cell::columnIndexFromString($colString);

    $cell = $sheet->getCellByColumnAndRow(0, 1);
    $val = get_value_of_cell($cell);

    preg_match_all('/\d+/', $val, $matches, PREG_OFFSET_CAPTURE);
    $school_year = $matches[0][0][0];
    $semester = $matches[0][1][0];

    $myts = MyTextSanitizer::getInstance();
    $data = $students = array();
    for ($row = 3; $row <= $highestRow; $row++) {
        //讀取一列中的每一格
        for ($col = 0; $col < $highestColumn; $col++) {
            $cell = $sheet->getCellByColumnAndRow($col, $row);
            $val = $myts->addSlashes(get_value_of_cell($cell));
            $data[$row][$col] = $val;
            switch ($col) {
                case '1':
                    // 年級
                    if (empty($students[1]['scs_general']['stu_grade'])) {
                        $students[1]['scs_general']['stu_grade'] = '年級';
                        $students[1]['scs_general']['school_year'] = '學年度';
                        $students[1]['scs_general']['fill_date'] = '填寫日';
                    }

                    if ($val < 4) {
                        $val += 6;
                    }

                    $students[$row]['scs_general']['stu_grade'][$val] = $grade = $val;
                    $students[$row]['scs_general']['school_year'][$grade] = $school_year;
                    $students[$row]['scs_general']['fill_date'][$grade] = '';
                    break;
                case '2':
                    // 班級
                    if (empty($students[1]['scs_general']['stu_class'])) {
                        $students[1]['scs_general']['stu_class'] = '班級';
                    }
                    $students[$row]['scs_general']['stu_class'][$grade] = $val;
                    break;
                case '3':
                    // 座號
                    if (empty($students[1]['scs_general']['stu_seat_no'])) {
                        $students[1]['scs_general']['stu_seat_no'] = '座號';
                    }
                    $students[$row]['scs_general']['stu_seat_no'][$grade] = $val;
                    break;
                case '6':
                    // 學號
                    if (empty($students[1]['scs_students']['stu_no'])) {
                        $students[1]['scs_students']['stu_no'] = '學號';
                    }
                    $students[$row]['scs_students']['stu_no'] = $val;
                    break;
                case '7':
                    // 學生姓名
                    if (empty($students[1]['scs_students']['stu_name'])) {
                        $students[1]['scs_students']['stu_name'] = '學生姓名';
                    }
                    $students[$row]['scs_students']['stu_name'] = $val;
                    break;
                case '11':
                    // 身分證號碼
                    if (empty($students[1]['scs_students']['stu_pid'])) {
                        $students[1]['scs_students']['stu_pid'] = '身分證號碼';
                    }
                    $students[$row]['scs_students']['stu_pid'] = strtoupper($val);
                    break;
                case '13':
                    // 僑居地
                    if (empty($students[1]['scs_students']['stu_residence'])) {
                        $students[1]['scs_students']['stu_residence'] = '僑居地';
                    }
                    $students[$row]['scs_students']['stu_residence'] = $val;
                    break;
                case '14':
                    // 性別
                    if (empty($students[1]['scs_students']['stu_sex'])) {
                        $students[1]['scs_students']['stu_sex'] = '性別';
                    }
                    $students[$row]['scs_students']['stu_sex'] = $val;
                    break;
                case '15':
                    // 血型
                    if (empty($students[1]['scs_students']['stu_blood'])) {
                        $students[1]['scs_students']['stu_blood'] = '血型';
                    }
                    $val = in_array($val, $stu_blood_arr) ? $val : '';
                    $students[$row]['scs_students']['stu_blood'] = $val;
                    break;
                case '17':
                    // 生日西元年
                    if (empty($students[1]['scs_students']['stu_birthday'])) {
                        $students[1]['scs_students']['stu_birthday'] = '生日西元年';
                    }
                    $students[$row]['scs_students']['stu_birthday'] = $val;
                    break;
                case '18':
                    // 出生地
                    if (empty($students[1]['scs_students']['stu_birth_place'])) {
                        $students[1]['scs_students']['stu_birth_place'] = '出生地';
                    }
                    $val = str_replace('台', '臺', $val);
                    $students[$row]['scs_students']['stu_birth_place'] = $val;
                    break;
                // case '22':
                //     // 學生身份別
                //     if (empty($students[1]['scs_students']['stu_identity'])) {
                //         $students[1]['scs_students']['stu_identity'] = '學生身份別';
                //     }
                //     list($stu_identity) = explode(',', $val);
                //     $students[$row]['scs_students']['stu_identity'] = $stu_identity;
                //     break;
                case '26':
                    // 畢業小學校名
                    if (empty($students[1]['scs_students']['stu_education'])) {
                        $students[1]['scs_students']['stu_education'] = '畢業小學校名';
                    }
                    $students[$row]['scs_students']['stu_education']['g_school'] = $val;
                    break;
                case '29':
                    //畢修業日期
                    if (empty($students[1]['scs_students']['stu_education'])) {
                        $students[1]['scs_students']['stu_education'] = '畢修業日期';
                    }
                    if (empty($val)) {
                        $val = substr($students[$row]['scs_students']['stu_no'], 0, 3);
                    }
                    $students[$row]['scs_students']['stu_education']['g_time'] = $val;
                    $students[$row]['scs_students']['stu_education']['i_time'] = $val;
                    break;
                case '32':
                    // 戶籍郵遞區號
                    if (empty($students[1]['scs_students']['stu_residence_zip'])) {
                        $students[1]['scs_students']['stu_residence_zip'] = '郵遞區號';
                    }
                    $students[$row]['scs_students']['stu_residence_zip'] = $val;
                    break;
                case '33':
                    // 戶籍縣市
                    if (empty($students[1]['scs_students']['stu_residence_county'])) {
                        $students[1]['scs_students']['stu_residence_county'] = '戶籍縣市';
                    }
                    $students[$row]['scs_students']['stu_residence_county'] = $val;
                    break;
                case '34':
                    // 戶籍鄉鎮市區
                    if (empty($students[1]['scs_students']['stu_residence_city'])) {
                        $students[1]['scs_students']['stu_residence_city'] = '戶籍鄉鎮市區';
                    }
                    $students[$row]['scs_students']['stu_residence_city'] = $val;
                    break;
                case '35':
                    // 戶籍村里
                    if (empty($students[1]['scs_students']['stu_residence_addr'])) {
                        $students[1]['scs_students']['stu_residence_addr'] = '戶籍村里地址';
                    }
                    $students[$row]['scs_students']['stu_residence_addr'] = $val;
                    break;
                case '36':
                    $students[$row]['scs_students']['stu_residence_addr'] .= $val;
                    break;
                case '37':
                    // 戶籍路
                    $students[$row]['scs_students']['stu_residence_addr'] .= $val;
                    break;
                case '39':
                    // 通訊郵遞區號
                    if (empty($students[1]['scs_students']['stu_zip'])) {
                        $students[1]['scs_students']['stu_zip'] = '通訊郵遞區號';
                        $students[1]['scs_students']['emergency_contact'] = '緊急聯絡人地址';
                        $students[1]['scs_guardian']['guardian_addr'] = '監護人地址';
                    }
                    $students[$row]['scs_students']['stu_zip'] = $val;
                    $students[$row]['scs_students']['emergency_contact']['addr'] = $val;
                    $students[$row]['scs_guardian']['guardian_addr'] = $val;
                    break;
                case '40':
                    // 通訊縣市
                    if (empty($students[1]['scs_students']['stu_county'])) {
                        $students[1]['scs_students']['stu_county'] = '通訊縣市';
                    }
                    $students[$row]['scs_students']['stu_county'] = $val;
                    $students[$row]['scs_students']['emergency_contact']['addr'] .= $val;
                    $students[$row]['scs_guardian']['guardian_addr'] .= $val;
                    break;
                case '41':
                    // 通訊鄉鎮市區
                    if (empty($students[1]['scs_students']['stu_city'])) {
                        $students[1]['scs_students']['stu_city'] = '通訊鄉鎮市區';
                    }
                    $students[$row]['scs_students']['stu_city'] = $val;
                    $students[$row]['scs_students']['emergency_contact']['addr'] .= $val;
                    $students[$row]['scs_guardian']['guardian_addr'] .= $val;
                    break;
                case '42':
                    // 通訊村里
                    if (empty($students[1]['scs_students']['stu_addr'])) {
                        $students[1]['scs_students']['stu_addr'] = '通訊村里地址';
                    }
                    $students[$row]['scs_students']['stu_addr'] = $val;
                    $students[$row]['scs_students']['emergency_contact']['addr'] .= $val;
                    $students[$row]['scs_guardian']['guardian_addr'] .= $val;
                    break;
                case '43':
                    // 通訊鄰
                    $students[$row]['scs_students']['stu_addr'] .= $val;
                    $students[$row]['scs_students']['emergency_contact']['addr'] .= $val;
                    $students[$row]['scs_guardian']['guardian_addr'] .= $val;
                    break;
                case '44':
                    // 通訊路
                    $students[$row]['scs_students']['stu_addr'] .= $val;
                    $students[$row]['scs_students']['emergency_contact']['addr'] .= $val;
                    $students[$row]['scs_guardian']['guardian_addr'] .= $val;
                    break;
                case '46':
                    // 家長1姓名
                    if (empty($students[1]['scs_parents']['家長1'])) {
                        $students[1]['scs_parents']['家長1'] = '家長1資訊';
                    }
                    $students[$row]['scs_parents']['家長1']['parent_name'] = $val;
                    break;
                case '47':
                    // 與家長1關係
                    $students[$row]['scs_parents']['家長1']['parent_kind'] = '父';
                    break;
                case '48':
                    //家長1存歿
                    $students[$row]['scs_parents']['家長1']['parent_survive'] = $val;
                    break;
                case '49':
                    // 家長1職業別
                    $students[$row]['scs_parents']['家長1']['parent_company'] = $val;
                    $students[$row]['scs_parents']['家長1']['parent_job'] = '';
                    break;
                case '50':
                    // 家長1職稱
                    $students[$row]['scs_parents']['家長1']['parent_title'] = $val;
                    break;
                case '51':
                    // 家長1服務單位
                    if ($val and empty($students[$row]['scs_parents']['家長1']['parent_company'])) {
                        $students[$row]['scs_parents']['家長1']['parent_company'] = $val;
                    }

                    break;
                case '52':
                    // 家長1出生年
                    $students[$row]['scs_parents']['家長1']['parent_year'] = $val;
                    break;
                case '53':
                    // 家長1電話公
                    if (empty($students[1]['scs_students']['stu_tel1'])) {
                        $students[1]['scs_students']['stu_tel1'] = '電話1';
                    }
                    if (substr($val, 0, 1) == 9) {
                        $val = "0{$val}";
                    }
                    $students[$row]['scs_parents']['家長1']['parent_company_tel'] = $val;
                    $students[$row]['scs_students']['stu_tel1'] = $val;

                    break;
                case '54':
                    // 家長1電話宅
                    if ($val and empty($students[$row]['scs_parents']['家長1']['parent_company_tel'])) {
                        if (substr($val, 0, 1) == 9) {
                            $val = "0{$val}";
                        }
                        $students[$row]['scs_parents']['家長1']['parent_company_tel'] = $val;
                    }
                    if ($val and empty($students[$row]['scs_students']['stu_tel1'])) {
                        if (substr($val, 0, 1) == 9) {
                            $val = "0{$val}";
                        }
                        $students[$row]['scs_students']['stu_tel1'] = $val;
                    }
                    break;
                case '55':
                    // 家長1行動電話
                    if (empty($students[1]['scs_students']['stu_tel2'])) {
                        $students[1]['scs_students']['stu_tel2'] = '電話2';
                    }
                    if (substr($val, 0, 1) == 9) {
                        $val = "0{$val}";
                    }
                    $students[$row]['scs_parents']['家長1']['parent_phone'] = $val;
                    $students[$row]['scs_students']['stu_tel2'] = $val;
                    break;
                case '56':
                    // 家長1電子郵件
                    $students[$row]['scs_parents']['家長1']['parent_email'] = $val;
                    break;
                case '57':
                    // 家長2姓名
                    if (empty($students[1]['scs_parents']['家長2'])) {
                        $students[1]['scs_parents']['家長2'] = '家長2資料';
                    }
                    $students[$row]['scs_parents']['家長2']['parent_name'] = $val;
                    break;
                case '58':
                    // 與家長2關係
                    $students[$row]['scs_parents']['家長2']['parent_kind'] = '母';
                    break;
                case '59':
                    //家長2存歿
                    $students[$row]['scs_parents']['家長2']['parent_survive'] = $val;
                    break;
                case '60':
                    // 家長2職業別
                    $students[$row]['scs_parents']['家長2']['parent_company'] = $val;
                    $students[$row]['scs_parents']['家長2']['parent_job'] = '';
                    break;
                case '61':
                    // 家長2職稱
                    $students[$row]['scs_parents']['家長2']['parent_title'] = $val;
                    break;
                case '62':
                    // 家長2服務單位
                    if ($val and empty($students[$row]['scs_parents']['家長2']['parent_company'])) {
                        $students[$row]['scs_parents']['家長2']['parent_company'] = $val;
                    }

                    break;
                case '63':
                    // 家長2出生年
                    $students[$row]['scs_parents']['家長2']['parent_year'] = $val;
                    break;
                case '64':
                    // 家長2電話公
                    if (substr($val, 0, 1) == 9) {
                        $val = "0{$val}";
                    }
                    $students[$row]['scs_parents']['家長2']['parent_company_tel'] = $val;
                    break;
                case '65':
                    // 家長2電話宅
                    if ($val and empty($students[$row]['scs_parents']['家長2']['parent_company_tel'])) {
                        if (substr($val, 0, 1) == 9) {
                            $val = "0{$val}";
                        }
                        $students[$row]['scs_parents']['家長2']['parent_company_tel'] = $val;
                    }
                    break;
                case '66':
                    // 家長2行動電話
                    if (substr($val, 0, 1) == 9) {
                        $val = "0{$val}";
                    }
                    $students[$row]['scs_parents']['家長2']['parent_phone'] = $val;
                    if ($val and empty($students[$row]['scs_students']['stu_tel2'])) {
                        $students[$row]['scs_students']['stu_tel2'] = $val;
                    }
                    break;
                case '67':
                    // 家長2電子郵件
                    $students[$row]['scs_parents']['家長2']['parent_email'] = $val;
                    break;
                case '68':
                    // 監護人姓名
                    if (empty($students[1]['scs_guardian']['guardian_name'])) {
                        $students[1]['scs_guardian']['guardian_name'] = '監護人姓名';
                    }
                    $students[$row]['scs_guardian']['guardian_name'] = $val;
                    break;
                case '69':
                    // 與監護人關係
                    if (empty($students[1]['scs_guardian']['guardian_title'])) {
                        $students[1]['scs_guardian']['guardian_title'] = '監護人關係';
                        $students[1]['scs_guardian']['guardian_sex'] = '監護人性別';
                    }
                    $students[$row]['scs_guardian']['guardian_title'] = $val;
                    $students[$row]['scs_guardian']['guardian_sex'] = strpos($val, '父') !== false ? '男' : '女';
                    break;
                case '75':
                    // 監護人行動電話
                    if (empty($students[1]['scs_guardian']['guardian_tel'])) {
                        $students[1]['scs_guardian']['guardian_tel'] = '監護人行動電話';
                    }
                    if (substr($val, 0, 1) == 9) {
                        $val = "0{$val}";
                    }
                    $students[$row]['scs_guardian']['guardian_tel'] = $val;
                    break;
                case '77':
                    // 聯絡人姓名
                    if (empty($students[1]['scs_students']['emergency_contact'])) {
                        $students[1]['scs_students']['emergency_contact'] = '緊急聯絡人';
                    }
                    $students[$row]['scs_students']['emergency_contact']['name'] = $val;
                    break;
                case '78':
                    // 與聯絡人關係
                    $students[$row]['scs_students']['emergency_contact']['title'] = $val;
                    break;
                case '79':
                    // 聯絡人電話公
                    if ($val) {
                        if (substr($val, 0, 1) == 9) {
                            $val = "0{$val}";
                        }
                        $students[$row]['scs_students']['emergency_contact']['tel'] = $val;
                        $students[$row]['scs_students']['stu_tel1'] = $val;
                    }
                    break;
                case '80':
                    // 聯絡人電話宅
                    if ($val) {
                        if (substr($val, 0, 1) == 9) {
                            $val = "0{$val}";
                        }
                        $students[$row]['scs_students']['emergency_contact']['tel'] = $val;
                        if (empty($students[$row]['scs_students']['stu_tel1'])) {
                            $students[$row]['scs_students']['stu_tel1'] = $val;
                        }

                    }
                    break;
                case '81':
                    // 聯絡人行動電話
                    if ($val) {
                        if (substr($val, 0, 1) == 9) {
                            $val = "0{$val}";
                        }
                        $students[$row]['scs_students']['emergency_contact']['tel'] = $val;
                        $students[$row]['scs_students']['stu_tel2'] = $val;
                    }
                    break;
            }
        }
    }

    if ($mode == 'scs_import_to_db_jh') {
        scs_import_to_db_jh($students);

    } else {
        $xoopsTpl->assign('school_year', $school_year);
        $xoopsTpl->assign('semester', $semester);
        $xoopsTpl->assign('all_data', $data);
        $xoopsTpl->assign('students', $students);
    }
}

//針對excel各種數據類型
function get_value_of_cell($cell = "")
{
    if (is_null($cell)) {
        $value = $cell->setIterateOnlyExistingCells(true);
    } else {
        if (strstr($cell->getValue(), '=')) {
            $value = $cell->getCalculatedValue();
        } elseif ($cell->getValue() instanceof PHPExcel_RichText) {
            $value = $cell->getValue()->getPlainText();
        } elseif (PHPExcel_Shared_Date::isDateTime($cell)) {
            $value = PHPExcel_Shared_Date::ExcelToPHPObject($cell->getValue())->format('Y-m-d');
        } else {
            $value = $cell->getValue();
        }
    }
    return $value;
}

function scs_import_to_db_jh($students = [])
{
    $i = 0;

    foreach ($students as $student) {

        if (!is_numeric($student['scs_students']['stu_no'])) {
            continue;
        }

        $stud = [];

        // 學生基本資料
        foreach ($student['scs_students'] as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $kk => $vv) {
                    $stud[$k][$kk] = $vv;
                }
            } else {
                $stud[$k] = $v;
            }
        }

        $stu = Scs_students::get('', $stud['stu_pid']);
        $stu_id = $stu['stu_id'];
        $stu_id = Scs_students::update($stu_id, $stud, false);

        if ($stu_id > 0) {
            // 學生學年度資料
            Scs_general::update($stu_id, $student['scs_general'], false);

            // 學生家長資料
            Scs_parents::update($stu_id, $student['scs_parents'], false);

            // 學生監護人資料
            Scs_guardian::update($stu_id, $student['scs_guardian'], false);
            $i++;
        }
    }
    redirect_header('../index.php', 3, "匯入完成，共匯入 $i 筆資料。");
}

/*-----------變數過濾----------*/
$op = Request::getString('op');
$students = Request::getArray('students');
$school_year = Request::getInt('school_year');
$mode = Request::getString('mode');

/*-----------執行動作判斷區----------*/
switch ($op) {

    case 'scs_import_excel_jh':
        scs_import_excel_jh($mode);
        break;

    case 'scs_import_to_db_jh':
        scs_import_to_db_jh($students);
        exit;

    default:
        $op = 'scs_import_stu_jh';
        $xoopsTpl->assign('school_year', Tools::get_school_year());
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet('/modules/tadtools/css/font-awesome/css/font-awesome.css');
if ($_SEESION['bootstrap'] == 3) {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm3.css');
} else {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm4.css');
}
require_once __DIR__ . '/footer.php';
