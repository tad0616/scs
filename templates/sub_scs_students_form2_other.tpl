<h4>其他</h4>
<div class="alert alert-info">
<div class="form-group row custom-gutter">
    <label class="col-sm-3 col-form-label">
    父母關係
    </label>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        一年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.1==''}>
            <select name="scs_general[parental_relationship][1]" id="parental_relationship1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$parental_relationship_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.1.parental_relationship == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[parental_relationship][1]" value="<{$general.1.parental_relationship}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        二年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.2==''}>
            <select name="scs_general[parental_relationship][2]" id="parental_relationship2" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$parental_relationship_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.2.parental_relationship == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[parental_relationship][2]" value="<{$general.2.parental_relationship}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        三年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.3==''}>
            <select name="scs_general[parental_relationship][3]" id="parental_relationship3" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$parental_relationship_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.3.parental_relationship == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text"" name="scs_general[parental_relationship][3]" value="<{$general.3.parental_relationship}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
        <{/if}>
    </div>
</div>

<div class="form-group row custom-gutter">
    <label class="col-sm-3 col-form-label">
    家庭氣氛
    </label>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        一年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.1==''}>
            <select name="scs_general[family_atmosphere][1]" id="family_atmosphere1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$family_atmosphere_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.1.family_atmosphere == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[family_atmosphere][1]" value="<{$general.1.family_atmosphere}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        二年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.2==''}>
            <select name="scs_general[family_atmosphere][2]" id="family_atmosphere1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$family_atmosphere_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.2.family_atmosphere == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[family_atmosphere][2]" value="<{$general.2.family_atmosphere}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        三年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.3==''}>
            <select name="scs_general[family_atmosphere][3]" id="family_atmosphere1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$family_atmosphere_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.3.family_atmosphere == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[family_atmosphere][3]" value="<{$general.3.family_atmosphere}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
        <{/if}>
    </div>
</div>

<div class="form-group row custom-gutter">
    <label class="col-sm-3 col-form-label">
    父管教方式
    </label>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        一年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.1==''}>
            <select name="scs_general[father_discipline][1]" id="father_discipline1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$discipline_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.1.father_discipline == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[father_discipline][1]" value="<{$general.1.father_discipline}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        二年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.2==''}>
            <select name="scs_general[father_discipline][2]" id="father_discipline1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$discipline_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.2.father_discipline == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[father_discipline][2]" value="<{$general.2.father_discipline}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        三年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.3==''}>
            <select name="scs_general[father_discipline][3]" id="father_discipline1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$discipline_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.3.father_discipline == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[father_discipline][3]" value="<{$general.3.father_discipline}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
        <{/if}>
    </div>
</div>

<div class="form-group row custom-gutter">
    <label class="col-sm-3 col-form-label">
    母管教方式
    </label>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        一年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.1==''}>
            <select name="scs_general[mother_discipline][1]" id="mother_discipline1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$discipline_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.1.mother_discipline == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[mother_discipline][1]" value="<{$general.1.mother_discipline}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        二年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.2==''}>
            <select name="scs_general[mother_discipline][2]" id="mother_discipline1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$discipline_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.2.mother_discipline == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[mother_discipline][2]" value="<{$general.2.mother_discipline}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        三年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.3==''}>
            <select name="scs_general[mother_discipline][3]" id="mother_discipline1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$discipline_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.3.mother_discipline == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[mother_discipline][3]" value="<{$general.3.mother_discipline}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
        <{/if}>
    </div>
</div>

<div class="form-group row custom-gutter">
    <label class="col-sm-3 col-form-label">
    居住環境
    </label>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        一年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.1==''}>
            <select name="scs_general[environment][1]" id="environment1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$environment_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.1.environment == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[environment][1]" value="<{$general.1.environment}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        二年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.2==''}>
            <select name="scs_general[environment][2]" id="environment1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$environment_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.2.environment == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[environment][2]" value="<{$general.2.environment}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        三年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.3==''}>
            <select name="scs_general[environment][3]" id="environment1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$environment_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.3.environment == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[environment][3]" value="<{$general.3.environment}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
        <{/if}>
    </div>
