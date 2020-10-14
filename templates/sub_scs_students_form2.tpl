<h4>父親</h4>
<div class="alert alert-success">
    <div class="form-group row custom-gutter">
        <!--姓名-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            父姓名
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_parents[父][parent_name]" id="parent_name_f" class="form-control " value="<{$parents.f.parent_name}>" placeholder="父姓名">
        </div>

        <!--存歿-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_PARENT_SURVIVE}>
        </label>
        <div class="col-sm-2">
            <select name="scs_parents[父][parent_survive]" id="parent_survive_f" class="form-control " size=1>
            <{foreach from=$parent_survive_arr key=k item=survive}>
                <option value="<{$survive}>" <{if $parents.f.parent_survive == $survive}>selected="selected"<{/if}>><{$survive}></option>
            <{/foreach}>
            </select>
        </div>

        <!--出生年次-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_PARENT_YEAR}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_parents[父][parent_year]" id="parent_year_f" class="form-control " value="<{$parents.f.parent_year}>" placeholder="<{$smarty.const._MD_SCS_PARENT_YEAR}>">
        </div>

        <!--教育程度-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_PARENT_EDU}>
        </label>
        <div class="col-sm-2">
            <select name="scs_parents[父][parent_edu]" id="parent_edu_f" class="form-control " size=1>
                <{foreach from=$parent_edu_arr key=k item=edu}>
                    <option value="<{$edu}>" <{if $parents.f.parent_edu == $edu}>selected="selected"<{/if}>><{$edu}></option>
                <{/foreach}>
            </select>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <!--電子信箱-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            Email
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[父][parent_email]" id="parent_email_f" class="form-control " value="<{$parents.f.parent_email}>" placeholder="<{$smarty.const._MD_SCS_PARENT_EMAIL}>">
        </div>

        <!--手機電話-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            手機
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[父][parent_phone]" id="parent_phone_f" class="form-control " value="<{$parents.f.parent_phone}>" placeholder="<{$smarty.const._MD_SCS_PARENT_PHONE}>">
        </div>

        <!--公司電話-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            電話
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[父][parent_company_tel]" id="parent_company_tel_f" class="form-control " value="<{$parents.f.parent_company_tel}>" placeholder="<{$smarty.const._MD_SCS_PARENT_COMPANY_TEL}>">
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <!--職業-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            父<{$smarty.const._MD_SCS_PARENT_JOB}>
        </label>
        <div class="col-sm-3">
            <input list="parent_job_f" name="scs_parents[父][parent_job]" class="form-control" value="<{$parents.f.parent_job}>" placeholder="可選亦可直接輸入">
            <datalist id="parent_job_f">
                <{foreach from=$parent_job_arr key=k item=title}>
                    <option value="<{$title}>">
                <{/foreach}>
            </datalist>
        </div>

        <!--工作機構-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            公司名
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[父][parent_company]" id="parent_company_f" class="form-control " value="<{$parents.f.parent_company}>" placeholder="<{$smarty.const._MD_SCS_PARENT_COMPANY}>">
        </div>

        <!--職稱-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_PARENT_TITLE}>
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[父][parent_title]" id="parent_title_f" class="form-control " value="<{$parents.f.parent_title}>" placeholder="<{$smarty.const._MD_SCS_PARENT_TITLE}>">
        </div>
    </div>
</div>

