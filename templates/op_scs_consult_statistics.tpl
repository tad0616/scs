<h2  class="scs">「<{$consult_name}>」個別諮商紀錄</h2>

<table class="table table-striped table-hover" style="background:white;">
    <thead>
        <tr class="info">
            <th>班級</th>
            <th>座號</th>
            <th>姓名</th>
            <th>會談日期</th>
            <th>星期</th>
            <th>會談時間</th>
            <th>來談動機</th>
            <th>問題類別</th>
            <th>處理方式</th>
        </tr>
    </thead>

    <tbody id="scs_consult_sort">
        <{foreach from=$data_arr item=data}>
            <tr id="tr_<{$data.consult_id}>">
                <td><{$data.stu_grade}>-<{$data.stu_class}></td>
                <td><{$data.stu_seat_no}></td>
                <{if 'statistics'|have_consult_power:'':'':$data.consult_uid}>
                    <td><a href="consult.php?stu_id=<{$data.stu_id}>"><{$data.stu_name}></a></td>
                <{else}>
                    <td><{$data.stu_name}></td>
                <{/if}>
                <td><{$data.consult_cdate}></td>
                <td><{$data.consult_week}></td>
                <td><{$data.consult_time}></td>
                <td><{$data.consult_motivation}></td>
                <td><{$data.consult_kind}></td>
                <td><{$data.consult_method}></td>
            </tr>
        <{/foreach}>
    </tbody>
</table>
<{$bar}>
