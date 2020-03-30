<{if $all_scs_general}>
    <h2>
    <{$school_year}>學年度
    <{if $stu_grade}>
        <{$stu_grade}>年
    <{/if}>
    <{if $stu_class}>
        <{$stu_class}>班
    <{/if}>
    所有學生
    </h2>

    <div class="alert alert-info">
        <{includeq file="$xoops_rootpath/modules/scs/templates/sub_year_grade_class_menu.tpl"}>
    </div>

    <table class="table table-striped table-hover table-condensed table-bordered">
        <thead>
            <tr class="info">

                <!--班級-->
                <th>
                    <{$smarty.const._MD_SCS_STU_CLASS}>
                </th>
                <!--座號-->
                <th>
                    <{$smarty.const._MD_SCS_STU_SEAT_NO}>
                </th>
                <!--姓名-->
                <th>
                    <{$smarty.const._MD_SCS_STU_NAME}>
                </th>
                <!--學號-->
                <th>
                    <{$smarty.const._MD_SCS_STU_NO}>
                </th>
                <!--性別-->
                <th>
                    <{$smarty.const._MD_SCS_STU_SEX}>
                </th>
                <!--生日-->
                <th>
                    <{$smarty.const._MD_SCS_STU_BIRTHDAY}>
                </th>
                <!--緊急聯絡人姓名-->
                <th>
                    緊急聯絡人
                </th>

                <!--緊急聯絡人電話-->
                <th>
                    聯絡人電話
                </th>
                <!--填寫日期-->
                <th>
                    <{$smarty.const._MD_SCS_FILL_DATE}>
                </th>
                <{if 'show'|have_scs_power:$data.stu_id or 'update'|have_scs_power:$data.stu_id or 'index'|have_consult_power:$data.stu_id}>
                    <th><{$smarty.const._TAD_FUNCTION}></th>
                <{/if}>
            </tr>
        </thead>

        <tbody id="scs_general_sort">
            <{foreach from=$all_scs_general item=data}>
                <tr id="tr_<{$data.stud_id}>">

                    <!--班級-->
                    <td>
                        <{$data.stu_grade}>-<{$data.stu_class}>
                    </td>

                    <!--座號-->
                    <td>
                        <{$data.stu_seat_no}>
                    </td>

                    <!--姓名-->
                    <td>
                        <a href="index.php?stu_id=<{$data.stu_id}>"><{$data.stu_name}></a>
                    </td>

                    <!--學號-->
                    <td>
                        <{$data.stu_no}>
                    </td>

                    <!--性別-->
                    <td>
                        <{$data.stu_sex}>
                    </td>

                    <!--生日-->
                    <td>
                        <{$data.stu_birthday}>
                    </td>

                    <!--緊急聯絡人姓名-->
                    <td>
                        <{$data.emergency_contact.name}>
                    </td>

                    <!--緊急聯絡人電話-->
                    <td>
                        <{$data.emergency_contact.tel}>
                    </td>

                    <!--填寫日期-->
                    <td>
                        <{$data.fill_date}>
                    </td>

                    <td nowrap>
                        <{if 'index'|have_consult_power:$data.stu_id:$data.school_year:$data.stu_grade:$data.stu_class}>
                            <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_index&stu_id=<{$data.stu_id}>" class="btn btn-sm btn-primary" title="<{$data.stu_name}>的個別諮商" data-toggle="tooltip"><i class="fa fa-heart" aria-hidden="true"></i></a>
                        <{/if}>
                        <{if 'update'|have_scs_power:$data.stu_id}>
                            <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit&school_year=<{$data.school_year}>&stu_id=<{$data.stu_id}>" class="btn btn-sm btn-warning" title="編輯<{$data.stu_name}>綜合資料紀錄表" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                        <{/if}>
                    </td>
                </tr>
            <{/foreach}>
        </tbody>
    </table>



    <{if 'create'|have_scs_power}>
        <div class="text-right">
            <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        </div>
    <{/if}>

    <{$bar}>
<{else}>
    <h2>無任何資料</h2>
    <div class="jumbotron text-center">
        請先至臺南市學籍系統匯出所有學生資料，並於<a href="admin/main.php">後台進行匯入</a>。
        <{if 'create'|have_scs_power}>
            <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit" class="btn btn-info">
            <i class="fa fa-plus"></i> 手動新增
            </a>
        <{/if}>
    </div>
<{/if}>
