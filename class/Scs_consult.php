<?php
namespace XoopsModules\Scs;

use XoopsModules\Scs\Scs_consult;
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

class Scs_consult
{
    //列出所有 scs_consult 資料
    public static function index($stu_id, $start = '', $end = '')
    {
        global $xoopsDB, $xoopsTpl;
        Tools::chk_consult_power(__FILE__, __LINE__, 'index', $stu_id);

        $myts = \MyTextSanitizer::getInstance();

        $stu = Scs_students::get($stu_id);
        $xoopsTpl->assign('stu', $stu);

        $TadUpFiles = new TadUpFiles("scs");

        $and_start = !empty($start) ? "and `consult_date` >= '{$start}'" : '';
        $and_end = !empty($end) ? "and `consult_date` <= '{$end}'" : '';

        $sql = "select * from `" . $xoopsDB->prefix("scs_consult") . "` where `stu_id`='{$stu_id}' $and_start $and_end";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar = $PageBar['bar'];
        $sql = $PageBar['sql'];
        $total = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $all_scs_consult = [];
        while ($all = $xoopsDB->fetchArray($result)) {
            //過濾讀出的變數值
            $all['consult_id'] = (int) $all['consult_id'];
            $all['stu_id'] = (int) $all['stu_id'];
            $all['stu_grade'] = (int) $all['stu_grade'];
            $all['stu_class'] = (int) $all['stu_class'];
            $all['stu_seat_no'] = (int) $all['stu_seat_no'];
            $all['consult_date'] = $myts->htmlSpecialChars($all['consult_date']);
            list($y, $m, $d) = explode('-', $all['consult_date']);
            $cy = $y - 1911;
            $all['consult_cdate'] = "{$cy}.{$m}.{$d}";
            $all['consult_start'] = substr($myts->htmlSpecialChars($all['consult_start']), 0, 5);
            $all['consult_end'] = substr($myts->htmlSpecialChars($all['consult_end']), 0, 5);
            $all['consult_motivation'] = $myts->htmlSpecialChars($all['consult_motivation']);
            $all['consult_kind'] = $myts->htmlSpecialChars($all['consult_kind']);
            $all['consult_reason'] = $myts->htmlSpecialChars($all['consult_reason']);
            $all['consult_method'] = $myts->htmlSpecialChars($all['consult_method']);
            $all['consult_note'] = $myts->displayTarea($all['consult_note'], 0, 1, 0, 1, 1);
            $all['consult_uid'] = (int) $all['consult_uid'];
            $all['consult_uid_name'] = \XoopsUser::getUnameFromId($all['consult_uid'], 1);

            $all_scs_consult[] = $all;
        }

        //刪除確認的JS
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('scs_consult_destroy_func',
            "{$_SERVER['PHP_SELF']}?op=scs_consult_destroy&stu_id={$stu_id}&consult_id=", "consult_id");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_scs_consult', $all_scs_consult);
    }

    //scs_consult編輯表單
    public static function create($consult_id = '', $stu_id = '')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        if (empty($stu_id)) {
            redirect_header('index.php', 3, '未指定學生');
        }
        Tools::chk_consult_power(__FILE__, __LINE__, 'create', $stu_id);
        $xoopsTpl->assign('consult_id', $consult_id);

        //抓取預設值
        $DBV = !empty($consult_id) ? self::get($consult_id) : [];

        $DBV['consult_date'] = empty($DBV['consult_date']) ? date("Y-m-d") : $DBV['consult_date'];
        $DBV['consult_start'] = empty($DBV['consult_start']) ? date("H:i") : $DBV['consult_start'];
        $DBV['consult_end'] = empty($DBV['consult_end']) ? '' : $DBV['consult_end'];

        $xoopsTpl->assign('DBV', $DBV);

        $stu_id = !empty($DBV['stu_id']) ? $DBV['stu_id'] : $stu_id;
        $stu = Scs_students::get($stu_id);
        $xoopsTpl->assign('stu', $stu);

        $op = empty($consult_id) ? "scs_consult_store" : "scs_consult_update";

        //套用formValidator驗證機制
        $formValidator = new FormValidator("#myForm", true);
        $formValidator->render();

