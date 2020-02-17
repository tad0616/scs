<?php
namespace XoopsModules\Scs;

use XoopsModules\Scs\Scs_consult;
use XoopsModules\Scs\Tools;
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
    public static function index($stu_id)
    {
        global $xoopsDB, $xoopsTpl;

        $myts = \MyTextSanitizer::getInstance();

        $stu = Scs_students::get($stu_id);
        $xoopsTpl->assign('stu', $stu);

        $TadUpFiles = new TadUpFiles("scs");
        $sql = "select * from `" . $xoopsDB->prefix("scs_consult") . "` where `stu_id`='{$stu_id}'";

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
            $all['stu_id'] = $myts->htmlSpecialChars($all['stu_id']);
            $all['consult_date'] = $myts->htmlSpecialChars($all['consult_date']);
            $all['consult_start'] = substr($myts->htmlSpecialChars($all['consult_start']), 0, 5);
            $all['consult_end'] = substr($myts->htmlSpecialChars($all['consult_end']), 0, 5);
            $all['consult_motivation'] = $myts->htmlSpecialChars($all['consult_motivation']);
            $all['consult_kind'] = $myts->htmlSpecialChars($all['consult_kind']);
            $all['consult_reason'] = $myts->htmlSpecialChars($all['consult_reason']);
            $all['consult_method'] = $myts->htmlSpecialChars($all['consult_method']);
            $all['consult_note'] = $myts->displayTarea($all['consult_note'], 0, 1, 0, 1, 1);

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
        Tools::chk_have_power();
        $xoopsTpl->assign('consult_id', $consult_id);

        //抓取預設值
        $DBV = !empty($consult_id) ? self::get($consult_id) : [];

        $DBV['consult_date'] = empty($DBV['consult_date']) ? date("Y-m-d") : $DBV['consult_date'];
        $DBV['consult_start'] = empty($DBV['consult_start']) ? date("H:i") : $DBV['consult_start'];
        $DBV['consult_end'] = empty($DBV['consult_end']) ? date("H:i", time() + 1800) : $DBV['consult_end'];

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
    }

    //新增資料到scs_consult中
    public static function store()
    {
        global $xoopsDB, $xoopsUser;
        Tools::chk_have_power();

        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();

        $consult_id = (int) $_POST['consult_id'];
        $stu_id = $myts->addSlashes($_POST['stu_id']);
        $consult_date = $myts->addSlashes($_POST['consult_date']);
        $consult_start = $myts->addSlashes($_POST['consult_start']);
        $consult_end = $myts->addSlashes($_POST['consult_end']);
        $consult_motivation = $myts->addSlashes($_POST['consult_motivation']);
        $consult_kind = $myts->addSlashes($_POST['consult_kind']);
        $consult_reason = $myts->addSlashes($_POST['consult_reason']);
        $consult_method = $myts->addSlashes($_POST['consult_method']);
        $consult_note = $myts->addSlashes($_POST['consult_note']);

        $sql = "replace into `" . $xoopsDB->prefix("scs_consult") . "` (
        `stu_id`,
        `consult_date`,
        `consult_start`,
        `consult_end`,
        `consult_motivation`,
        `consult_kind`,
        `consult_reason`,
        `consult_method`,
        `consult_note`
        ) values(
        '{$stu_id}',
        '{$consult_date}',
        '{$consult_start}',
        '{$consult_end}',
        '{$consult_motivation}',
        '{$consult_kind}',
        '{$consult_reason}',
        '{$consult_method}',
        '{$consult_note}'
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

        //過濾讀出的變數值
        $all['consult_id'] = (int) $all['consult_id'];
        $all['stu_id'] = $myts->htmlSpecialChars($all['stu_id']);
        $all['consult_date'] = $myts->htmlSpecialChars($all['consult_date']);
        $all['consult_start'] = $myts->htmlSpecialChars($all['consult_start']);
        $all['consult_end'] = $myts->htmlSpecialChars($all['consult_end']);
        $all['consult_motivation'] = $myts->htmlSpecialChars($all['consult_motivation']);
        $all['consult_kind'] = $myts->htmlSpecialChars($all['consult_kind']);
        $all['consult_reason'] = $myts->htmlSpecialChars($all['consult_reason']);
        $all['consult_method'] = $myts->htmlSpecialChars($all['consult_method']);
        $all['consult_note'] = $myts->displayTarea($all['consult_note'], 0, 1, 0, 1, 1);

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
        $show_consult_id_files = $TadUpFiles->show_files('up_consult_id', true, 'thumb', true, false, null, null, false);
        $xoopsTpl->assign('show_consult_id_files', $show_consult_id_files);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('scs_consult_destroy_func', "{$_SERVER['PHP_SELF']}?op=scs_consult_destroy&stu_id={$stu_id}&consult_id=", "consult_id");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    }

    //更新scs_consult某一筆資料
    public static function update($consult_id = '')
    {
        global $xoopsDB, $xoopsUser;
        Tools::chk_have_power();

        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();

        $consult_id = (int) $_POST['consult_id'];
        $stu_id = $myts->addSlashes($_POST['stu_id']);
        $consult_date = $myts->addSlashes($_POST['consult_date']);
        $consult_start = $myts->addSlashes($_POST['consult_start']);
        $consult_end = $myts->addSlashes($_POST['consult_end']);
        $consult_motivation = $myts->addSlashes($_POST['consult_motivation']);
        $consult_kind = $myts->addSlashes($_POST['consult_kind']);
        $consult_reason = $myts->addSlashes($_POST['consult_reason']);
        $consult_method = $myts->addSlashes($_POST['consult_method']);
        $consult_note = $myts->addSlashes($_POST['consult_note']);

        $sql = "update `" . $xoopsDB->prefix("scs_consult") . "` set
        `stu_id` = '{$stu_id}',
        `consult_date` = '{$consult_date}',
        `consult_start` = '{$consult_start}',
        `consult_end` = '{$consult_end}',
        `consult_motivation` = '{$consult_motivation}',
        `consult_kind` = '{$consult_kind}',
        `consult_reason` = '{$consult_reason}',
        `consult_method` = '{$consult_method}',
        `consult_note` = '{$consult_note}'
        where `consult_id` = '$consult_id'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $TadUpFiles = new TadUpFiles("scs");
        $TadUpFiles->set_col("consult_id", $consult_id);
        $TadUpFiles->upload_file('up_consult_id', '', '', '', '', true, false);
        return $consult_id;
    }

    //刪除scs_consult某筆資料資料
    public static function destroy($consult_id = '')
    {
        global $xoopsDB;
        Tools::chk_have_power();

        if (empty($consult_id)) {
            return;
        }

        $sql = "delete from `" . $xoopsDB->prefix("scs_consult") . "`
        where `consult_id` = '{$consult_id}'";
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
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("scs_consult") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            $consult_id = $data['consult_id'];
            $data_arr[$consult_id] = $data;
        }
        return $data_arr;
    }

}
