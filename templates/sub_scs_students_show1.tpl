<table class="line">
    <tr>
        <th class="c1" rowspan=10><div class="vertical">一、本人概況</div></th>
        <td class="c2">1.身份證統一編號</td>
        <td colspan=3>
            <span class="my_value"><{$student.stu_pid}></span>
            <span class="my_label">身份</span>
            <span class="my_value"><{$student.stu_identity}></span>
            <span class="my_label">僑居地</span>
            <span class="my_value"><{$student.stu_residence}></span>
        </td>
    </tr>
    <tr>
        <td class="c2">2.出生</td>
        <td colspan=3>
            <span class="my_label">出生地</span>
            <span class="my_value"><{$student.stu_birth_place}></span>
            <span class="my_label">生日</span>
            <span class="my_value"><{$student.tw_birthday}></span>
        </td>
    </tr>
    <tr>
        <td class="c2">3.血型</td>
        <td>
            <span class="my_value"><{$student.stu_blood}></span>
        </td>
        <td>宗教</td>
        <td>
            <span class="my_value"><{$student.stu_religion}></span>
        </td>
    </tr>
    <tr>
        <td class="c2" rowspan=2>4.通訊處</td>
        <td>
            <span class="my_label">永久</span>
            <span class="my_value"><{$student.stu_residence_zip}><{$student.stu_residence_county}><{$student.stu_residence_city}><{$student.stu_residence_addr}></span>
        </td>
        <td rowspan=2>電話</td>
        <td>
            <span class="my_value"><{$student.stu_tel1}></span>
        </td>
    </tr>
    <tr>
        <td>
            <span class="my_label">現在</span>
            <span class="my_value"><{$student.stu_zip}><{$student.stu_county}><{$student.stu_city}><{$student.stu_addr}></span>
        </td>
        <td>
            <span class="my_value"><{$student.stu_tel2}></span>
        </td>
    </tr>
    <tr>
        <td class="c2">5.緊急聯絡人</td>
        <td colspan=3>
            <span class="my_label">姓名</span>
            <span class="my_value"><{$guardian.guardian_name}></span>
            <span class="my_label">住址</span>
            <span class="my_value"><{$guardian.guardian_addr}></span>
            <span class="my_label">電話</span>
            <span class="my_value"><{$guardian.guardian_tel}></span>
        </td>
    </tr>
    <tr>
        <td class="c2">6.學歷及就學</td>
        <td colspan=3>
            民國
            <span class="my_value"><{$student.stu_education.g_time}></span>
            年畢（肄）業於
            <span class="my_value"><{$student.stu_education.g_school}></span>
            ，民國
            <span class="my_value"><{$student.stu_education.i_time}></span>
            年進入本校<br>
            <span class="my_value"><{$student.stu_education.o_time}></span>
            年自本校畢業，於
            <span class="my_value"><{$student.stu_education.jh_time}></span>
            年進入
            <span class="my_value"><{$student.stu_education.jh_school}></span>
            就讀
        </td>
    </tr>
    <tr>
        <td class="c2">7.身高及體重</td>
        <td colspan=3>
            <span class="my_label">身高</span>
            <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                <{$year}>
                <span class="my_value"><{$general.$stage.stu_height}></span>
                <span class="my_unit">公分</span>
            <{/foreach}>

            <span class="my_label">體重</span>
            <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                <{$year}>
                <span class="my_value"><{$general.$stage.stu_weight}></span>
                <span class="my_unit">公斤</span>
            <{/foreach}>
        </td>
    </tr>
    <tr>
        <td class="c2">8.生理缺陷</td>
        <td >
            <span class="my_label">1.</span>
            <span class="my_value"><{$student.physiological_defect.1}></span>
            <span class="my_label">2.</span>
            <span class="my_value"><{$student.physiological_defect.2}></span>
        </td>
        <td>特殊疾病</td>
        <td >
            <span class="my_label">1.</span>
            <span class="my_value"><{$student.special_disease.1}></span>
            <span class="my_label">2.</span>
            <span class="my_value"><{$student.special_disease.2}></span>
        </td>
    </tr>
</table>