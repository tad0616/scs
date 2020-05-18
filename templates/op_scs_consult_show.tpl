<h2 class="scs"><{$consult_date}> <{$stu.stu_name}>：<{$consult_reason}></h2>

<div class="alert alert-info">
    <{includeq file="$xoops_rootpath/modules/scs/templates/sub_year_grade_class_menu.tpl"}>
</div>

<div style="padding:20px 5px;font-size:1.1em;line-height:1.5;">
    <{$consult_note}>
</div>


<div class="alert alert-success">
    <span data-toggle="tooltip" title="<{$smarty.const._MD_SCS_CONSULT_DATE}>"><{$consult_date}></span>
    <span data-toggle="tooltip" title="<{$smarty.const._MD_SCS_CONSULT_TIME}>"><{$consult_start}>~<{$consult_end}></span>
    /
    <span data-toggle="tooltip" title="<{$smarty.const._MD_SCS_CONSULT_UID_NAME}>"><{$consult_uid_name}></span>
    /
    <span data-toggle="tooltip" title="<{$smarty.const._MD_SCS_CONSULT_MOTIVATION}>"><{$consult_motivation}></span>
    /
    <span data-toggle="tooltip" title="<{$smarty.const._MD_SCS_CONSULT_KIND}>"><{$consult_kind}></span>
    /
    <span data-toggle="tooltip" title="<{$smarty.const._MD_SCS_CONSULT_METHOD}>"><{$consult_method}></span>
</div>


<!-- All Files -->
<{$show_consult_id_files}>

<div class="text-right">
    <{if 'destroy'|have_consult_power:$stu_id:$consult_id}>
        <a href="javascript:scs_consult_destroy_func(<{$consult_id}>);" class="btn btn-danger"><i class="fa fa-trash-o"></i> <{$smarty.const._TAD_DEL}></a>
    <{/if}>
    <{if 'create'|have_consult_power:$stu_id}>
        <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_create&stu_id=<{$stu_id}>" class="btn btn-primary"><i class="fa fa-plus"></i>  新增輔導紀錄</a>
    <{/if}>
    <{if 'update'|have_consult_power:$stu_id:$consult_id}>
        <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_edit&consult_id=<{$consult_id}>&stu_id=<{$stu_id}>" class="btn btn-warning"><i class="fa fa-pencil"></i> <{$smarty.const._TAD_EDIT}></a>
    <{/if}>
</div>
