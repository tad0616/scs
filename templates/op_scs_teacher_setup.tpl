<h2><{$school_year}>學年學生填寫日期設定</h2>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" class="form-horizontal">
    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            開始填寫日期
        </label>
        <div class="col-sm-2">
            <input type="text" name="class_teacher[stu_start_sign]" id="stu_start_sign" class="form-control" value="<{$setup.stu_start_sign.0}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="">
        </div>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            結束填寫日期
        </label>
        <div class="col-sm-2">
            <input type="text" name="class_teacher[stu_stop_sign]" id="stu_stop_sign" class="form-control" value="<{$setup.stu_stop_sign.0}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="">
        </div>
        <div class="col-sm-4">
            兩者都空白表示不限制，學生隨時可填
        </div>
    </div>

    <h2><{$school_year}>學年各班導師設定</h2>
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