        //上傳表單
        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->set_col("consult_id", $consult_id);
        $up_consult_id_create = $TadUpFiles->upform(true, "up_consult_id", "");
        $xoopsTpl->assign('up_consult_id_create', $up_consult_id_create);

        Tools::get_config_arr('scs_consult', 'consult_motivation');
        Tools::get_config_arr('scs_consult', 'consult_kind');
        Tools::get_config_arr('scs_consult', 'consult_method');

        //加入Token安全機制
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $token = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $xoopsTpl->assign("token_form", $token_form);
        $xoopsTpl->assign('action', $_SERVER["PHP_SELF"]);
        $xoopsTpl->assign('next_op', $op);

        DataList::render();
    }

    //新增資料到scs_consult中
    public static function store()
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();

        $consult_id = (int) $_POST['consult_id'];
        $stu_id = (int) $_POST['stu_id'];
        $stu_grade = (int) $_POST['stu_grade'];
        $stu_class = (int) $_POST['stu_class'];
        $stu_seat_no = (int) $_POST['stu_seat_no'];
        Tools::chk_consult_power(__FILE__, __LINE__, 'create', $stu_id);
        $consult_date = $myts->addSlashes($_POST['consult_date']);
        $consult_start = $myts->addSlashes($_POST['consult_start']);
        $consult_end = $myts->addSlashes($_POST['consult_end']);
        $consult_motivation = $myts->addSlashes($_POST['consult_motivation']);
        $consult_kind = $myts->addSlashes($_POST['consult_kind']);
        $consult_reason = $myts->addSlashes($_POST['consult_reason']);
        $consult_method = $myts->addSlashes($_POST['consult_method']);
        $consult_note = $myts->addSlashes($_POST['consult_note']);
        $consult_uid = $xoopsUser->uid();

        $sql = "replace into `" . $xoopsDB->prefix("scs_consult") . "` (
        `stu_id`,
        `stu_grade`,
        `stu_class`,
        `stu_seat_no`,
        `consult_date`,
        `consult_start`,
        `consult_end`,
        `consult_motivation`,
        `consult_kind`,
        `consult_reason`,
        `consult_method`,
        `consult_note`,
        `consult_uid`
        ) values(
        '{$stu_id}',
        '{$stu_grade}',
        '{$stu_class}',
        '{$stu_seat_no}',
        '{$consult_date}',
        '{$consult_start}',
        '{$consult_end}',
        '{$consult_motivation}',
        '{$consult_kind}',
        '{$consult_reason}',
        '{$consult_method}',
        '{$consult_note}',
        '{$consult_uid}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $consult_id = $xoopsDB->getInsertId();

        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->set_col("consult_id", $consult_id);
        $TadUpFiles->upload_file('up_consult_id', '', '', '', '', true, false);
        return $consult_id;
    }

    //以流水號秀出某筆scs_consult資料內容
    public static function show($consult_id = '', $stu_id = '')
    {
        global $xoopsDB, $xoopsTpl;

        if (empty($consult_id)) {
            return;
        } else {
            $consult_id = (int) $consult_id;
        }

        $myts = \MyTextSanitizer::getInstance();

        $all = self::get($consult_id);

        Tools::chk_consult_power(__FILE__, __LINE__, 'show', $all['stu_id'], $consult_id);

        //過濾讀出的變數值
        $all['consult_id'] = (int) $all['consult_id'];
        $all['stu_id'] = (int) $all['stu_id'];
        $all['stu_grade'] = (int) $all['stu_grade'];
        $all['stu_class'] = (int) $all['stu_class'];
        $all['stu_seat_no'] = (int) $all['stu_seat_no'];
        $all['consult_date'] = $myts->htmlSpecialChars($all['consult_date']);
        list($y, $m, $d) = explode('-', $all['consult_date']);
        $cy = $y - 1911;
        $all['consult_cdate'] = "{$cy}.{$m}.{$d}";
        $all['consult_start'] = $myts->htmlSpecialChars($all['consult_start']);
        $all['consult_end'] = $myts->htmlSpecialChars($all['consult_end']);
        $all['consult_motivation'] = $myts->htmlSpecialChars($all['consult_motivation']);
        $all['consult_kind'] = $myts->htmlSpecialChars($all['consult_kind']);
        $all['consult_reason'] = $myts->htmlSpecialChars($all['consult_reason']);
        $all['consult_method'] = $myts->htmlSpecialChars($all['consult_method']);
        $all['consult_note'] = $myts->displayTarea($all['consult_note'], 0, 1, 0, 1, 1);
        $all['consult_uid'] = (int) $all['consult_uid'];
        $all['consult_uid_name'] = \XoopsUser::getUnameFromId($all['consult_uid'], 1);
        if (empty($all['consult_uid_name'])) {
            $all['consult_uid_name'] = \XoopsUser::getUnameFromId($all['consult_uid'], 0);
        }

        $stu_id = !empty($all['stu_id']) ? $all['stu_id'] : $stu_id;
        $stu = Scs_students::get($stu_id);
        $xoopsTpl->assign('stu', $stu);

        //以下會產生這些變數： $stu_id, $consult_date, $consult_start, $consult_end, $consult_motivation, $consult_kind, $consult_reason, $consult_method, $consult_note
        foreach ($all as $k => $v) {
            $$k = $v;
            $xoopsTpl->assign($k, $v);
        }

        //上傳工具
        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->set_col("consult_id", $consult_id);
        $show_consult_id_files = $TadUpFiles->show_files('up_consult_id', true, 'thumb', true, false, null, XOOPS_URL . "/modules/scs/consult.php?op=tufdl&stu_id=$stu_id&consult_id=$consult_id", false, 0, false, '', false, '_blank');
        $xoopsTpl->assign('show_consult_id_files', $show_consult_id_files);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('scs_consult_destroy_func', "{$_SERVER['PHP_SELF']}?op=scs_consult_destroy&stu_id={$stu_id}&consult_id=", "consult_id");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    }

    //更新scs_consult某一筆資料
    public static function update($consult_id = '')
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();

        $consult_id = (int) $_POST['consult_id'];
        $stu_id = (int) $_POST['stu_id'];
        $stu_grade = (int) $_POST['stu_grade'];
        $stu_class = (int) $_POST['stu_class'];
        $stu_seat_no = (int) $_POST['stu_seat_no'];
        Tools::chk_consult_power(__FILE__, __LINE__, 'update', $stu_id, $consult_id);
        $consult_date = $myts->addSlashes($_POST['consult_date']);
        $consult_start = $myts->addSlashes($_POST['consult_start']);
        $consult_end = $myts->addSlashes($_POST['consult_end']);
        $consult_motivation = $myts->addSlashes($_POST['consult_motivation']);
        $consult_kind = $myts->addSlashes($_POST['consult_kind']);
        $consult_reason = $myts->addSlashes($_POST['consult_reason']);
        $consult_method = $myts->addSlashes($_POST['consult_method']);
        $consult_note = $myts->addSlashes($_POST['consult_note']);
        $consult_uid = $xoopsUser->uid();

        $sql = "update `" . $xoopsDB->prefix("scs_consult") . "` set
        `stu_id` = '{$stu_id}',
        `stu_grade` = '{$stu_grade}',
        `stu_grade` = '{$stu_grade}',
        `stu_seat_no` = '{$stu_seat_no}',
        `consult_date` = '{$consult_date}',
        `consult_start` = '{$consult_start}',
        `consult_end` = '{$consult_end}',
        `consult_motivation` = '{$consult_motivation}',
        `consult_kind` = '{$consult_kind}',
        `consult_reason` = '{$consult_reason}',
        `consult_method` = '{$consult_method}',
        `consult_note` = '{$consult_note}',
        `consult_uid` = '{$consult_uid}'
        where `consult_id` = '$consult_id'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->set_col("consult_id", $consult_id);
        $TadUpFiles->upload_file('up_consult_id', '', '', '', '', true, false);
        return $consult_id;
    }

    //刪除scs_consult某筆資料資料
    public static function destroy($stu_id = '', $consult_id = '')
    {
        global $xoopsDB;
        Tools::chk_consult_power(__FILE__, __LINE__, 'destroy', $stu_id, $consult_id);

        if (empty($consult_id) or empty($stu_id)) {
            return;
        }

        $and_consult_id = !empty($consult_id) ? "and `consult_id` = '$consult_id'" : '';

        $sql = "insert into " . $xoopsDB->prefix("scs_consult_del") . " select *
        from " . $xoopsDB->prefix("scs_consult") . " where `stu_id` = '{$stu_id}' $and_consult_id";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $sql = "delete from `" . $xoopsDB->prefix("scs_consult") . "`
        where `stu_id` = '{$stu_id}' $and_consult_id";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    //以流水號取得某筆scs_consult資料
    public static function get($consult_id = '')
    {
        global $xoopsDB;

        if (empty($consult_id)) {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("scs_consult") . "`
        where `consult_id` = '{$consult_id}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);
        return $data;
    }

    //取得scs_consult所有資料陣列
    public static function get_all($consult_uid = '', $stu_id = '', $start = '', $end = '')
    {
        global $xoopsDB;
        $and_consult_uid = !empty($consult_uid) ? "and a.`consult_uid` = '{$consult_uid}'" : '';
        $and_stu_id = !empty($stu_id) ? "and a.`stu_id` = '{$stu_id}'" : '';
        $and_start = !empty($start) ? "and a.`consult_date` >= '{$start}'" : '';
        $and_end = !empty($end) ? "and a.`consult_date` <= '{$end}'" : '';

        $sql = "select a.*, b.stu_name from `" . $xoopsDB->prefix("scs_consult") . "` as a
        join `" . $xoopsDB->prefix("scs_students") . "` as b on a.stu_id=b.stu_id
        where 1 {$and_consult_uid} {$and_stu_id} {$and_start} {$and_end} order by a.consult_date";

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            list($y, $m, $d) = explode('-', $data['consult_date']);
            $cy = $y - 1911;
            $data['consult_cdate'] = "{$cy}.{$m}.{$d}";
            $data['consult_name'] = \XoopsUser::getUnameFromId($data['consult_uid'], 1);
            if (empty($data['consult_name'])) {
                $data['consult_name'] = \XoopsUser::getUnameFromId($data['consult_uid'], 0);
            }
            $data['consult_start'] = substr($data['consult_start'], 0, -3);
            $data['consult_end'] = substr($data['consult_end'], 0, -3);
            $consult_id = $data['consult_id'];
            $data_arr[$consult_id] = $data;
        }
        return $data_arr;
    }

    //取得scs_consult統計資料
    public static function statistics_all($start = '', $end = '')
    {
        global $xoopsDB, $xoopsTpl;

        $sql = "select `col_sn`,`data_name`,`data_value` from `" . $xoopsDB->prefix("scs_data_center") . "`
        where `col_name`='school_year_class' and (`data_name`='counselor' or `data_name`='tutor') order by data_name";

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while (list($year, $kind, $uid) = $xoopsDB->fetchRow($result)) {
            $data_arr[$uid]['uid'] = $uid;
            $data_arr[$uid]['year'] = $year;
            $data_arr[$uid]['kind'] = $kind;
            $data_arr[$uid]['name'] = \XoopsUser::getUnameFromId($uid, 1);
            if (empty($data_arr[$uid]['name'])) {
                $data_arr[$uid]['name'] = \XoopsUser::getUnameFromId($uid, 0);
            }
            $data_arr[$uid]['num'] = sizeof(self::get_all($uid, '', $start, $end));
        }
        $xoopsTpl->assign('data_arr', $data_arr);
        return $data_arr;
    }

    //取得scs_consult統計資料
    public static function statistics($consult_uid = '', $start = '', $end = '', $mode = '')
    {
        global $xoopsDB, $xoopsTpl;
        if (empty($consult_uid)) {
            redirect_header('consult.php', 3, '未指定教師');
        }

        Tools::chk_consult_power(__FILE__, __LINE__, 'counselor_index', '', '', $consult_uid);

        $and_start = !empty($start) ? "and a.`consult_date` >= '{$start}'" : '';
        $and_end = !empty($end) ? "and a.`consult_date` <= '{$end}'" : '';

        $sql = "select a.*, b.stu_name from `" . $xoopsDB->prefix("scs_consult") . "` as a
        join `" . $xoopsDB->prefix("scs_students") . "` as b on a.stu_id=b.stu_id
        where a.`consult_uid`='$consult_uid' $and_start $and_end order by a.consult_date";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        if ($mode == '') {
            $PageBar = Utility::getPageBar($sql, 20, 10);
            $bar = $PageBar['bar'];
            $sql = $PageBar['sql'];
            $total = $PageBar['total'];
            $xoopsTpl->assign('bar', $bar);
            $xoopsTpl->assign('total', $total);
        }

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while ($consult = $xoopsDB->fetchArray($result)) {
            list($y, $m, $d) = explode('-', $consult['consult_date']);
            $cy = $y - 1911;
            $consult['consult_cdate'] = "{$cy}.{$m}.{$d}";
            $consult['month'] = $m;
            $consult['consult_start'] = substr($consult['consult_start'], 0, -3);
            $consult['consult_end'] = substr($consult['consult_end'], 0, -3);
            $consult['consult_week'] = date('w', strtotime($consult['consult_date']));
            $data_arr[] = $consult;
        }

        $consult_name = \XoopsUser::getUnameFromId($consult_uid, 1);
        if (empty($consult_name)) {
            $consult_name = \XoopsUser::getUnameFromId($consult_uid, 0);
        }

        if ($mode == "return") {
            $all['consult_uid'] = $consult_uid;
            $all['consult_name'] = $consult_name;
            $all['data_arr'] = $data_arr;
            return $all;

        } else {
            $xoopsTpl->assign('consult_uid', $consult_uid);
            $xoopsTpl->assign('consult_name', $consult_name);
            $xoopsTpl->assign('data_arr', $data_arr);
        }
    }

    //取得scs_consult期末統計資料
    public static function statistics_by_month($consult_uid = '', $start = '', $end = '', $mode = '')
    {
        global $xoopsDB, $xoopsTpl;
        if (empty($consult_uid)) {
            redirect_header('consult.php', 3, '未指定教師');
        }

        $and_start = !empty($start) ? "and a.`consult_date` >= '{$start}'" : '';
        $and_end = !empty($end) ? "and a.`consult_date` <= '{$end}'" : '';

        $sql = "select a.*, b.stu_name, b.stu_sex from `" . $xoopsDB->prefix("scs_consult") . "` as a
        join `" . $xoopsDB->prefix("scs_students") . "` as b on a.stu_id=b.stu_id
        where a.`consult_uid`='$consult_uid' $and_start $and_end
        order by a.consult_date";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        if ($mode == '') {
            $PageBar = Utility::getPageBar($sql, 20, 10);
            $bar = $PageBar['bar'];
            $sql = $PageBar['sql'];
            $total = $PageBar['total'];
            $xoopsTpl->assign('bar', $bar);
            $xoopsTpl->assign('total', $total);
        }

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = $times = [];
        while ($consult = $xoopsDB->fetchArray($result)) {
            list($y, $m, $d) = explode('-', $consult['consult_date']);
            $cy = $y - 1911;
            $consult['consult_cdate'] = "{$cy}.{$m}.{$d}";
            $consult['month'] = $m;
            $consult['consult_start'] = substr($consult['consult_start'], 0, -3);
            $consult['consult_end'] = substr($consult['consult_end'], 0, -3);
            $consult['consult_week'] = date('w', strtotime($consult['consult_date']));
            $stu_id = $consult['stu_id'];

            $data_arr[$m][$stu_id][] = $consult;
            $times[$m][$stu_id]++;
        }

        $consult_name = \XoopsUser::getUnameFromId($consult_uid, 1);
        if (empty($consult_name)) {
            $consult_name = \XoopsUser::getUnameFromId($consult_uid, 0);
        }

        if ($mode == "return") {
            $all['consult_uid'] = $consult_uid;
            $all['consult_name'] = $consult_name;
            $all['data_arr'] = $data_arr;
            $all['max_times'] = max(max($times));
            return $all;

        } else {
            $xoopsTpl->assign('consult_uid', $consult_uid);
            $xoopsTpl->assign('consult_name', $consult_name);
            $xoopsTpl->assign('data_arr', $data_arr);
            $xoopsTpl->assign('max_times', max(max($times)));
        }
    }

    //下載附檔
    public static function download($files_sn, $stu_id, $consult_id)
    {

        Tools::chk_consult_power(__FILE__, __LINE__, 'show', $stu_id, $consult_id);
        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->add_file_counter($files_sn, false, true);
    }
}
