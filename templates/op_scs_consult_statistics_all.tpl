<h2  class="scs">諮商報表及統計</h2>

<table class="table table-striped table-hover" style="background:white;">
    <thead>
        <tr class="info">
            <th>
                姓名
            </th>
            <th>
                所有諮商紀錄
            </th>
            <th>
                個別諮商期末報表
            </th>
            <th>
                個別諮商月報表
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
                        <a href="consult.php?consult_uid=<{$uid}>">共 <{$data.num}> 筆諮商紀錄</a>
                    <{else}>
                        共 <{$data.num}> 筆諮商紀錄
                    <{/if}>
                </td>


                <td>
                    <{if 'statistics'|have_consult_power:'':'':$uid}>
                        <a href="pdf_consult_all.php?consult_uid=<{$uid}>"><img src="images/pdf.png"></a>
                        <a href="excel_consult_all.php?consult_uid=<{$uid}>"><img src="images/xls.png"></a>
                    <{/if}>
                </td>

                <td>
                    <{if 'statistics'|have_consult_power:'':'':$uid}>
                        <a href="pdf_consult_month.php?consult_uid=<{$uid}>"><img src="images/pdf.png"></a>
                        <a href="excel_consult_month.php?consult_uid=<{$uid}>"><img src="images/xls.png"></a>
                    <{/if}>
                </td>

            </tr>
        <{/foreach}>
    </tbody>
</table>
<{$bar}>
