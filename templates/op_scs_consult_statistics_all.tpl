<h2  class="scs">輔導報表及統計</h2>
<div class="alert alert-success">
    <{includeq file="$xoops_rootpath/modules/scs/templates/sub_consult_date_menu.tpl"}>
</div>
<table class="table table-striped table-hover" style="background:white;">
    <thead>
        <tr class="info">
            <th>
                姓名
            </th>
            <th>
                所有輔導紀錄
            </th>
            <th>
                個別輔導期末報表
            </th>
            <th>
                個別輔導月報表
            </th>
            <th>
                教育部每月輔導統計
            </th>
        </tr>
    </thead>

    <tbody id="scs_consult_sort">
        <{foreach from=$data_arr key=uid item=data}>
            <tr id="tr_<{$data.consult_id}>">
                <td>
                    <{$data.name}>（<{if $data.kind=='counselor'}>輔導主任<{else}>專任輔導教師<{/if}>）
                </td>

                <td>
                    <{if 'statistics'|have_consult_power:'':'':$uid}>
                        <a href="consult.php?consult_uid=<{$uid}>&start=<{$smarty.get.start}>&end=<{$smarty.get.end}>">共 <{$data.num}> 筆輔導紀錄</a>
                    <{else}>
                        共 <{$data.num}> 筆輔導紀錄
                    <{/if}>
                </td>


                <td>
                    <{if 'statistics'|have_consult_power:'':'':$uid}>
                        <a href="pdf_consult_all.php?consult_uid=<{$uid}>&start=<{$smarty.get.start}>&end=<{$smarty.get.end}>"><img src="images/pdf.png"></a>
                        <a href="excel_consult_all.php?consult_uid=<{$uid}>&start=<{$smarty.get.start}>&end=<{$smarty.get.end}>"><img src="images/xls.png"></a>
                    <{/if}>
                </td>

                <td>
                    <{if 'statistics'|have_consult_power:'':'':$uid}>
                        <a href="pdf_consult_month.php?consult_uid=<{$uid}>&start=<{$smarty.get.start}>&end=<{$smarty.get.end}>"><img src="images/pdf.png"></a>
                        <a href="excel_consult_month.php?consult_uid=<{$uid}>&start=<{$smarty.get.start}>&end=<{$smarty.get.end}>"><img src="images/xls.png"></a>
                    <{/if}>
                </td>

                <td>
                    <{if 'statistics'|have_consult_power:'':'':$uid}>
                        <a href="excel_edu_month.php?consult_uid=<{$uid}>&start=<{$smarty.get.start}>&end=<{$smarty.get.end}>"><img src="images/xls.png"></a>
                    <{/if}>
                </td>
            </tr>
        <{/foreach}>
    </tbody>
</table>
<{$bar}>
