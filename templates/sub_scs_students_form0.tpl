<div class="form-group row mb-3 custom-gutter">
    <!--學號-->
    <label class="col-md-1 col-form-label text-md-right control-label">
        <{$smarty.const._MD_SCS_STU_NO}>
    </label>
    <div class="col-md-2">
        <input type="text" name="scs_students[stu_no]" id="stu_no" class="form-control <{$readonly|default:''}>" value="<{$student.stu_no}>" placeholder="<{$smarty.const._MD_SCS_STU_NO}>" <{$readonly|default:''}>>
    </div>
    <!--姓名-->
    <label class="col-md-1 col-form-label text-md-right control-label">
        <{$smarty.const._MD_SCS_STU_NAME}>
    </label>
    <div class="col-md-2">
        <input type="text" name="scs_students[stu_name]" id="stu_name" class="form-control <{$readonly|default:''}> validate[required]" value="<{$student.stu_name}>" placeholder="<{$smarty.const._MD_SCS_STU_NAME}>" <{$readonly|default:''}>>
    </div>
    <!--性別-->
    <label class="col-md-1 col-form-label text-md-right control-label">
        <{$smarty.const._MD_SCS_STU_SEX}>
    </label>
    <div class="col-md-1">
        <{if $readonly|default:false}>
            <input type="text" name="scs_students[stu_sex]" id="stu_sex" class="form-control <{$readonly|default:''}> validate[required]" value="<{$student.stu_sex}>" placeholder="<{$smarty.const._MD_SCS_STU_NAME}>" <{$readonly|default:''}>>
        <{else}>
            <select name="scs_students[stu_sex]" id="stu_sex" class="form-control">
                <option value=""></option>
                <option value="男" <{if $student.stu_sex == "男"}>selected="selected"<{/if}>>男</option>
                <option value="女" <{if $student.stu_sex == "女"}>selected="selected"<{/if}>>女</option>
            </select>
        <{/if}>
    </div>

    <!--電子郵件-->
    <label class="col-md-1 col-form-label text-md-right control-label">
        Email
    </label>
    <div class="col-md-3">
        <input type="text" name="scs_students[stu_email]" id="stu_email" class="form-control " value="<{$student.stu_email}>" placeholder="<{$smarty.const._MD_SCS_STU_EMAIL}>">
    </div>
</div>

<div class="alert alert-success">
    <div class="row">
        <div class="col-md-9">
            <{include file="$xoops_rootpath/modules/$xoops_dirname/templates/sub_scs_students_form0_year.tpl"}>
        </div>
        <div class="col-md-3">
            請上傳相片
            <{$up_stu_id_create|default:''}>
        </div>
    </div>
</div>