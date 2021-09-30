<table class="line">
    <tr>
        <th>班級</th><th>座號</th><th>班級</th><th>座號</th><th>導師姓名</th>
    </tr>
    <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
        <tr>
            <td class="c"><span class="my_value"><{$general.$stage.stu_grade}>-<{$general.$stage.stu_class}></span></td>
            <td class="c"><span class="my_value"><{$general.$stage.stu_seat_no}></span></td>
            <td class="c"><span class="my_value"><{$general.$stage.stu_grade}>-<{$general.$stage.stu_class}></span></td>
            <td class="c"><span class="my_value"><{$general.$stage.stu_seat_no}></span></td>
            <td class="c"><span class="my_value"><{$general.$stage.class_tea}></span></td>
        </tr>
    <{/foreach}>
</table>