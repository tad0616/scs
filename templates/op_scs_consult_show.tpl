<h2><{$consult_date}> <{$stu.stu_name}>：<{$consult_reason}></h2>

<div class="alert alert-info">
    <{includeq file="$xoops_rootpath/modules/scs/templates/sub_year_grade_class_menu.tpl"}>
</div>

<div style="padding:20px 5px;">
    <{$consult_note}>
</div>


<div class="alert alert-success">
    <span data-toggle="tooltip" title="<{$smarty.const._MD_SCS_CONSULT_DATE}>"><{$consult_date}></span>
    <span data-toggle="tooltip" title="<{$smarty.const._MD_SCS_CONSULT_START}>"><{$consult_start}></span>
    ～
    <span data-toggle="tooltip" title="<{$smarty.const._MD_SCS_CONSULT_END}>"><{$consult_end}></span>
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
    <{if $smarty.session.scs_adm}>
        <a href="javascript:scs_consult_destroy_func(<{$consult_id}>);" class="btn btn-danger"><i class="fa fa-trash-o"></i> <{$smarty.const._TAD_DEL}></a>
        <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_create&stu_id=<{$stu_id}>" class="btn btn-info"><i class="fa fa-plus"></i>  新增諮商紀錄</a>
        <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_edit&consult_id=<{$consult_id}>&stu_id=<{$stu_id}>" class="btn btn-warning"><i class="fa fa-pencil"></i> <{$smarty.const._TAD_EDIT}></a>
    <{/if}>
</div>
