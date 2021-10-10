<!-- 一、本人概況 -->
<h4>1.身份證統一編號</h4>
<div class="alert alert-success">
    <div class="form-group row custom-gutter">
        <!--身份證號-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_PID}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[stu_pid]" id="stu_pid" class="form-control <{$readonly}>" value="<{$student.stu_pid}>" placeholder="<{$smarty.const._MD_SCS_STU_PID}>" <{$readonly}>>
        </div>

        <!--身份註記-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_IDENTITY}>
        </label>
        <div class="col-sm-2">
            <input list="stu_identity" name="scs_students[stu_identity]" class="form-control <{$readonly}>" value="<{$student.stu_identity}>" placeholder="可選亦可直接輸入" <{$readonly}>>
            <datalist id="stu_identity">
                <{foreach from=$stu_identity_arr key=k item=title}>
                    <option value="<{$title}>">
                <{/foreach}>
            </datalist>
        </div>
        <!--僑居地-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_RESIDENCE}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[stu_residence]" id="stu_residence" class="form-control " value="<{$student.stu_residence}>" placeholder="<{$smarty.const._MD_SCS_STU_RESIDENCE}>">
        </div>
    </div>
</div>


<h4>2.出生</h4>
<div class="alert alert-info">
    <div class="form-group row custom-gutter">
        <!--出生地-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_BIRTH_PLACE}>
        </label>
        <div class="col-sm-4">
            <input list="stu_birth_place" name="scs_students[stu_birth_place]" class="form-control" value="<{$student.stu_birth_place}>" placeholder="可選亦可直接輸入">
            <datalist id="stu_birth_place">
                <{foreach from=$stu_birth_place_arr key=k item=title}>
                    <option value="<{$title}>">
                <{/foreach}>
            </datalist>
        </div>
        <!--生日 date-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_BIRTHDAY}>
        </label>
        <div class="col-sm-4">
            <input type="text" name="scs_students[stu_birthday]" id="stu_birthday" class="form-control <{$readonly}>" value="<{$student.stu_birthday}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="<{$smarty.const._MD_SCS_STU_BIRTHDAY}>" <{$readonly}>>
        </div>
    </div>
</div>

<h4>3.血型</h4>
<div class="alert alert-success">
    <div class="form-group row custom-gutter">
        <!--血型-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_BLOOD}>
        </label>
        <div class="col-sm-4">
            <select name="scs_students[stu_blood]" id="stu_blood" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$stu_blood_arr key=k item=blood}>
                    <option value="<{$blood}>" <{if $student.stu_blood == $blood}>selected="selected"<{/if}>><{$blood}></option>
                <{/foreach}>
            </select>
        </div>

        <!--宗教-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_RELIGION}>
        </label>
        <div class="col-sm-4">
            <input list="stu_religion" name="scs_students[stu_religion]" class="form-control" value="<{$student.stu_religion}>" placeholder="可選亦可直接輸入">
            <datalist id="stu_religion">
                <{foreach from=$stu_religion_arr key=k item=title}>
                    <option value="<{$title}>">
                <{/foreach}>
            </datalist>
        </div>
    </div>
</div>

