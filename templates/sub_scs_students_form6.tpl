
<h4>我目前遇到最大的困難是</h4>
<div class="alert alert-danger">
    <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
        <div class="form-group row mb-3 custom-gutter">
            <label class="col-md-1 col-form-label text-md-right control-label">
                <{$year|default:''}>年級
            </label>
            <div class="col-md-11">
                <input type="text" name="scs_general[stu_difficult][<{$stage|default:''}>]" id="stu_difficult1" class="form-control <{$edit_grade.$stage}>" value="<{$general.$stage.stu_difficult}>" placeholder="" <{$edit_grade.$stage}>>
            </div>
        </div>
    <{/foreach}>
</div>

<h4>我目前最需要協助的是</h4>
<div class="alert alert-warning">
    <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
    <div class="form-group row mb-3 custom-gutter">
        <label class="col-md-1 col-form-label text-md-right control-label">
            <{$year|default:''}>年級
        </label>
        <div class="col-md-11">
            <input type="text" name="scs_general[stu_need_help][<{$stage|default:''}>]" id="stu_need_help1" class="form-control <{$edit_grade.$stage}>" value="<{$general.$stage.stu_need_help}>" placeholder="" <{$edit_grade.$stage}>>
        </div>
    </div>
    <{/foreach}>
</div>
