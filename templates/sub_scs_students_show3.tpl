<table class="line">
    <tr>
        <th class="c1" rowspan=12><div class="vertical">三、學習狀況</div></th>
    <tr>
        <td class="c2">22.最喜歡的學科</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                        <th class="s"><{$year}></th>
                        <td class="sv<{if $stage<=6}>6<{else}>3<{/if}>">
                            <{foreach from=$general.$stage.favorite_subject item=favorite_subject}>
                                <span class="my_value"><{$favorite_subject}></span>
                            <{/foreach}>
                        </td>
                    <{/foreach}>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">23.最感困難的學科</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                        <th class="s"><{$year}></th>
                        <td class="sv<{if $stage<=6}>6<{else}>3<{/if}>">
                            <{foreach from=$general.$stage.difficult_subject item=difficult_subject}>
                                <span class="my_value"><{$difficult_subject}></span>
                            <{/foreach}>
                        </td>
                    <{/foreach}>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">24.特殊專長</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                        <th class="s"><{$year}></th>
                        <td class="sv<{if $stage<=6}>6<{else}>3<{/if}>">
                            <{foreach from=$general.$stage.expertise item=expertise}>
                                <span class="my_value"><{$expertise}></span>
                            <{/foreach}>
                        </td>
                    <{/foreach}>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">25.休閒興趣</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                        <th class="s"><{$year}></th>
                        <td class="sv<{if $stage<=6}>6<{else}>3<{/if}>">
                            <{foreach from=$general.$stage.interest item=interest}>
                                <span class="my_value"><{$interest}></span>
                            <{/foreach}>
                        </td>
                    <{/foreach}>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">26.參加校內社團<br>擔任班級幹部</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                        <th class="s"><{$year}></th>
                        <td class="sv<{if $stage<=6}>6<{else}>3<{/if}>">
                            <span class="my_label">社團：</span>
                            <span class="my_value"><{$general.$stage.club}></span>
                            <br>
                            <span class="my_label">幹部：</span>
                            <span class="my_value"><{$general.$stage.cadre}></span>
                        </td>
                    <{/foreach}>
                </tr>
            </table>
        </td>
    </tr>
</table>