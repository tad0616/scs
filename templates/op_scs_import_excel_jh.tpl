<h2  class="scs"><{$school_year}>學年度第<{$semester}>學期學生資料</h2>
<form action="main.php" method="post">
    <table class="table table-bordered table-condensed table-responsive" style="background:white;">
    <{foreach from=$students key=row item=student}>
        <{if $row>2}>
            <tr>
                <{foreach from=$student key=tbl item=stu_arr}>
                    <{foreach from=$stu_arr key=col item=val}>
                        <td nowrap style="font-size:0.8em;">
                            <{if $val|is_array}>
                                <{foreach from=$val key=col2 item=val2}>
                                    <div>
                                        <{$val2}>
                                        <input type="hidden" name="students[<{$row}>][<{$tbl}>][<{$col}>][<{$col2}>]" value='<{$val2}>'>
                                    </div>
                                <{/foreach}>
                            <{else}>
                                <{$val}>
                                <input type="hidden" name="students[<{$row}>][<{$tbl}>][<{$col}>]" value="<{$val}>">
                            <{/if}>
                        </td>
                    <{/foreach}>
                <{/foreach}>
            </tr>
        <{else}>
            <tr>
                <{foreach from=$student key=tbl item=stu_arr}>
                    <{foreach from=$stu_arr key=col item=val}>
                        <th nowrap style="font-size:0.8em;">
                            <{$val}>
                        </th>
                    <{/foreach}>
                <{/foreach}>
            </tr>
        <{/if}>
    <{/foreach}>
    </table>
    <input type="hidden" name="school_year" value="<{$school_year}>">
    <input type="hidden" name="op" value="scs_import_to_db_jh">
    <button type="submit" class="btn btn-primary">匯入</button>
</form>
<{*
<div class="table-responsive">
    <table class="table table-bordered table-condensed table-responsive" style="background:white;">
    <{foreach from=$all_data key=row item=col_data}>
        <tr>
            <{foreach from=$col_data key=col item=val}>
                <{if $row==2}>
                    <th nowrap style="font-size:0.8em;">(<{$col}>) <{$val}></th>
                <{else}>
                    <td nowrap style="font-size:0.8em;"><{$val}></td>
                <{/if}>
            <{/foreach}>
        </tr>
    <{/foreach}>
    </table>
</div>
*}>