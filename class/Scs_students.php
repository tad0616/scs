<?php
namespace XoopsModules\Scs;

use XoopsModules\Scs\Scs_students;
use XoopsModules\Scs\Tools;
use XoopsModules\Tadtools\DataList;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;
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

class Scs_students
{
    //列出所有 scs_students 資料
    public static function index()
    {
        global $xoopsDB, $xoopsTpl;

        $myts = \MyTextSanitizer::getInstance();

        $sql = "select * from `" . $xoopsDB->prefix("scs_students") . "` ";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar = $PageBar['bar'];
        $sql = $PageBar['sql'];
        $total = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $all_scs_students = [];
        while ($all = $xoopsDB->fetchArray($result)) {
            //過濾讀出的變數值
            $all['stu_id'] = (int) $all['stu_id'];
            $all['stu_no'] = $myts->htmlSpecialChars($all['stu_no']);
            $all['stu_name'] = $myts->htmlSpecialChars($all['stu_name']);
            $all['stu_pid'] = $myts->htmlSpecialChars($all['stu_pid']);
            $all['stu_sex'] = $myts->htmlSpecialChars($all['stu_sex']);
            $all['stu_birthday'] = $myts->htmlSpecialChars($all['stu_birthday']);
            $all['stu_blood'] = $myts->htmlSpecialChars($all['stu_blood']);
            $all['stu_religion'] = $myts->htmlSpecialChars($all['stu_religion']);
            $all['stu_residence'] = $myts->htmlSpecialChars($all['stu_residence']);
            $all['stu_birth_place'] = $myts->htmlSpecialChars($all['stu_birth_place']);
            $all['stu_email'] = $myts->htmlSpecialChars($all['stu_email']);
            $all['stu_residence_zip'] = $myts->htmlSpecialChars($all['stu_residence_zip']);
            $all['stu_residence_county'] = $myts->htmlSpecialChars($all['stu_residence_county']);
            $all['stu_residence_city'] = $myts->htmlSpecialChars($all['stu_residence_city']);
            $all['stu_residence_addr'] = $myts->htmlSpecialChars($all['stu_residence_addr']);
            $all['stu_zip'] = $myts->htmlSpecialChars($all['stu_zip']);
            $all['stu_county'] = $myts->htmlSpecialChars($all['stu_county']);
            $all['stu_city'] = $myts->htmlSpecialChars($all['stu_city']);
            $all['stu_addr'] = $myts->htmlSpecialChars($all['stu_addr']);
            $all['stu_tel1'] = $myts->htmlSpecialChars($all['stu_tel1']);
            $all['stu_tel2'] = $myts->htmlSpecialChars($all['stu_tel2']);
            $all['stu_identity'] = $myts->htmlSpecialChars($all['stu_identity']);
            $all['stu_education'] = $myts->displayTarea($all['stu_education'], 0, 1, 0, 1, 1);
            $all['stu_autobiography'] = $myts->displayTarea($all['stu_autobiography'], 0, 1, 0, 1, 1);
            $all['post_graduation_plan'] = $myts->displayTarea($all['post_graduation_plan'], 0, 1, 0, 1, 1);
            $all['note'] = $myts->displayTarea($all['note'], 0, 1, 0, 1, 1);
            $all['emergency_contact'] = $myts->displayTarea($all['emergency_contact'], 0, 1, 0, 1, 1);
            $all['physiological_defect'] = $myts->displayTarea($all['physiological_defect'], 0, 1, 0, 1, 1);
            $all['special_disease'] = $myts->displayTarea($all['special_disease'], 0, 1, 0, 1, 1);
            $all['ys'] = $myts->htmlSpecialChars($all['ys']);

            $all_scs_students[] = $all;
        }

        //刪除確認的JS
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('scs_students_destroy_func',
            "{$_SERVER['PHP_SELF']}?op=scs_students_destroy&stu_id=", "stu_id");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_scs_students', $all_scs_students);
    }