<h4>4.通訊處</h4>
<div class="alert alert-info">
    <{if $readonly}>
        <div class="form-group row custom-gutter">
            <!--戶籍地址-->
            <label class="col-sm-1 col-form-label text-md-right control-label">
                永久
            </label>
            <div class="col-sm-11">
                <input type="text" name="scs_students[stu_residence_zip]" class="form-control <{$readonly}>" value="<{$student.stu_residence_zip}>" <{$readonly}>>
                <input type="text" name="scs_students[stu_residence_county]" class="form-control <{$readonly}>" value="<{$student.stu_residence_county}>" <{$readonly}>>
                <input type="text" name="scs_students[stu_residence_city]" class="form-control <{$readonly}>" value="<{$student.stu_residence_city}>" <{$readonly}>>
                <input type="text" name="scs_students[stu_residence_addr]" class="form-control <{$readonly}>" value="<{$student.stu_residence_addr}>" <{$readonly}>>
            </div>
        </div>
    <{else}>
        <div class="form-group row custom-gutter" id="twzipcode1">
            <!--戶籍地址-->
            <label class="col-sm-1 col-form-label text-md-right control-label">
                永久
            </label>
            <div data-role="zipcode"
                data-name="scs_students[stu_residence_zip]"
                data-value="<{$student.stu_residence_zip}>"
                data-style="form-control"
                class="col-sm-2">
            </div>
            <div data-role="county"
                data-name="scs_students[stu_residence_county]"
                data-value="<{$student.stu_residence_county}>"
                data-style="form-control"
                class="col-sm-2">
            </div>
            <div data-role="district"
                data-name="scs_students[stu_residence_city]"
                data-value="<{$student.stu_residence_city}>"
                data-style="form-control"
                class="col-sm-2">
            </div>
            <div class="col-sm-5">
                <input type="text" name="scs_students[stu_residence_addr]" id="stu_residence_addr" class="form-control" value="<{$student.stu_addr}>" placeholder="<{$smarty.const._MD_SCS_STU_RESIDENCE_ADDR}>">
            </div>
        </div>
    <{/if}>
    <{if $readonly}>
        <div class="form-group row custom-gutter">
            <!--通訊地址-->
            <label class="col-sm-1 col-form-label text-md-right control-label">
                現在
            </label>
            <div class="col-sm-11">
                <input type="text" name="scs_students[stu_zip]" class="form-control <{$readonly}>" value="<{$student.stu_zip}>" <{$readonly}>>
                <input type="text" name="scs_students[stu_county]" class="form-control <{$readonly}>" value="<{$student.stu_county}>" <{$readonly}>>
                <input type="text" name="scs_students[stu_city]" class="form-control <{$readonly}>" value="<{$student.stu_city}>" <{$readonly}>>
                <input type="text" name="scs_students[stu_addr]" class="form-control <{$readonly}>" value="<{$student.stu_addr}>" <{$readonly}>>
            </div>
        </div>
    <{else}>
        <div class="form-group row custom-gutter" id="twzipcode2">
            <!--通訊地址-->
            <label class="col-sm-1 col-form-label text-md-right control-label">
                現在
            </label>
            <div data-role="zipcode"
                data-name="scs_students[stu_zip]"
                data-value="<{$student.stu_zip}>"
                data-style="form-control"
                class="col-sm-2">
            </div>
            <div data-role="county"
                data-name="scs_students[stu_county]"
                data-value="<{$student.stu_county}>"
                data-style="form-control"
                class="col-sm-2">
            </div>
            <div data-role="district"
                data-name="scs_students[stu_city]"
                data-value="<{$student.stu_city}>"
                data-style="form-control"
                class="col-sm-2">
            </div>
            <div class="col-sm-5">
                <input type="text" name="scs_students[stu_addr]" id="stu_addr" class="form-control" value="<{$student.stu_addr}>" placeholder="<{$smarty.const._MD_SCS_STU_ADDR}>">
            </div>
        </div>
    <{/if}>

    <div class="form-group row custom-gutter">
        <!--電話1-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_TEL1}>
        </label>
        <div class="col-sm-5">
            <input type="text" name="scs_students[stu_tel1]" id="stu_tel1" class="form-control " value="<{$student.stu_tel1}>" placeholder="<{$smarty.const._MD_SCS_STU_TEL1}>">
        </div>
        <!--電話2-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_TEL2}>
        </label>
        <div class="col-sm-5">
            <input type="text" name="scs_students[stu_tel2]" id="stu_tel2" class="form-control " value="<{$student.stu_tel2}>" placeholder="<{$smarty.const._MD_SCS_STU_TEL2}>">
        </div>
    </div>
</div>

<h4>5.緊急聯絡人</h4>
<div class="alert alert-success">
    <!--緊急聯絡人-->
    <div class="form-group row custom-gutter">
        <label class="col-sm-1 col-form-label text-md-right control-label">
            姓名
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[emergency_contact][name]" id="emergency_contact_name" class="form-control" value="<{$student.emergency_contact.name}>" placeholder="緊急聯絡人姓名">
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            電話
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[emergency_contact][tel]" id="emergency_contact_tel" class="form-control" value="<{$student.emergency_contact.tel}>" placeholder="緊急聯絡人電話">
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            住址
        </label>
        <div class="col-sm-5">
            <input type="text" name="scs_students[emergency_contact][addr]]" id="emergency_contact_addr" class="form-control" value="<{$student.emergency_contact.addr}>" placeholder="緊急聯絡人住址">
        </div>
    </div>
