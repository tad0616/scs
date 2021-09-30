
<h4>學習狀況</h4>
<div class="alert alert-info">
    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label">
        最喜歡的學科
        </label>
        <div class="col-sm-10">
            <div class="input-group">
                <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$year}>年級</span>
                    </div>
                    <{if $edit_grade.$stage==''}>
                        <select name="scs_general[favorite_subject][<{$stage}>][]" id="favorite_subject<{$stage}>" class="form-control " size=1>
                            <option value=""></option>
                            <{foreach from=$favorite_subject_arr key=k item=opt}>
                                <option value="<{$opt}>" <{if $opt|in_array:$general.$stage.favorite_subject}>selected="selected"<{/if}>><{$opt}></option>
                            <{/foreach}>
                        </select>
                    <{else}>
                        <input type="text" name="scs_general[favorite_subject][<{$stage}>][]" value="<{$general.$stage.favorite_subject}>" class="form-control <{$edit_grade.$stage}>" placeholder="" <{$edit_grade.$stage}>>
                    <{/if}>
                <{/foreach}>
            </div>
        </div>
    </div>


    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label">
        最感困難的學科
        </label>
        <div class="col-sm-10">
            <div class="input-group">
                <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$year}>年級</span>
                    </div>
                    <{if $edit_grade.$stage==''}>
                        <select name="scs_general[difficult_subject][<{$stage}>][]" id="difficult_subject<{$stage}>" class="form-control " size=1>
                            <option value=""></option>
                            <{foreach from=$difficult_subject_arr key=k item=opt}>
                                <option value="<{$opt}>" <{if $opt|in_array:$general.$stage.difficult_subject}>selected="selected"<{/if}>><{$opt}></option>
                            <{/foreach}>
                        </select>
                    <{else}>
                        <input type="text" name="scs_general[difficult_subject][<{$stage}>][]" value="<{$general.$stage.difficult_subject}>" class="form-control <{$edit_grade.$stage}>" placeholder="" <{$edit_grade.$stage}>>
                    <{/if}>
                <{/foreach}>
            </div>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label">
        特殊專長
        </label>
        <div class="col-sm-10">
            <div class="input-group">
                <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$year}>年級</span>
                    </div>
                    <{if $edit_grade.$stage==''}>
                        <select name="scs_general[expertise][<{$stage}>][]" id="expertise<{$stage}>" class="form-control " size=1>
                            <option value=""></option>
                            <{foreach from=$expertise_arr key=k item=opt}>
                                <option value="<{$opt}>" <{if $opt|in_array:$general.$stage.expertise}>selected="selected"<{/if}>><{$opt}></option>
                            <{/foreach}>
                        </select>
                    <{else}>
                        <input type="text" name="scs_general[expertise][<{$stage}>][]" value="<{$general.$stage.expertise}>" class="form-control <{$edit_grade.$stage}>" placeholder="" <{$edit_grade.$stage}>>
                    <{/if}>
                <{/foreach}>
            </div>
        </div>
    </div>


    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label">
        休閒興趣
        </label>
        <div class="col-sm-10">
            <div class="input-group">
                <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$year}>年級</span>
                    </div>
                    <{if $edit_grade.$stage==''}>
                        <select name="scs_general[interest][<{$stage}>][]" id="interest<{$stage}>" class="form-control " size=1>
                            <option value=""></option>
                            <{foreach from=$interest_arr key=k item=opt}>
                                <option value="<{$opt}>" <{if $opt|in_array:$general.$stage.interest}>selected="selected"<{/if}>><{$opt}></option>
                            <{/foreach}>
                        </select>
                    <{else}>
                        <input type="text" name="scs_general[interest][<{$stage}>][]" value="<{$general.$stage.interest}>" class="form-control <{$edit_grade.$stage}>" placeholder="" <{$edit_grade.$stage}>>
                    <{/if}>
                <{/foreach}>
            </div>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label">
        參加校內社團
        </label>
        <div class="col-sm-10">
            <div class="input-group">
                <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$year}>年級</span>
                    </div>
                    <input type="text" name="scs_general[club][<{$stage}>]" id="club<{$stage}>" class="form-control <{$edit_grade.$stage}>" value="<{$general.$stage.club}>" placeholder="" <{$edit_grade.$stage}>>
                <{/foreach}>
            </div>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label">
        擔任班級幹部
        </label>
        <div class="col-sm-10">
            <div class="input-group">
                <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$year}>年級</span>
                    </div>
                    <{if $edit_grade.$stage==''}>
                        <select name="scs_general[cadre][<{$stage}>][]" id="cadre<{$stage}>" class="form-control " size=1>
                            <option value=""></option>
                            <{foreach from=$cadre_arr key=k item=opt}>
                                <option value="<{$opt}>" <{if $opt|in_array:$general.$stage.cadre}>selected="selected"<{/if}>><{$opt}></option>
                            <{/foreach}>
                        </select>
                    <{else}>
                        <input type="text" name="scs_general[cadre][<{$stage}>][]" value="<{$general.$stage.cadre}>" class="form-control <{$edit_grade.$stage}>" placeholder="" <{$edit_grade.$stage}>>
                    <{/if}>
                <{/foreach}>
            </div>
        </div>
    </div>
</div>