<h4>母親</h4>
<div class="alert alert-info">

    <div class="form-group row custom-gutter">
        <!--姓名-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            母姓名
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_parents[母][parent_name]" id="parent_name_m" class="form-control " value="<{$parents.m.parent_name}>" placeholder="母姓名">
        </div>

        <!--存歿-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_PARENT_SURVIVE}>
        </label>
        <div class="col-sm-2">
            <select name="scs_parents[母][parent_survive]" id="parent_survive_m" class="form-control " size=1>
            <{foreach from=$parent_survive_arr key=k item=survive}>
                <option value="<{$survive}>" <{if $parents.m.parent_survive == $survive}>selected="selected"<{/if}>><{$survive}></option>
            <{/foreach}>
            </select>
        </div>

        <!--出生年次-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_PARENT_YEAR}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_parents[母][parent_year]" id="parent_year_m" class="form-control " value="<{$parents.m.parent_year}>" placeholder="<{$smarty.const._MD_SCS_PARENT_YEAR}>">
        </div>

        <!--教育程度-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_PARENT_EDU}>
        </label>
        <div class="col-sm-2">
            <select name="scs_parents[母][parent_edu]" id="parent_edu_m" class="form-control " size=1>
                <{foreach from=$parent_edu_arr key=k item=edu}>
                    <option value="<{$edu}>" <{if $parents.m.parent_edu == $edu}>selected="selected"<{/if}>><{$edu}></option>
                <{/foreach}>
            </select>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <!--電子信箱-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            Email
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[母][parent_email]" id="parent_email_m" class="form-control " value="<{$parents.m.parent_email}>" placeholder="<{$smarty.const._MD_SCS_PARENT_EMAIL}>">
        </div>
        <!--手機電話-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            手機
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[母][parent_phone]" id="parent_phone_m" class="form-control " value="<{$parents.m.parent_phone}>" placeholder="<{$smarty.const._MD_SCS_PARENT_PHONE}>">
        </div>

        <!--公司電話-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            電話
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[母][parent_company_tel]" id="parent_company_tel_m" class="form-control " value="<{$parents.m.parent_company_tel}>" placeholder="<{$smarty.const._MD_SCS_PARENT_COMPANY_TEL}>">
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <!--職業-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            母<{$smarty.const._MD_SCS_PARENT_JOB}>
        </label>
        <div class="col-sm-3">
            <input list="parent_job_m" name="scs_parents[母][parent_job]" class="form-control" value="<{$parents.m.parent_job}>" placeholder="可選亦可直接輸入">
            <datalist id="parent_job_m">
                <{foreach from=$parent_job_arr key=k item=title}>
                    <option value="<{$title}>">
                <{/foreach}>
            </datalist>
        </div>

        <!--工作機構-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            公司名
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[母][parent_company]" id="parent_company_m" class="form-control " value="<{$parents.m.parent_company}>" placeholder="<{$smarty.const._MD_SCS_PARENT_COMPANY}>">
        </div>

        <!--職稱-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_PARENT_TITLE}>
        </label>
        <div class="col-sm-3">
            <input type="text" name="scs_parents[母][parent_title]" id="parent_title_m" class="form-control " value="<{$parents.m.parent_title}>" placeholder="<{$smarty.const._MD_SCS_PARENT_TITLE}>">
        </div>
    </div>
</div>

<h4>監護人</h4>
<div class="alert alert-warning">

    <div class="form-group row custom-gutter">
        <!--姓名-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_GUARDIAN_NAME}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_guardian[guardian_name]" id="guardian_name" class="form-control validate[required]" value="<{$guardian.guardian_name}>" placeholder="<{$smarty.const._MD_SCS_GUARDIAN_NAME}>">
        </div>

        <!--性別-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_GUARDIAN_SEX}>
        </label>
        <div class="col-sm-2">

            <div class="form-check form-check-inline">
                <input type="radio" name="scs_guardian[guardian_sex]" id="guardian_sex_男" class="form-check-input" value="男" class="validate[required]" <{if $guardian.guardian_sex == "男"}>checked="checked"<{/if}>>
                <label class="form-check-label" for="guardian_sex_男">男</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="scs_guardian[guardian_sex]" id="guardian_sex_女" class="form-check-input" value="女" class="validate[required]" <{if $guardian.guardian_sex == "女"}>checked="checked"<{/if}>>
                <label class="form-check-label" for="guardian_sex_女">女</label>
            </div>
        </div>

        <!--關係-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_GUARDIAN_TITLE}>
        </label>
        <div class="col-sm-2">
            <select name="scs_guardian[guardian_title]" id="guardian_title" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$guardian_title_arr key=k item=title}>
                    <option value="<{$title}>" <{if $guardian.guardian_title == $title}>selected="selected"<{/if}>><{$title}></option>
                <{/foreach}>
            </select>
        </div>

        <!--電話-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_GUARDIAN_TEL}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_guardian[guardian_tel]" id="guardian_tel" class="form-control " value="<{$guardian.guardian_tel}>" placeholder="<{$smarty.const._MD_SCS_GUARDIAN_TEL}>">
        </div>
    </div>

    <!--通訊處-->
    <div class="form-group row custom-gutter">
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_GUARDIAN_ADDR}>
        </label>
        <div class="col-sm-11">
            <input type="text" name="scs_guardian[guardian_addr]" id="guardian_addr" class="form-control " value="<{$guardian.guardian_addr}>" placeholder="<{$smarty.const._MD_SCS_GUARDIAN_ADDR}>">
        </div>
    </div>
</div>


<{includeq file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_form2_bs.tpl"}>
<{includeq file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_form2_other.tpl"}>
</div>