</div>

<h4>6.學歷及就學</h4>
<div class="alert alert-info">
    <!--學歷及就學（國小）-->
    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label text-md-right control-label">
            國小畢業民國年
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[stu_education][g_time]" id="stu_education_g_time" class="form-control" value="<{$student.stu_education.g_time}>" placeholder="國小畢業年度">
        </div>
        <label class="col-sm-2 col-form-label text-md-right control-label">
            國小畢業學校
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[stu_education][g_school]" id="stu_education_g_school" class="form-control" value="<{$student.stu_education.g_school}>" placeholder="畢業學校">
        </div>
        <label class="col-sm-2 col-form-label text-md-right control-label">
            進入本校民國年
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[stu_education][i_time]" id="stu_education_i_time" class="form-control" value="<{$student.stu_education.i_time}>" placeholder="進入本校年度">
        </div>

    </div>
    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label text-md-right control-label">
            本校畢業民國年
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[stu_education][o_time]" id="stu_education_o_time" class="form-control" value="<{$student.stu_education.o_time}>" placeholder="本校畢業年">
        </div>
        <label class="col-sm-2 col-form-label text-md-right control-label">
            畢業後就讀學校
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[stu_education][jh_school]" id="stu_education_jh_school" class="form-control" value="<{$student.stu_education.jh_school}>" placeholder="進入高中職校">
        </div>
        <label class="col-sm-2 col-form-label text-md-right control-label">
            就讀民國年
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[stu_education][jh_time]" id="stu_education_jh_time" class="form-control" value="<{$student.stu_education.jh_time}>" placeholder="進入高中職年度">
        </div>
    </div>
</div>

<h4>7.身高及體重</h4>
<div class="alert alert-warning">
    <!--身高-->
    <div class="input-group">
        <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text"><{$year}>年級<{$smarty.const._MD_SCS_STU_HEIGHT}></span>
            </div>
            <input type="number" name="scs_general[stu_height][<{$stage}>]" id="stu_height<{$stage}>" class="form-control validate[custom[number]] <{$edit_grade.$stage}>" value="<{$general.$stage.stu_height}>" placeholder="幾公分" <{$edit_grade.$stage}>>
        <{/foreach}>
    </div>
    <!--體重-->
    <div class="input-group" style="margin-top: 0.6rem;">
        <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text"><{$year}>年級<{$smarty.const._MD_SCS_STU_WEIGHT}></span>
            </div>
            <input type="number" name="scs_general[stu_weight][<{$stage}>]" id="stu_weight<{$stage}>" class="form-control validate[custom[number]] <{$edit_grade.$stage}>" value="<{$general.$stage.stu_weight}>" placeholder="幾公斤" <{$edit_grade.$stage}>>
        <{/foreach}>
    </div>
</div>

<h4>8.生理缺陷</h4>
<div class="alert alert-danger">
    <div class="form-group row custom-gutter">
        <!--生理缺陷-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            生理缺陷
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[physiological_defect][1]" id="physiological_defect_1" class="form-control" value="<{$student.physiological_defect.1}>" placeholder="生理缺陷1">
        </div>
        <div class="col-sm-2">
            <input type="text" name="scs_students[physiological_defect][2]" id="physiological_defect_2" class="form-control" value="<{$student.physiological_defect.2}>" placeholder="生理缺陷2">
        </div>

        <!--特殊疾病-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            曾患特殊疾病
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_students[special_disease][1]" id="special_disease_1" class="form-control" value="<{$student.special_disease.1}>" placeholder="特殊疾病1">
        </div>
        <div class="col-sm-2">
            <input type="text" name="scs_students[special_disease][2]" id="special_disease_2" class="form-control" value="<{$student.special_disease.2}>" placeholder="特殊疾病2">
        </div>
    </div>
</div>