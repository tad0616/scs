<table class="line">
    <tr>
        <th class="c1" rowspan=12><div class="vertical">三、學習狀況</div></th>
    <tr>
        <td class="c2">22.最喜歡的學科</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv">
                        <{foreach from=$general.1.favorite_subject item=favorite_subject}>
                            <span class="my_value"><{$favorite_subject}></span>
                        <{/foreach}>
                    </td>
                    <th class="s">二</th>
                    <td class="sv">
                        <{foreach from=$general.2.favorite_subject item=favorite_subject}>
                            <span class="my_value"><{$favorite_subject}></span>
                        <{/foreach}>
                    </td>
                    <th class="s">三</th>
                    <td class="sv">
                        <{foreach from=$general.3.favorite_subject item=favorite_subject}>
                            <span class="my_value"><{$favorite_subject}></span>
                        <{/foreach}>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">23.最感困難的學科</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv">
                        <{foreach from=$general.1.difficult_subject item=difficult_subject}>
                            <span class="my_value"><{$difficult_subject}></span>
                        <{/foreach}>
                    </td>
                    <th class="s">二</th>
                    <td class="sv">
                        <{foreach from=$general.2.difficult_subject item=difficult_subject}>
                            <span class="my_value"><{$difficult_subject}></span>
                        <{/foreach}>
                    </td>
                    <th class="s">三</th>
                    <td class="sv">
                        <{foreach from=$general.3.difficult_subject item=difficult_subject}>
                            <span class="my_value"><{$difficult_subject}></span>
                        <{/foreach}>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">24.特殊專長</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv">
                        <{foreach from=$general.1.expertise item=expertise}>
                            <span class="my_value"><{$expertise}></span>
                        <{/foreach}>
                    </td>
                    <th class="s">二</th>
                    <td class="sv">
                        <{foreach from=$general.2.expertise item=expertise}>
                            <span class="my_value"><{$expertise}></span>
                        <{/foreach}>
                    </td>
                    <th class="s">三</th>
                    <td class="sv">
                        <{foreach from=$general.3.expertise item=expertise}>
                            <span class="my_value"><{$expertise}></span>
                        <{/foreach}>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">25.休閒興趣</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv">
                        <{foreach from=$general.1.interest item=interest}>
                            <span class="my_value"><{$interest}></span>
                        <{/foreach}>
                    </td>
                    <th class="s">二</th>
                    <td class="sv">
                        <{foreach from=$general.2.interest item=interest}>
                            <span class="my_value"><{$interest}></span>
                        <{/foreach}>
                    </td>
                    <th class="s">三</th>
                    <td class="sv">
                        <{foreach from=$general.3.interest item=interest}>
                            <span class="my_value"><{$interest}></span>
                        <{/foreach}>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">26.參加校內社團<br>擔任班級幹部</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv">
                        <span class="my_label">社團：</span>
                        <span class="my_value"><{$general.1.club}></span>
                        <br>
                        <span class="my_label">幹部：</span>
                        <span class="my_value"><{$general.1.cadre}></span>
                    </td>
                    <th class="s">二</th>
                    <td class="sv">
                        <span class="my_label">社團：</span>
                        <span class="my_value"><{$general.2.club}></span>
                        <br>
                        <span class="my_label">幹部：</span>
                        <span class="my_value"><{$general.2.cadre}></span>
                    </td>
                    <th class="s">三</th>
                    <td class="sv">
                        <span class="my_label">社團：</span>
                        <span class="my_value"><{$general.3.club}></span>
                        <br>
                        <span class="my_label">幹部：</span>
                        <span class="my_value"><{$general.3.cadre}></span>
                        </td>
                </tr>
            </table>
        </td>
    </tr>
</table>