</div>

<div class="form-group row custom-gutter">
    <label class="col-sm-3 col-form-label">
    本人住宿
    </label>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        一年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.1==''}>
            <select name="scs_general[accommodation][1]" id="accommodation1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$accommodation_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.1.accommodation == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[accommodation][1]" value="<{$general.1.accommodation}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        二年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.2==''}>
            <select name="scs_general[accommodation][2]" id="accommodation1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$accommodation_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.2.accommodation == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[accommodation][2]" value="<{$general.2.accommodation}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        三年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.3==''}>
            <select name="scs_general[accommodation][3]" id="accommodation1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$accommodation_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.3.accommodation == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[accommodation][3]" value="<{$general.3.accommodation}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
        <{/if}>
    </div>
</div>

<div class="form-group row custom-gutter">
    <label class="col-sm-3 col-form-label">
    經濟狀況
    </label>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        一年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.1==''}>
            <select name="scs_general[economic][1]" id="economic1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$economic_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.1.economic == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[economic][1]" value="<{$general.1.economic}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        二年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.2==''}>
            <select name="scs_general[economic][2]" id="economic1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$economic_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.2.economic == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[economic][2]" value="<{$general.2.economic}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        三年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.3==''}>
            <select name="scs_general[economic][3]" id="economic1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$economic_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.3.economic == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[economic][3]" value="<{$general.3.economic}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
        <{/if}>
    </div>
</div>

<div class="form-group row custom-gutter">
    <label class="col-sm-3 col-form-label">
    每星期零用錢約
    </label>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        一年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.1==''}>
            <input type="text" name="scs_general[money][1]" id="money1" class="form-control " value="<{$general.1.money}>" placeholder="一年級">
        <{else}>
            <input type="text" name="scs_general[money][1]" value="<{$general.1.money}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        二年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.2==''}>
            <input type="text" name="scs_general[money][2]" id="money1" class="form-control " value="<{$general.2.money}>" placeholder="二年級">
        <{else}>
            <input type="text" name="scs_general[money][2]" value="<{$general.2.money}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        三年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.3==''}>
            <input type="text" name="scs_general[money][3]" id="money1" class="form-control " value="<{$general.3.money}>" placeholder="三年級">
        <{else}>
            <input type="text" name="scs_general[money][3]" value="<{$general.3.money}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
        <{/if}>
    </div>
</div>

<div class="form-group row custom-gutter">
    <label class="col-sm-3 col-form-label">
    覺得零用錢
    </label>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        一年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.1==''}>
            <select name="scs_general[feel][1]" id="feel1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$feel_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.1.feel == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[feel][1]" value="<{$general.1.feel}>" class="form-control <{$edit_grade.1}>" placeholder="" <{$edit_grade.1}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        二年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.2==''}>
            <select name="scs_general[feel][2]" id="feel1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$feel_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.2.feel == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[feel][2]" value="<{$general.2.feel}>" class="form-control <{$edit_grade.2}>" placeholder="" <{$edit_grade.2}>>
        <{/if}>
    </div>
    <label class="col-sm-1 col-form-label text-md-right control-label">
        三年級
    </label>
    <div class="col-sm-2">
        <{if $edit_grade.3==''}>
            <select name="scs_general[feel][3]" id="feel1" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$feel_arr key=k item=opt}>
                    <option value="<{$opt}>" <{if $general.3.feel == $opt}>selected="selected"<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{else}>
            <input type="text" name="scs_general[feel][3]" value="<{$general.3.feel}>" class="form-control <{$edit_grade.3}>" placeholder="" <{$edit_grade.3}>>
        <{/if}>
    </div>
</div>