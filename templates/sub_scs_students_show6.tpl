<table class="line">
    <tr>
        <th class="c1"><div class="vertical">六、生活感想</div></th>
        <td class="z" colspan=3>
            <table>
                <tr>
                    <th class="c3">年級</th>
                    <th>我目前遇到最大的困難是</th>
                    <th>我目前最需要協助的是</th>
                </tr>
                <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                    <tr>
                        <th class="c3"><{$year}>年級</th>
                        <td><span class="my_value"><{$general.$stage.stu_difficult}></span></td>
                        <td><span class="my_value"><{$general.$stage.stu_need_help}></span></td>
                    </tr>
                <{/foreach}>
            </table>
        </td>
    </tr>
</table>