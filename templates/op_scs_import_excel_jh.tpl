<h2  class="scs"><{$school_year|default:''}>學年度第<{$semester|default:''}>學期學生資料</h2>
<form action="main.php" method="post">
    <table class="table table-bordered table-sm table-condensed table-responsive" style="background:white;">
    <{foreach from=$students key=row item=student}>
        <{if $row>2}>
            <tr>
                <{foreach from=$student key=tbl item=stu_arr}>
                    <{foreach from=$stu_arr key=col item=val}>
                        <td nowrap style="font-size:0.8em;">
                            <{if $val|is_array}>
                                <{foreach from=$val key=col2 item=val2}>
                                    <div>
                                        <{$val2|default:''}>
                                        <input type="hidden" name="students[<{$row|default:''}>][<{$tbl|default:''}>][<{$col|default:''}>][<{$col2|default:''}>]" value='<{$val2|default:''}>'>
                                    </div>
                                <{/foreach}>
                            <{else}>
                                <{$val|default:''}>
                                <input type="hidden" name="students[<{$row|default:''}>][<{$tbl|default:''}>][<{$col|default:''}>]" value="<{$val|default:''}>">
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
                            <{$val|default:''}>
                        </th>
                    <{/foreach}>
                <{/foreach}>
            </tr>
        <{/if}>
    <{/foreach}>
    </table>
    <input type="hidden" name="school_year" value="<{$school_year|default:''}>">
    <input type="hidden" name="op" value="scs_import_to_db_jh">
    <button type="submit" class="btn btn-primary">匯入</button>
</form>
<{*
<div class="table-responsive">
    <table class="table table-bordered table-sm table-condensed table-responsive" style="background:white;">
    <{foreach from=$all_data key=row item=col_data}>
        <tr>
            <{foreach from=$col_data key=col item=val}>
                <{if $row==2}>
                    <th nowrap style="font-size:0.8em;">(<{$col|default:''}>) <{$val|default:''}></th>
                <{else}>
                    <td nowrap style="font-size:0.8em;"><{$val|default:''}></td>
                <{/if}>
            <{/foreach}>
        </tr>
    <{/foreach}>
    </table>
</div>
*}>