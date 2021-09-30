<table class="line">
    <tr>
        <th class="c1"><div class="vertical">五、自我認識</div></th>
        <td class="z" colspan=3>
            <table>
                <tr>
                    <th class="c3">年級</th>
                    <th>我的個性（如：溫和、急躁）</th>
                    <th>我的優點</th>
                    <th>我需要改進的地方</th>
                    <th>填寫日期</th>
                </tr>
                <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                    <tr>
                        <th class="c3"><{$year}>年級</th>
                        <td><span class="my_value"><{$general.$stage.stu_personality}></span></td>
                        <td><span class="my_value"><{$general.$stage.stu_advantage}></span></td>
                        <td><span class="my_value"><{$general.$stage.stu_improve}></span></td>
                        <td><span class="my_value"><{$general.$stage.fill_date}></span></td>
                    </tr>
                <{/foreach}>
            </table>
        </td>
    </tr>
</table>