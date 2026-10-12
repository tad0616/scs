<h2 class="scs text-center"><{$student.stu_name}>綜合資料紀錄表</h2>

<div class="alert alert-info">
    <{include file="$xoops_rootpath/modules/scs/templates/sub_year_grade_class_menu.tpl"}>
</div>
<{if $edit_able or ($smarty.session.stu_id=='' and 'show'|have_scs_power:$student.stu_id)}>
    <table class="frame" style="width:100%;background: white;">
        <tr>
            <td>
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show0.tpl"}>
            </td>
            <td>
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show0_1.tpl"}>
            </td>
            <td>
                <{if $show_stu_id_files|default:false}>
                    <{$show_stu_id_files|default:''}>
                    <!-- <img src="<{$show_stu_id_files|default:''}>" alt="<{$student.stu_name}>" style="width:100%"> -->
                <{else}>
                    尚無照片
                <{/if}>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <!-- 一、本人概況 -->
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show1.tpl"}>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <!-- 二、家長狀況 -->
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show2.tpl"}>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <!-- 三、學習狀況 -->
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show3.tpl"}>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <!-- 四、自傳 -->
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show4.tpl"}>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <!-- 五、自我認識 -->
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show5.tpl"}>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <!-- 六、生活感想 -->
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show6.tpl"}>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <!-- 七、畢業後計畫 -->
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show7.tpl"}>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <!-- 八、備註 -->
                <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_show8.tpl"}>
            </td>
        </tr>
    </table>

    <div class="bar">
        <{if $smarty.session.stu_id and 'update'|have_scs_power:$smarty.session.stu_id}>
            <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit&stu_id=<{$smarty.session.stu_id}>" class="btn btn-warning"><i class="fa fa-pencil"></i> <{$smarty.const._TAD_EDIT}></a>
        <{elseif 'update'|have_scs_power:$stu_id}>
            <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit&stu_id=<{$stu_id|default:''}>" class="btn btn-warning"><i class="fa fa-pencil"></i> <{$smarty.const._TAD_EDIT}></a>
        <{/if}>
        <{if 'destroy'|have_scs_power:$stu_id}>
            <a href="javascript:scs_students_destroy_func(<{$stu_id|default:''}>);" class="btn btn-danger"><i class="fa fa-trash"></i> <{$smarty.const._TAD_DEL}></a>
        <{/if}>
        <{if 'create'|have_scs_power}>
            <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_create" class="btn btn-primary"><i class="fa fa-plus"></i> <{$smarty.const._TAD_ADD}></a>
        <{/if}>
        <a href="<{$xoops_url}>/modules/scs/" class="btn btn-success"><i class="fa fa-undo"></i> 回列表</a>
    </div>

<{else}>
    <div class="alert alert-danger">
        <h2>尚未開放填寫</h2>
    </div>
<{/if}>