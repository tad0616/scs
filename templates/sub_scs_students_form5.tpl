
<h4>我的個性（如：溫和、急躁）</h4>
<div class="alert alert-info">
    <div class="input-group">
        <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text"><{$year}>年級</span>
            </div>
            <input type="text" name="scs_general[stu_personality][<{$stage}>]" id="stu_personality<{$stage}>" class="form-control <{$edit_grade.$stage}>" value="<{$general.$stage.stu_personality}>" placeholder="" <{$edit_grade.$stage}>>
        <{/foreach}>
    </div>
</div>

<h4>我的優點</h4>
<div class="alert alert-info">
    <div class="input-group">
        <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text"><{$year}>年級</span>
            </div>
            <input type="text" name="scs_general[stu_advantage][<{$stage}>]" id="stu_advantage<{$stage}>" class="form-control <{$edit_grade.$stage}>" value="<{$general.$stage.stu_advantage}>" placeholder="" <{$edit_grade.$stage}>>
        <{/foreach}>
    </div>
</div>

<h4>我需要改進的地方</h4>
<div class="alert alert-info">
    <div class="input-group">
        <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text"><{$year}>年級</span>
            </div>
            <input type="text" name="scs_general[stu_improve][<{$stage}>]" id="stu_improve<{$stage}>" class="form-control <{$edit_grade.$stage}>" value="<{$general.$stage.stu_improve}>" placeholder="" <{$edit_grade.$stage}>>
        <{/foreach}>
    </div>
</div>

<h4>填寫日期</h4>
<div class="alert alert-info">
    <div class="input-group">
        <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text"><{$year}>年級</span>
            </div>
            <input type="text" name="scs_general[fill_date][<{$stage}>]" id="fill_date<{$stage}>" class="form-control <{$edit_grade.$stage}>" value="<{$general.$stage.fill_date}>" placeholder="" <{$edit_grade.$stage}>>
        <{/foreach}>
    </div>
</div>