    //scs_students編輯表單
    public static function create($stu_id = '')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser, $xoopsModuleConfig;
        Tools::chk_have_power();

        //抓取預設值
        $DBV = !empty($stu_id) ? self::get($stu_id) : [];

        $xoopsTpl->assign('student', $DBV);
        //預設值設定

        Tools::get_config_arr('scs_students', 'stu_blood');
        Tools::get_config_arr('scs_students', 'stu_religion');
        Tools::get_config_arr('scs_students', 'stu_birth_place');
        Tools::get_config_arr('scs_students', 'stu_identity');

        $op = empty($stu_id) ? "scs_students_store" : "scs_students_update";

        //套用formValidator驗證機制
        $formValidator = new FormValidator("#myForm", true);
        $formValidator->render();

        //上傳表單
        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->set_col("stu_id", $stu_id);
        $TadUpFiles->set_var("show_tip", false);
        $TadUpFiles->set_thumb('150px', '100px', '#000000');
        $up_stu_id_create = $TadUpFiles->upform(false, "up_stu_id", "1", true, null, true, null, false);
        $xoopsTpl->assign('up_stu_id_create', $up_stu_id_create);

        //加入Token安全機制
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $token = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $xoopsTpl->assign("token_form", $token_form);
        $xoopsTpl->assign('action', $_SERVER["PHP_SELF"]);
        $xoopsTpl->assign('next_op', $op);

