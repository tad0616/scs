
<h4>學習狀況</h4>
<div class="alert alert-info">
    <div class="form-group row custom-gutter">
        <label class="col-sm-3 col-form-label">
        最喜歡的學科
        </label>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            一年級
        </label>
        <div class="col-sm-2">
            <!-- size=2 multiple -->
            <{if $edit_grade.1==''}>
                <select name="scs_general[favorite_subject][1][]" id="favorite_subject1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$favorite_subject_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.1.favorite_subject}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[favorite_subject][1][]" value="<{$general.1.favorite_subject}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            二年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.2==''}>
                <select name="scs_general[favorite_subject][2][]" id="favorite_subject1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$favorite_subject_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.2.favorite_subject}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[favorite_subject][2][]" value="<{$general.2.favorite_subject}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            三年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.3==''}>
                <select name="scs_general[favorite_subject][3][]" id="favorite_subject1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$favorite_subject_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.3.favorite_subject}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[favorite_subject][3][]" value="<{$general.3.favorite_subject}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
            <{/if}>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <label class="col-sm-3 col-form-label">
        最感困難的學科
        </label>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            一年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.1==''}>
                <select name="scs_general[difficult_subject][1][]" id="difficult_subject1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$difficult_subject_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.1.difficult_subject}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[difficult_subject][1][]" value="<{$general.1.difficult_subject}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            二年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.2==''}>
                <select name="scs_general[difficult_subject][2][]" id="difficult_subject1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$difficult_subject_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.2.difficult_subject}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[difficult_subject][2][]" value="<{$general.2.difficult_subject}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            三年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.3==''}>
                <select name="scs_general[difficult_subject][3][]" id="difficult_subject1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$difficult_subject_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.3.difficult_subject}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[difficult_subject][3][]" value="<{$general.3.difficult_subject}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
            <{/if}>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <label class="col-sm-3 col-form-label">
        特殊專長
        </label>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            一年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.1==''}>
                <select name="scs_general[expertise][1][]" id="expertise1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$expertise_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.1.expertise}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[expertise][1][]" value="<{$general.1.expertise}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            二年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.2==''}>
                <select name="scs_general[expertise][2][]" id="expertise1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$expertise_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.2.expertise}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[expertise][2][]" value="<{$general.2.expertise}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            三年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.3==''}>
                <select name="scs_general[expertise][3][]" id="expertise1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$expertise_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.3.expertise}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[expertise][3][]" value="<{$general.3.expertise}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
            <{/if}>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <label class="col-sm-3 col-form-label">
        休閒興趣
        </label>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            一年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.1==''}>
                <select name="scs_general[interest][1][]" id="interest1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$interest_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.1.interest}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[interest][1][]" value="<{$general.1.interest}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            二年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.2==''}>
                <select name="scs_general[interest][2][]" id="interest1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$interest_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.2.interest}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[interest][2][]" value="<{$general.2.interest}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            三年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.3==''}>
                <select name="scs_general[interest][3][]" id="interest1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$interest_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.3.interest}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[interest][3][]" value="<{$general.3.interest}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
            <{/if}>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <label class="col-sm-3 col-form-label">
        參加校內社團
        </label>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            一年級
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_general[club][1]" id="club1" class="form-control <{$edit_grade.1}>" value="<{$general.1.club}>" placeholder="" <{$edit_grade.1}>>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            二年級
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_general[club][2]" id="club2" class="form-control <{$edit_grade.2}>" value="<{$general.2.club}>" placeholder="" <{$edit_grade.2}>>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            三年級
        </label>
        <div class="col-sm-2">
            <input type="text" name="scs_general[club][3]" id="club3" class="form-control <{$edit_grade.3}>" value="<{$general.3.club}>" placeholder="" <{$edit_grade.3}>>
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <label class="col-sm-3 col-form-label">
        擔任班級幹部
        </label>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            一年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.1==''}>
                <select name="scs_general[cadre][1][]" id="cadre1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$cadre_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.1.cadre}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[cadre][1][]" value="<{$general.1.cadre}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            二年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.2==''}>
                <select name="scs_general[cadre][2][]" id="cadre1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$cadre_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.2.cadre}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[cadre][2][]" value="<{$general.2.cadre}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
            <{/if}>
        </div>
        <label class="col-sm-1 col-form-label text-md-right control-label">
            三年級
        </label>
        <div class="col-sm-2">
            <{if $edit_grade.3==''}>
                <select name="scs_general[cadre][3][]" id="cadre1" class="form-control " size=1>
                    <option value=""></option>
                    <{foreach from=$cadre_arr key=k item=opt}>
                        <option value="<{$opt}>" <{if $opt|in_array:$general.3.cadre}>selected="selected"<{/if}>><{$opt}></option>
                    <{/foreach}>
                </select>
            <{else}>
                <input type="text" name="scs_general[cadre][3][]" value="<{$general.3.cadre}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
            <{/if}>
        </div>
    </div>
</div>