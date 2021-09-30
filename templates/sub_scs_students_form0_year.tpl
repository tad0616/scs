<{foreach from=$smarty.session.stages key=year item=stage name=stages}>
    <div class="form-group row custom-gutter">
        <!--<{$year}>年級-->
        <label class="col-sm-2 col-form-label text-md-right control-label">
            <{$year}>年級
        </label>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_SCHOOL_YEAR}>
            <input type="hidden" name="scs_general[stu_grade][<{$stage}>]]" value="<{$stage}>">
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_general[school_year][<{$stage}>]" id="school_year<{$stage}>" class="form-control <{$readonly}>" value="<{$general.$stage.school_year}>" placeholder="<{$smarty.const._MD_SCS_SCHOOL_YEAR}>" <{$readonly}>>
        </div>

        <!--班級-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_CLASS}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_general[stu_class][<{$stage}>]" id="stu_class<{$stage}>" class="form-control <{$readonly}>" value="<{$general.$stage.stu_class}>" placeholder="<{$smarty.const._MD_SCS_STU_CLASS}>" <{$readonly}>>
        </div>

        <!--座號-->
        <label class="col-sm-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_SEAT_NO}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_general[stu_seat_no][<{$stage}>]" id="stu_seat_no<{$stage}>" class="form-control <{$readonly}>" value="<{$general.$stage.stu_seat_no}>" placeholder="<{$smarty.const._MD_SCS_STU_SEAT_NO}>" <{$readonly}>>
        </div>
    </div>
<{/foreach}>