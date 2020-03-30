<?php
namespace XoopsModules\Scs;

use XoopsModules\Scs\Scs_brother_sister;
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

class Scs_brother_sister
{
    //列出所有 scs_brother_sister 資料
    public static function index()
    {
        global $xoopsDB, $xoopsTpl;
        $myts = \MyTextSanitizer::getInstance();

        $sql = "select * from `" . $xoopsDB->prefix("scs_brother_sister") . "` ";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar = $PageBar['bar'];
        $sql = $PageBar['sql'];
        $total = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $all_scs_brother_sister = [];
        while ($all = $xoopsDB->fetchArray($result)) {
            //過濾讀出的變數值
            $all['stu_id'] = (int) $all['stu_id'];
            $all['bs_name'] = $myts->htmlSpecialChars($all['bs_name']);
            $all['bs_relationship'] = $myts->htmlSpecialChars($all['bs_relationship']);
            $all['bs_year'] = $myts->htmlSpecialChars($all['bs_year']);
            $all['bs_school'] = $myts->htmlSpecialChars($all['bs_school']);
            $all['bs_note'] = $myts->htmlSpecialChars($all['bs_note']);

            $all_scs_brother_sister[] = $all;
        }

        //刪除確認的JS
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('scs_brother_sister_destroy_func',
            "{$_SERVER['PHP_SELF']}?op=scs_brother_sister_destroy&stu_id_bs_relationship=", "stu_id_bs_relationship");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_scs_brother_sister', $all_scs_brother_sister);
    }

    //scs_brother_sister編輯表單
    public static function create($stu_id)
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        Tools::chk_scs_power('create');

        //抓取預設值
        $DBV = !empty($stu_id) ? self::get($stu_id) : [];

        $xoopsTpl->assign('brother_sister', $DBV);

        $xoopsTpl->assign('bs_relationship_arr', ['', '兄', '弟', '姊', '妹']);
    }

    //新增資料到scs_brother_sister中
    public static function store($stu_id, $data = [], $check = true)
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        if ($check) {
            Tools::chk_scs_power('create');
            Utility::xoops_security_check();
        }

        $myts = \MyTextSanitizer::getInstance();

        $bs_name = $myts->addSlashes($data['bs_name']);
        $bs_relationship = $myts->addSlashes($data['bs_relationship']);
        $bs_year = $myts->addSlashes($data['bs_year']);
        $bs_school = $myts->addSlashes($data['bs_school']);
        $bs_note = $myts->addSlashes($data['bs_note']);

        $sql = "replace into `" . $xoopsDB->prefix("scs_brother_sister") . "` (
        `stu_id`,
        `bs_name`,
        `bs_relationship`,
        `bs_year`,
        `bs_school`,
        `bs_note`
        ) values(
        '{$stu_id}',
        '{$bs_name}',
        '{$bs_relationship}',
        '{$bs_year}',
        '{$bs_school}',
        '{$bs_note}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }

    //以流水號秀出某筆scs_brother_sister資料內容
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

        //以下會產生這些變數： $stu_id, $bs_name, $bs_relationship, $bs_year, $bs_school, $bs_note
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

        $xoopsTpl->assign('brother_sister', $arr);
    }

    //更新scs_brother_sister某一筆資料
    public static function update($stu_id, $data = [], $check = true)
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        if ($check) {
            Tools::chk_scs_power('update', $stu_id);
            Utility::xoops_security_check();
        }

        $myts = \MyTextSanitizer::getInstance();

        foreach ($data as $col => $arr) {
            foreach ($arr as $key => $val) {
                $$col[$key] = $myts->addSlashes($val);
            }
        }

        foreach ($bs_relationship as $k => $relationship) {
            if (empty($relationship)) {
                continue;
            }
            $sql = "
            INSERT INTO `" . $xoopsDB->prefix("scs_brother_sister") . "`(
                `stu_id`,
                `bs_name`,
                `bs_relationship`,
                `bs_year`,
                `bs_school`,
                `bs_note`
            ) VALUES(
                '{$stu_id}',
                '{$bs_name[$k]}',
                '{$relationship}',
                '{$bs_year[$k]}',
                '{$bs_school[$k]}',
                '{$bs_note[$k]}'
                )
            ON DUPLICATE KEY UPDATE
                `stu_id` = '{$stu_id}',
                `bs_name` = '{$bs_name[$k]}',
                `bs_relationship` = '{$relationship}',
                `bs_year` = '{$bs_year[$k]}',
                `bs_school` = '{$bs_school[$k]}',
                `bs_note` = '{$bs_note[$k]}'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
    }

    //刪除scs_brother_sister某筆資料資料
    public static function destroy($stu_id = '', $bs_relationship = '')
    {
        global $xoopsDB;
        Tools::chk_scs_power('destroy', $stu_id);

        if (empty($stu_id) or empty($bs_relationship)) {
            return;
        }

        $and_bs_relationship = !empty($bs_relationship) ? "and `bs_relationship` = '$bs_relationship'" : '';

        $sql = "delete from `" . $xoopsDB->prefix("scs_brother_sister") . "`
        where `stu_id` = '$stu_id' $and_bs_relationship";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    //以流水號取得某筆scs_brother_sister資料
    public static function get($stu_id = '', $bs_relationship = '')
    {
        global $xoopsDB;

        if (empty($stu_id)) {
            return;
        }

        $my_rank = 1;
        $and_bs_relationship = $bs_relationship ? "and `bs_relationship` = '{$bs_relationship}'" : '';

        $sql = "select * from `" . $xoopsDB->prefix("scs_brother_sister") . "`
        where `stu_id` = '$stu_id' {$and_bs_relationship} order by bs_year";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        $k = 1;
        while ($data = $xoopsDB->fetchArray($result)) {
            $data_arr[$k] = $data;
            $k++;
            if ($data['bs_relationship'] == "兄" or $data['bs_relationship'] == "姊") {
                $my_rank++;
            }
        }
        $data_arr['my_rank'] = $my_rank;
        return $data_arr;
    }

    //取得scs_brother_sister所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("scs_brother_sister") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            $stu_id = $data['stu_id'];
            $bs_relationship = $data['bs_relationship'];
            $data_arr[$stu_id][$bs_relationship] = $data;
        }
        return $data_arr;
    }

}
