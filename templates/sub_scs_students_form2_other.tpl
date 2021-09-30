<h4>其他</h4>
<div class="alert alert-info">
    <{foreach from=$form2_other_arr key=other_title item=other name=form2_other_arr}>
        <{assign var=var_name value=$other.var_name}>
        <{assign var=type value=$other.type}>
        <div class="form-group row custom-gutter">
            <label class="col-sm-2 col-form-label">
            <{$other_title}>
            </label>
            <div class="col-sm-10">
                <div class="input-group">
                    <{foreach from=$smarty.session.stages key=year item=stage name=stages}>
                        <div class="input-group-prepend input-group-addon">
                            <span class="input-group-text"><{$year}>年級</span>
                        </div>
                        <{if $type=="select"}>
                            <{if $edit_grade.$stage==''}>
                                <select name="scs_general[<{$var_name}>][<{$stage}>]" id="<{$var_name}><{$stage}>" class="form-control " size=1>
                                    <option value=""></option>
                                    <{foreach from=$other_arr.$var_name key=k item=opt}>
                                        <option value="<{$opt}>" <{if $general.$stage.$var_name == $opt}>selected="selected"<{/if}>><{$opt}></option>
                                    <{/foreach}>
                                </select>
                            <{else}>
                                <input type="text" name="scs_general[<{$var_name}>][<{$stage}>]" value="<{$general.$stage.$var_name}>" class="form-control <{$edit_grade.$stage}>" placeholder="" <{$edit_grade.$stage}>>
                            <{/if}>
                        <{else}>
                            <{if $edit_grade.$stage==''}>
                                <input type="text" name="scs_general[money][<{$stage}>]" id="money7" class="form-control " value="<{$general.$stage.money}>" placeholder="<{$year}>年級">
                            <{else}>
                                <input type="text" name="scs_general[money][<{$stage}>]" value="<{$general.$stage.money}>" class="form-control <{$edit_grade.$stage}>" placeholder="" <{$edit_grade.$stage}>>
                            <{/if}>
                        <{/if}>
                    <{/foreach}>
                </div>
            </div>
        </div>
    <{/foreach}>
