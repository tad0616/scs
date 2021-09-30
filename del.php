<?php
use XoopsModules\Tadtools\Utility;

include_once "../../mainfile.php";
include_once "header.php";

// 新增國小修正 xx_scs_data_center 用

$sql = "select * from `xx_scs_data_center` where `col_name`='school_year_class'";
$result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

while ($all = $xoopsDB->fetchArray($result)) {
    $class = substr($all['data_name'], 0, 3);
    //過濾讀出的變數值
    if (is_numeric($class)) {
        $v = explode("-", $all['data_name']);
        $v[1] += 6;

        $sql = "update `xx_scs_data_center` set `data_name`='{$v[0]}-{$v[1]}-{$v[2]}' where `mid`='{$all['mid']}' and `col_name`='{$all['col_name']}' and `col_sn`='{$all['col_sn']}' and `data_name`='{$all['data_name']}' and `data_sort`='{$all['data_sort']}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        echo "$sql<br>";
    }

}
