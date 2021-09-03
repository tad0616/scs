<table class="line">
    <tr>
        <th class="c1" rowspan=12><div class="vertical">二、家長狀況</div></th>
        <td class="c2">10.直系血親</td>
        <td colspan=3>
            <span class="my_label">父</span>
            <span class="my_value"><{$parents.f.parent_name}></span>
            [<span class="my_value2"><{$parents.f.parent_survive}></span>]
            <span class="my_value"><{$parents.f.parent_year}></span>
            <span class="my_unit">年生</span>

            <!-- <span class="my_label">祖父</span>
            <span class="my_value"><{$parents.f.parent_gf_name}></span>
            [<span class="my_value2"><{$parents.f.parent_gf_survive}></span>] -->
            <br>
            <span class="my_label">母</span>
            <span class="my_value"><{$parents.m.parent_name}></span>
            [<span class="my_value2"><{$parents.m.parent_survive}></span>]
            <span class="my_value"><{$parents.m.parent_year}></span>
            <span class="my_unit">年生</span>

            <!-- <span class="my_label">祖母</span>
            <span class="my_value"><{$parents.m.parent_gm_name}></span>
            [<span class="my_value2"><{$parents.m.parent_gm_survive}></span>] -->
        </td>
    </tr>
    <tr>
        <td class="c2">11.父母教育程度</td>
        <td class="z" colspan=3>
            <table class="no">
                <tr>
                    <th class="s">父</th>
                    <td><span class="my_value"><{$parents.f.parent_edu}></span></td>
                    <th class="s">母</th>
                    <td><span class="my_value"><{$parents.m.parent_edu}></span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">12.家長</td>
        <td class="z" colspan=3>
            <table>
            <tr>
                <th>稱謂</th>
                <th>姓名</th>
                <th>職業</th>
                <th>工作機構與職稱</th>
                <th>公司電話</th>
                <th>手機</th>
            </tr>
            <tr>
                <td>父</td>
                <td><span class="my_value"><{$parents.f.parent_name}></span></td>
                <td><span class="my_value"><{$parents.f.parent_job}></span></td>
                <td><span class="my_value"><{$parents.f.parent_company}><{$parents.f.parent_title}></span></td>
                <td><span class="my_value"><{$parents.f.parent_company_tel}></span></td>
                <td><span class="my_value"><{$parents.f.parent_phone}></span></td>
            </tr>
            <tr>
                <td>母</td>
                <td><span class="my_value"><{$parents.m.parent_name}></span></td>
                <td><span class="my_value"><{$parents.m.parent_job}></span></td>
                <td><span class="my_value"><{$parents.m.parent_company}><{$parents.m.parent_title}></span></td>
                <td><span class="my_value"><{$parents.m.parent_company_tel}></span></td>
                <td><span class="my_value"><{$parents.m.parent_phone}></span></td>
            </tr>
            </table>

            <table class="no">
                <tr>
                    <th class="s" nowrap>父電郵</th>
                    <td><span class="my_value"><{$parents.f.parent_email}></span></td>
                    <th class="s" nowrap>母電郵</th>
                    <td><span class="my_value"><{$parents.m.parent_email}></span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">13.監護人</td>
        <td colspan=3>
            <span class="my_label">姓名</span>
            <span class="my_value"><{$guardian.guardian_name}></span>
            <span class="my_label">性別</span>
            <span class="my_value"><{$guardian.guardian_sex}></span>
            <span class="my_label">關係</span>
            <span class="my_value"><{$guardian.guardian_title}></span>
            <span class="my_label">電話</span>
            <span class="my_value"><{$guardian.guardian_tel}></span><br>
            <span class="my_label">通訊處</span>
            <span class="my_value"><{$guardian.guardian_addr}></span>
        </td>
    </tr>
    <tr>
        <td class="c2">14.兄弟姊妹</td>
        <td class="z" colspan=3>
            <{if $brother_sister}>
                <table>
                <tr>
                    <th>稱謂</th>
                    <th>姓名</th>
                    <th>畢業（肄）學校</th>
                    <th>出生年次</th>
                    <th>備註</th>
                </tr>
                <{foreach from=$brother_sister item=bs}>
                    <tr>
                        <td><span class="my_value"><{$bs.bs_relationship}></span></td>
                        <td><span class="my_value"><{$bs.bs_name}></span></td>
                        <td><span class="my_value"><{$bs.bs_school}></span></td>
                        <td><span class="my_value"><{$bs.bs_year}></span></td>
                        <td><span class="my_value"><{$bs.bs_note}></span></td>
                    </tr>
                <{/foreach}>
                </table>
            <{else}>
                無
            <{/if}>
        </td>
    </tr>
    <tr>
        <td class="c2">15.父母關係</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv"><span class="my_value"><{$general.1.parental_relationship}></span></td>
                    <th class="s">二</th>
                    <td class="sv"><span class="my_value"><{$general.2.parental_relationship}></span></td>
                    <th class="s">三</th>
                    <td class="sv"><span class="my_value"><{$general.3.parental_relationship}></span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">16.家庭氣氛</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv"><span class="my_value"><{$general.1.family_atmosphere}></span></td>
                    <th class="s">二</th>
                    <td class="sv"><span class="my_value"><{$general.2.family_atmosphere}></span></td>
                    <th class="s">三</th>
                    <td class="sv"><span class="my_value"><{$general.3.family_atmosphere}></span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">17.父母管教方式</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv">
                        <span class="my_label">父：</span>
                        <span class="my_value"><{$general.1.father_discipline}></span>
                        <br>
                        <span class="my_label">母：</span>
                        <span class="my_value"><{$general.1.mother_discipline}></span>
                    </td>
                    <th class="s">二</th>
                    <td class="sv">
                        <span class="my_label">父：</span>
                        <span class="my_value"><{$general.2.father_discipline}></span>
                        <br>
                        <span class="my_label">母：</span>
                        <span class="my_value"><{$general.2.mother_discipline}></span>
                    </td>
                    <th class="s">三</th>
                    <td class="sv">
                        <span class="my_label">父：</span>
                        <span class="my_value"><{$general.3.father_discipline}></span>
                        <br>
                        <span class="my_label">母：</span>
                        <span class="my_value"><{$general.3.mother_discipline}></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">18.居住環境</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv"><span class="my_value"><{$general.1.environment}></span></td>
                    <th class="s">二</th>
                    <td class="sv"><span class="my_value"><{$general.2.environment}></span></td>
                    <th class="s">三</th>
                    <td class="sv"><span class="my_value"><{$general.3.environment}></span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">19.本人住宿</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv"><span class="my_value"><{$general.1.accommodation}></span></td>
                    <th class="s">二</th>
                    <td class="sv"><span class="my_value"><{$general.2.accommodation}></span></td>
                    <th class="s">三</th>
                    <td class="sv"><span class="my_value"><{$general.3.accommodation}></span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">20.經濟狀況</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv"><span class="my_value"><{$general.1.economic}></span></td>
                    <th class="s">二</th>
                    <td class="sv"><span class="my_value"><{$general.2.economic}></span></td>
                    <th class="s">三</th>
                    <td class="sv"><span class="my_value"><{$general.3.economic}></span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="c2">21.每週零用錢約</td>
        <td colspan=3 class="z">
            <table class="no">
                <tr>
                    <th class="s">一</th>
                    <td class="sv">
                        <span class="my_value"><{$general.1.money}></span><span class="my_unit">元</span>
                        我覺得<span class="my_value"><{$general.1.feel}></span>
                    </td>
                    <th class="s">二</th>
                    <td class="sv">
                        <span class="my_value"><{$general.2.money}></span><span class="my_unit">元</span>
                        我覺得<span class="my_value"><{$general.2.feel}></span>
                    </td>
                    <th class="s">三</th>
                    <td class="sv">
                        <span class="my_value"><{$general.3.money}></span><span class="my_unit">元</span>
                        我覺得<span class="my_value"><{$general.3.feel}></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>