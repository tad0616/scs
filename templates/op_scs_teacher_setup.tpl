<!-- <script type="text/javascript">
    $(document).ready(function(){
        console.log("<{$xoops_url}>/modules/scs/ajax.php?op=get_teachers");
        $( ".teacher_picker" ).autocomplete({
            source: "<{$xoops_url}>/modules/scs/ajax.php?op=get_teachers"
        });
    });
</script> -->


<div class="row mb-3">
    <div class="col-auto">
        <div class="input-group">
            <select name="school_year" id="school_year" style="width: auto;" class="form-control" onchange="location.href='class.php?school_year='+this.value">
                <option value="">選年度</option>
                <{if $school_year_arr|default:false}>
                    <{foreach from=$school_year_arr item=year}>
                        <option value="<{$year|default:''}>" <{if $school_year==$year}>selected<{/if}>><{$year|default:''}>學年度</option>
                    <{/foreach}>
                <{else}>
                    <option value="<{$school_year|default:''}>"><{$school_year|default:''}></option>
                <{/if}>
            </select>
            <span class="input-group-text text-dark">
                設定
            </span>
        </div>
    </div>
</div>

<div class="alert alert-info">
只有老師利用OpenID登入過本站後，其姓名才會出現在下方選單中。
</div>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" class="form-horizontal">


    <div class="row">
        <div class="col-md-4">
            <h3><{$school_year|default:''}>學年「輔導主任」設定</h3>
            <div class="form-group row mb-3 custom-gutter">
                <label class="col-md-6 col-form-label text-sm-right control-label">
                    <{$school_year|default:''}>學年「輔導主任」
                </label>
                <div class="col-md-6">
                    <!-- <input type="text" name="class_teacher[counselor]" id="class_teacher_counselor" placeholder="請選擇輔導主任" class="form-control teacher_picker"> -->
                    <select class="form-control teacher_picker" name="class_teacher[counselor]">
                        <option value="">請選擇輔導主任</option>
                        <{foreach from=$teachers key=uid item=teacher}>
                            <option value="<{$uid|default:''}>" <{if isset($setup.counselor.0) && $setup.counselor.0==$uid}>selected<{/if}>><{$teacher.name}>（<{$teacher.uname}>）</option>
                        <{/foreach}>
                    </select>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <h3><{$school_year|default:''}>學年「專任輔導教師」設定</h3>
            <div class="form-group row mb-3 custom-gutter">
                <label class="col-md-6 col-form-label text-sm-right control-label">
                    <{$school_year|default:''}>學年「專任輔導教師」
                </label>
                <div class="col-md-6">
                    <select class="form-control teacher_picker" name="class_teacher[tutor][]" multiple size=10>
                        <option value="">請選擇專任輔導教師</option>
                        <{foreach from=$teachers key=uid item=teacher}>
                            <option value="<{$uid|default:''}>" <{if isset($setup.tutor) && $setup.tutor|is_array && $uid|in_array:$setup.tutor}>selected<{/if}>><{$teacher.name}>（<{$teacher.uname}>）</option>
                        <{/foreach}>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h3><{$school_year|default:''}>學年開放學生填寫日期設定</h3>
            <div class="form-group row mb-3 custom-gutter">
                <label class="col-md-5 col-form-label text-sm-right control-label">
                    開始填寫日期
                </label>
                <div class="col-md-7">
                    <input type="text" name="class_teacher[stu_start_sign]" id="stu_start_sign" class="form-control" value="<{$setup.stu_start_sign.0}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="">
                </div>
            </div>
            <div class="form-group row mb-3 custom-gutter">
                <label class="col-md-5 col-form-label text-sm-right control-label">
                    結束填寫日期
                </label>
                <div class="col-md-7">
                    <input type="text" name="class_teacher[stu_stop_sign]" id="stu_stop_sign" class="form-control" value="<{$setup.stu_stop_sign.0}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="">
                </div>
            </div>
            <div class="text-right">
                兩者都空白表示不限制，學生隨時可填
            </div>
        </div>
    </div>



    <h3><{$school_year|default:''}>學年「各班導師」設定</h3>
    <div class="row">
        <{foreach from=$all_class key=stu_grade item=grade_class}>
            <div class="col-md-4">
                <{foreach from=$grade_class key=stu_class item=count}>
                    <div class="form-group row mb-3 custom-gutter">
                        <label class="col-md-6 col-form-label text-sm-right control-label">
                            <{$school_year|default:''}>學年 <{$stu_grade|default:''}>年<{$stu_class|default:''}>班（共<{$count|default:''}>人）
                        </label>
                        <div class="col-md-6">
                            <{assign var="class_key" value="$school_year-$stu_grade-$stu_class"}>
                            <!-- <input type="text" name="class_teacher[<{$class_key|default:''}>]" id="class_teacher_<{$class_key|default:''}>" placeholder="請選擇導師" class="form-control teacher_picker"> -->
                            <select class="form-control teacher_picker" name="class_teacher[<{$class_key|default:''}>]">
                                <option value="">請選擇導師</option>
                                <{foreach from=$teachers key=uid item=teacher}>
                                    <option value="<{$uid|default:''}>" <{if $setup.$class_key.0==$uid}>selected<{/if}>><{$teacher.name}>（<{$teacher.uname}>）</option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                <{/foreach}>
            </div>
        <{/foreach}>
    </div>

    <div class="text-center">
        <input type="hidden" name="school_year" value="<{$school_year|default:''}>">
        <input type="hidden" name="op" value="save_class_teacher">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>