        DataList::render();
    }

    //新增資料到scs_students中
    public static function store($data = [], $check = true)
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        if ($check) {
            Tools::chk_have_power();
            Utility::xoops_security_check();
        }

        $myts = \MyTextSanitizer::getInstance();

        $stu_no = $myts->addSlashes($data['stu_no']);
        $stu_name = $myts->addSlashes($data['stu_name']);
        $stu_pid = $myts->addSlashes($data['stu_pid']);
        $stu_sex = $myts->addSlashes($data['stu_sex']);
        $stu_birthday = $myts->addSlashes($data['stu_birthday']);
        $stu_blood = $myts->addSlashes($data['stu_blood']);
        $stu_religion = $myts->addSlashes($data['stu_religion']);
        $stu_residence = $myts->addSlashes($data['stu_residence']);
        $stu_birth_place = $myts->addSlashes($data['stu_birth_place']);
        $stu_email = $myts->addSlashes($data['stu_email']);
        $stu_residence_zip = $myts->addSlashes($data['stu_residence_zip']);
        $stu_residence_county = $myts->addSlashes($data['stu_residence_county']);
        $stu_residence_city = $myts->addSlashes($data['stu_residence_city']);
        $stu_residence_addr = $myts->addSlashes($data['stu_residence_addr']);
        $stu_zip = $myts->addSlashes($data['stu_zip']);
        $stu_county = $myts->addSlashes($data['stu_county']);
        $stu_city = $myts->addSlashes($data['stu_city']);
        $stu_addr = $myts->addSlashes($data['stu_addr']);
        $stu_tel1 = $myts->addSlashes($data['stu_tel1']);
        $stu_tel2 = $myts->addSlashes($data['stu_tel2']);
        $stu_identity = $myts->addSlashes($data['stu_identity']);
        $stu_education = json_encode($data['stu_education'], 256);
        $stu_autobiography = json_encode($data['stu_autobiography'], 256);
        $post_graduation_plan = json_encode($data['post_graduation_plan'], 256);
        $note = $myts->addSlashes($data['note']);
        $emergency_contact = json_encode($data['emergency_contact'], 256);
        $physiological_defect = json_encode($data['physiological_defect'], 256);
        $special_disease = json_encode($data['special_disease'], 256);

        $sql = "replace into `" . $xoopsDB->prefix("scs_students") . "` (
        `stu_no`,
        `stu_name`,
        `stu_pid`,
        `stu_sex`,
        `stu_birthday`,
        `stu_blood`,
        `stu_religion`,
        `stu_residence`,
        `stu_birth_place`,
        `stu_email`,
        `stu_residence_zip`,
        `stu_residence_county`,
        `stu_residence_city`,
        `stu_residence_addr`,
        `stu_zip`,
        `stu_county`,
        `stu_city`,
        `stu_addr`,
        `stu_tel1`,
        `stu_tel2`,
        `stu_identity`,
        `stu_education`,
        `stu_autobiography`,
        `post_graduation_plan`,
        `note`,
        `emergency_contact`,
        `physiological_defect`,
        `special_disease`
        ) values(
        '{$stu_no}',
        '{$stu_name}',
        '{$stu_pid}',
        '{$stu_sex}',
        '{$stu_birthday}',
        '{$stu_blood}',
        '{$stu_religion}',
        '{$stu_residence}',
        '{$stu_birth_place}',
        '{$stu_email}',
        '{$stu_residence_zip}',
        '{$stu_residence_county}',
        '{$stu_residence_city}',
        '{$stu_residence_addr}',
        '{$stu_zip}',
        '{$stu_county}',
        '{$stu_city}',
        '{$stu_addr}',
        '{$stu_tel1}',
        '{$stu_tel2}',
        '{$stu_identity}',
        '{$stu_education}',
        '{$stu_autobiography}',
        '{$post_graduation_plan}',
        '{$note}',
        '{$emergency_contact}',
        '{$physiological_defect}',
        '{$special_disease}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $stu_id = $xoopsDB->getInsertId();

        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->set_col("stu_id", $stu_id);
        $TadUpFiles->upload_file('up_stu_id', '', '', '', '', true, false);
        return $stu_id;
    }

    //以流水號秀出某筆scs_students資料內容
    public static function show($stu_id = '')
    {
        global $xoopsDB, $xoopsTpl;

        if (empty($stu_id)) {
            return;
        } else {
            $stu_id = (int) $stu_id;
        }

        $myts = \MyTextSanitizer::getInstance();

        $all = self::get($stu_id);

        //以下會產生這些變數： $stu_no, $stu_name, $stu_pid, $stu_sex, $stu_birthday, $stu_blood, $stu_religion, $stu_residence, $stu_birth_place, $stu_email, $stu_residence_zip, $stu_residence_county, $stu_residence_city, $stu_residence_addr, $stu_zip, $stu_county, $stu_city, $stu_addr, $stu_tel1, $stu_tel2, $stu_identity, $stu_education, $stu_autobiography, $post_graduation_plan, $note, $emergency_contact, $physiological_defect, $special_disease
        $arr = [];

        foreach ($all as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $kk => $vv) {
                    $arr[$k][$kk] = empty($vv) ? '　' : $myts->htmlSpecialChars($vv);
                }
            } else {
                $arr[$k] = empty($v) ? '　' : $myts->htmlSpecialChars($v);
            }
        }
        $xoopsTpl->assign('student', $arr);

        //上傳工具
        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->set_var("show_width", "160px");
        $TadUpFiles->set_var("show_height", "160px");
        $TadUpFiles->set_var("background_size", "cover");
        $TadUpFiles->set_col("stu_id", $stu_id);
        $show_stu_id_files = $TadUpFiles->show_files('up_stu_id', false, 'thumb', false, false, null, null, false);
        $xoopsTpl->assign('show_stu_id_files', $show_stu_id_files);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('scs_students_destroy_func', "{$_SERVER['PHP_SELF']}?op=scs_students_destroy&stu_id=", "stu_id");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    }

    //更新scs_students某一筆資料
    public static function update($stu_id = '', $data = [], $check = true, $pass_empty = true)
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        if ($check) {
            Tools::chk_have_power();
            Utility::xoops_security_check();
        }

        $myts = \MyTextSanitizer::getInstance();
        $update_item = [];
        foreach ($data as $col => $val) {
            if (empty($val) and $pass_empty) {
                continue;
            }
            if (is_array($val)) {
                $arr = [];
                foreach ($val as $k => $v) {
                    $arr[$k] = $myts->addSlashes($v);
                }
                $$col = $val = json_encode($arr, 256);
            } else {
                $$col = $val = $myts->addSlashes($val);
            }

            $update_item[] = "`$col` = '{$val}'";

        }
        $update_sql = implode(", \n", $update_item);

        $sql = "
        INSERT INTO `" . $xoopsDB->prefix("scs_students") . "`(
            `stu_no`, `stu_name`, `stu_pid`, `stu_sex`, `stu_birthday`, `stu_blood`, `stu_religion`, `stu_residence`, `stu_birth_place`, `stu_email`, `stu_residence_zip`, `stu_residence_county`, `stu_residence_city`, `stu_residence_addr`, `stu_zip`, `stu_county`, `stu_city`, `stu_addr`, `stu_tel1`, `stu_tel2`, `stu_identity`, `stu_education`, `stu_autobiography`, `post_graduation_plan`, `note`, `emergency_contact`, `physiological_defect`, `special_disease`
        ) VALUES(
            '{$stu_no}', '{$stu_name}', '{$stu_pid}', '{$stu_sex}', '{$stu_birthday}', '{$stu_blood}', '{$stu_religion}', '{$stu_residence}', '{$stu_birth_place}', '{$stu_email}', '{$stu_residence_zip}', '{$stu_residence_county}', '{$stu_residence_city}', '{$stu_residence_addr}', '{$stu_zip}', '{$stu_county}', '{$stu_city}', '{$stu_addr}', '{$stu_tel1}', '{$stu_tel2}', '{$stu_identity}', '{$stu_education}', '{$stu_autobiography}', '{$post_graduation_plan}', '{$note}', '{$emergency_contact}', '{$physiological_defect}', '{$special_disease}'
            )
        ON DUPLICATE KEY UPDATE
        $update_sql";

        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        if (empty($stu_id)) {
            $stu_id = $xoopsDB->getInsertId();
        }

        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->set_col("stu_id", $stu_id);
        $TadUpFiles->upload_file('up_stu_id', '', '', '', '', true, false);
        return $stu_id;
    }

    //刪除scs_students某筆資料資料
    public static function destroy($stu_id = '')
    {
        global $xoopsDB;
        Tools::chk_have_power();

        if (empty($stu_id)) {
            return;
        }

        $sql = "delete from `" . $xoopsDB->prefix("scs_students") . "`
        where `stu_id` = '{$stu_id}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    //以流水號取得某筆scs_students資料
    public static function get($stu_id = '', $stu_pid = '')
    {
        global $xoopsDB;

        if (!empty($stu_id)) {
            $where = "where `stu_id` = '{$stu_id}'";
        } elseif (!empty($stu_pid)) {
            $where = "where `stu_pid` = '{$stu_pid}'";
        } else {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("scs_students") . "`
        $where";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);

        $data['stu_education'] = $data['stu_education'] ? json_decode($data['stu_education'], true) : [];
        $data['emergency_contact'] = $data['emergency_contact'] ? json_decode($data['emergency_contact'], true) : [];
        $data['physiological_defect'] = $data['physiological_defect'] ? json_decode($data['physiological_defect'], true) : [];
        $data['special_disease'] = $data['special_disease'] ? json_decode($data['special_disease'], true) : [];
        $data['stu_autobiography'] = $data['stu_autobiography'] ? json_decode($data['stu_autobiography'], true) : [];
        $data['post_graduation_plan'] = $data['post_graduation_plan'] ? json_decode($data['post_graduation_plan'], true) : [];
        $data['tw_birthday'] = Tools::tw_birthday($data['stu_birthday']);

        return $data;
    }

    //取得scs_students所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("scs_students") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            $stu_id = $data['stu_id'];
            $data_arr[$stu_id] = $data;
        }
        return $data_arr;
    }

}
