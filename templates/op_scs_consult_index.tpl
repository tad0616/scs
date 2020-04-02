<h2 class="scs">「<{$stu.stu_name}>」個別諮商紀錄列表</h2>

<div class="alert alert-info">
    <{includeq file="$xoops_rootpath/modules/scs/templates/sub_year_grade_class_menu.tpl"}>
</div>
<div class="alert alert-success">
    <{includeq file="$xoops_rootpath/modules/scs/templates/sub_consult_date_menu.tpl"}>
</div>
<{if $all_scs_consult}>

    <div id="scs_consult_save_msg"></div>

    <table class="table table-striped table-hover" style="background:white;">
        <thead>
            <tr class="info">
                <!--會談日期-->
                <th>
                    會談日期
                </th>
                <!--會談時間-->
                <th>
                    會談時間
                </th>
                <!--來談動機-->
                <th>
                    <{$smarty.const._MD_SCS_CONSULT_MOTIVATION}>
                </th>
                <!--問題類別-->
                <th>
                    <{$smarty.const._MD_SCS_CONSULT_KIND}>
                </th>
                <!--主要原因-->
                <th>
                    <{$smarty.const._MD_SCS_CONSULT_REASON}>
                </th>
                <!--處理方式-->
                <th>
                    <{$smarty.const._MD_SCS_CONSULT_METHOD}>
                </th>
                <th>
                    諮商者
                </th>
                <th>
                    <{$smarty.const._TAD_FUNCTION}>
                </th>
            </tr>
        </thead>

        <tbody id="scs_consult_sort">
            <{foreach from=$all_scs_consult item=data}>
                <{assign var=can_view value='show'|have_consult_power:$stu_id:$data.consult_id}>
                <tr id="tr_<{$data.consult_id}>">

                        <!--會談日期-->
                        <td>
                            <{$data.consult_cdate}>
                        </td>
                        <!--會談時間-->
                        <td>
                            <{$data.consult_time}>
                        </td>

                        <!--來談動機-->
                        <td>
                            <{$data.consult_motivation}>
                        </td>

                        <!--問題類別-->
                        <td>
                            <{$data.consult_kind}>
                        </td>

                        <!--主要原因-->
                        <td>
                            <{if $can_view}>
                                <a href="<{$xoops_url}>/modules/scs/consult.php?stu_id=<{$data.stu_id}>&consult_id=<{$data.consult_id}>">
                                <{$data.consult_reason}>
                                </a>
                                <{$data.files}>
                            <{else}>
                                無權觀看
                            <{/if}>
                        </td>

                        <!--處理方式-->
                        <td>
                            <{$data.consult_method}>
                        </td>

                        <!--諮商者-->
                        <td>
                            <{if $can_view}>
                                <a href="consult.php?consult_uid=<{$data.consult_uid}>"><{$data.consult_uid_name}></a>
                            <{else}>
                                <{$data.consult_uid_name}>
                            <{/if}>
                        </td>
                        <td nowrap>
                        <{if 'destroy'|have_consult_power:$data.stu_id:$data.consult_id}>
                            <a href="javascript:scs_consult_destroy_func(<{$data.consult_id}>);" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                        <{/if}>
                        <{if 'update'|have_consult_power:$data.stu_id:$data.consult_id}>
                            <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_edit&consult_id=<{$data.consult_id}>&stu_id=<{$data.stu_id}>" class="btn btn-sm btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>
                        <{/if}>

                        </td>
                </tr>
            <{/foreach}>
        </tbody>
    </table>
    <{$bar}>
<{else}>
    <div class="jumbotron text-center">
        <{if 'create'|have_consult_power:$stu_id}>
            <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_create&stu_id=<{$stu_id}>" class="btn btn-primary">
            <i class="fa fa-plus"></i> 新增諮商紀錄
            </a>
        <{else}>
            <h4><{$smarty.const._TAD_EMPTY}></h4>
        <{/if}>
    </div>
<{/if}>
