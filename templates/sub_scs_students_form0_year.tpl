<{foreach from=$smarty.session.stages key=year item=stage name=stages}>
    <div class="form-group row mb-3 custom-gutter">
        <!--<{$year|default:''}>年級-->
        <label class="col-md-2 col-form-label text-md-right control-label">
            <{$year|default:''}>年級
        </label>
        <label class="col-md-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_SCHOOL_YEAR}>
            <input type="hidden" name="scs_general[stu_grade][<{$stage|default:''}>]]" value="<{$stage|default:''}>">
        </label>
        <div class="col-md-2">
            <input type="text" name="scs_general[school_year][<{$stage|default:''}>]" id="school_year<{$stage|default:''}>" class="form-control <{$readonly|default:''}>" value="<{$general.$stage.school_year}>" placeholder="<{$smarty.const._MD_SCS_SCHOOL_YEAR}>" <{$readonly|default:''}>>
        </div>

        <!--班級-->
        <label class="col-md-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_CLASS}>
        </label>
        <div class="col-md-2">
            <input type="text" name="scs_general[stu_class][<{$stage|default:''}>]" id="stu_class<{$stage|default:''}>" class="form-control <{$readonly|default:''}>" value="<{$general.$stage.stu_class}>" placeholder="<{$smarty.const._MD_SCS_STU_CLASS}>" <{$readonly|default:''}>>
        </div>

        <!--座號-->
        <label class="col-md-1 col-form-label text-md-right control-label">
            <{$smarty.const._MD_SCS_STU_SEAT_NO}>
        </label>
        <div class="col-md-2">
            <input type="text" name="scs_general[stu_seat_no][<{$stage|default:''}>]" id="stu_seat_no<{$stage|default:''}>" class="form-control <{$readonly|default:''}>" value="<{$general.$stage.stu_seat_no}>" placeholder="<{$smarty.const._MD_SCS_STU_SEAT_NO}>" <{$readonly|default:''}>>
        </div>
    </div>
<{/foreach}>