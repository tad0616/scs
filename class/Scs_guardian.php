<?php
namespace XoopsModules\Scs;

use XoopsModules\Scs\Scs_guardian;
use XoopsModules\Scs\Tools;
use XoopsModules\Tadtools\SweetAlert;
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

class Scs_guardian
{
    //列出所有 scs_guardian 資料
    public static function index()
    {
        global $xoopsDB, $xoopsTpl;
        $myts = \MyTextSanitizer::getInstance();

        $sql = "select * from `" . $xoopsDB->prefix("scs_guardian") . "` ";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar = $PageBar['bar'];
        $sql = $PageBar['sql'];
        $total = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $all_scs_guardian = [];
        while ($all = $xoopsDB->fetchArray($result)) {
            //過濾讀出的變數值
            $all['stu_id'] = (int) $all['stu_id'];
            $all['guardian_name'] = $myts->htmlSpecialChars($all['guardian_name']);
            $all['guardian_sex'] = $myts->htmlSpecialChars($all['guardian_sex']);
            $all['guardian_title'] = $myts->htmlSpecialChars($all['guardian_title']);
            $all['guardian_tel'] = $myts->htmlSpecialChars($all['guardian_tel']);
            $all['guardian_addr'] = $myts->htmlSpecialChars($all['guardian_addr']);

            $all_scs_guardian[] = $all;
        }

        //刪除確認的JS
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('scs_guardian_destroy_func',
            "{$_SERVER['PHP_SELF']}?op=scs_guardian_destroy&stu_id=", "stu_id");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_scs_guardian', $all_scs_guardian);
    }

    //scs_guardian編輯表單
    public static function create($stu_id = '')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        Tools::chk_scs_power('create');

        //抓取預設值
        $DBV = !empty($stu_id) ? self::get($stu_id) : [];
        $xoopsTpl->assign('guardian', $DBV);

        Tools::get_config_arr('scs_guardian', 'guardian_title');

    }

    //新增資料到scs_guardian中
    public static function store($stu_id, $data = [], $check = true)
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        if ($check) {
            Tools::chk_scs_power('create');
            Utility::xoops_security_check();
        }

        $myts = \MyTextSanitizer::getInstance();

        $guardian_name = $myts->addSlashes($data['guardian_name']);
        $guardian_sex = $myts->addSlashes($data['guardian_sex']);
        $guardian_title = $myts->addSlashes($data['guardian_title']);
        $guardian_tel = $myts->addSlashes($data['guardian_tel']);
        $guardian_addr = $myts->addSlashes($data['guardian_addr']);

        $sql = "replace into `" . $xoopsDB->prefix("scs_guardian") . "` (
            `stu_id`,
            `guardian_name`,
            `guardian_sex`,
            `guardian_title`,
            `guardian_tel`,
            `guardian_addr`
        ) values(
            '{$stu_id}',
            '{$guardian_name}',
            '{$guardian_sex}',
            '{$guardian_title}',
            '{$guardian_tel}',
            '{$guardian_addr}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }

    //以流水號秀出某筆scs_guardian資料內容
    public static function show($stu_id = '')
    {
        global $xoopsDB, $xoopsTpl;

        if (empty($stu_id)) {
            return;
        } else {
            $stu_id = (int) $stu_id;
        }
        Tools::chk_scs_power('show', $stu_id);

        $myts = \MyTextSanitizer::getInstance();

        $all = self::get($stu_id);

        //以下會產生這些變數： $guardian_name, $guardian_sex, $guardian_title, $guardian_tel, $guardian_addr
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
        $xoopsTpl->assign('guardian', $arr);
    }

    //更新scs_guardian某一筆資料
    public static function update($stu_id = '', $data = [], $check = true, $pass_empty = true)
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        if ($check) {
            Tools::chk_scs_power('update', $stu_id);
            Utility::xoops_security_check();
        }

        $myts = \MyTextSanitizer::getInstance();
        $update_item = [];
        foreach ($data as $col => $val) {
            if (empty($val) and $pass_empty) {
                continue;
            }
            $$col = $val = $myts->addSlashes($val);
            $update_item[] = "`$col` = '{$val}'";
        }
        $update_sql = implode(', ', $update_item);

        $sql = "
        INSERT INTO `" . $xoopsDB->prefix("scs_guardian") . "`(
            `stu_id`,
            `guardian_name`,
            `guardian_sex`,
            `guardian_title`,
            `guardian_tel`,
            `guardian_addr`
        ) VALUES(
            '{$stu_id}',
            '{$guardian_name}',
            '{$guardian_sex}',
            '{$guardian_title}',
            '{$guardian_tel}',
            '{$guardian_addr}'
            )
        ON DUPLICATE KEY UPDATE
        $update_sql";

        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }

    //刪除scs_guardian某筆資料資料
    public static function destroy($stu_id = '')
    {
        global $xoopsDB;
        Tools::chk_scs_power('destroy', $stu_id);

        if (empty($stu_id)) {
            return;
        }

        $sql = "delete from `" . $xoopsDB->prefix("scs_guardian") . "`
        where `stu_id` = '{$stu_id}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    //以流水號取得某筆scs_guardian資料
    public static function get($stu_id = '')
    {
        global $xoopsDB;

        if (empty($stu_id)) {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("scs_guardian") . "`
        where `stu_id` = '{$stu_id}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);
        return $data;
    }

    //取得scs_guardian所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("scs_guardian") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            $stu_id = $data['stu_id'];
            $data_arr[$stu_id] = $data;
        }
        return $data_arr;
    }

}
