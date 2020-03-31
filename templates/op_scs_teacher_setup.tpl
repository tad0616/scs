<h2  class="scs">
<form class="form-inline">
    <div class="form-group">
        <select name="school_year" id="school_year" class="form-control" onchange="location.href='class.php?school_year='+this.value">
        <option value="">選年度</option>
        <{if $school_year_arr}>
            <{foreach from=$school_year_arr item=year}>
                <option value="<{$year}>" <{if $school_year==$year}>selected<{/if}>><{$year}>學年度</option>
            <{/foreach}>
        <{else}>
            <option value="<{$school_year}>"><{$school_year}></option>
        <{/if}>
        </select>
    </div>
    <div class="form-group">
    設定
    </div>
</form>
</h2>
<div class="alert alert-info">
只有老師利用OpenID登入過本站後，其姓名才會出現在下方選單中。
</div>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" class="form-horizontal">


    <div class="row">
        <div class="col-sm-4">
            <h3><{$school_year}>學年「輔導主任」設定</h3>
            <div class="form-group row custom-gutter">
                <label class="col-sm-6 col-form-label text-sm-right control-label">
                    <{$school_year}>學年「輔導主任」
                </label>
                <div class="col-sm-6">
                    <select class="form-control" name="class_teacher[counselor]">
                        <option value="">請選擇輔導主任</option>
                        <{foreach from=$teachers key=uid item=teacher}>
                            <option value="<{$uid}>" <{if $setup.counselor.0==$uid}>selected<{/if}>><{$teacher.name}>（<{$teacher.uname}>）</option>
                        <{/foreach}>
                    </select>
                </div>
            </div>

        </div>
        <div class="col-sm-4">
            <h3><{$school_year}>學年「專任輔導教師」設定</h3>
            <div class="form-group row custom-gutter">
                <label class="col-sm-6 col-form-label text-sm-right control-label">
                    <{$school_year}>學年「專任輔導教師」
                </label>
                <div class="col-sm-6">
                    <select class="form-control" name="class_teacher[tutor][]" multiple size=10>
                        <option value="">請選擇專任輔導教師</option>
                        <{foreach from=$teachers key=uid item=teacher}>
                            <option value="<{$uid}>" <{if $uid|in_array:$setup.tutor}>selected<{/if}>><{$teacher.name}>（<{$teacher.uname}>）</option>
                        <{/foreach}>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <h3><{$school_year}>學年開放學生填寫日期設定</h3>
            <div class="form-group row custom-gutter">
                <label class="col-sm-5 col-form-label text-sm-right control-label">
                    開始填寫日期
                </label>
                <div class="col-sm-7">
                    <input type="text" name="class_teacher[stu_start_sign]" id="stu_start_sign" class="form-control" value="<{$setup.stu_start_sign.0}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="">
                </div>
            </div>
            <div class="form-group row custom-gutter">
                <label class="col-sm-5 col-form-label text-sm-right control-label">
                    結束填寫日期
                </label>
                <div class="col-sm-7">
                    <input type="text" name="class_teacher[stu_stop_sign]" id="stu_stop_sign" class="form-control" value="<{$setup.stu_stop_sign.0}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="">
                </div>
            </div>
            <div class="text-right">
                兩者都空白表示不限制，學生隨時可填
            </div>
        </div>
    </div>



    <h3><{$school_year}>學年「各班導師」設定</h3>
    <div class="row">
        <{foreach from=$all_class key=stu_grade item=grade_class}>
            <div class="col-sm-4">
                <{foreach from=$grade_class key=stu_class item=count}>
                    <div class="form-group row custom-gutter">
                        <label class="col-sm-6 col-form-label text-sm-right control-label">
                            <{$school_year}>學年 <{$stu_grade}>年<{$stu_class}>班（共<{$count}>人）
                        </label>
                        <div class="col-sm-6">
                            <{assign var="class_key" value="$school_year-$stu_grade-$stu_class"}>
                            <select class="form-control" name="class_teacher[<{$class_key}>]">
                                <option value="">請選擇導師</option>
                                <{foreach from=$teachers key=uid item=teacher}>
                                    <option value="<{$uid}>" <{if $setup.$class_key.0==$uid}>selected<{/if}>><{$teacher.name}>（<{$teacher.uname}>）</option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                <{/foreach}>
            </div>
        <{/foreach}>
    </div>

    <div class="text-center">
        <input type="hidden" name="school_year" value="<{$school_year}>">
        <input type="hidden" name="op" value="save_class_teacher">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>
