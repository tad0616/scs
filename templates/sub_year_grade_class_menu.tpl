<{if $smarty.session.stu_id}>
    <div class="row">
        <div class="col-sm-9">
            <{if $setup.stu_start_sign.0}>
                <{$setup.stu_start_sign.0}> 開放填寫
            <{else}>
                即日起開放填寫
            <{/if}>
            <{if $setup.stu_stop_sign.0}>
                ，<{$setup.stu_stop_sign.0}> 停止填寫
            <{/if}>
        </div>
        <div class="col-sm-3 text-right">
            <{if $edit_able}>
                <{if $now_op=="scs_students_create"}>
                    <a href="<{$xoops_url}>/modules/scs/index.php" class="btn btn-sm btn-info">回上頁</a>
                <{else}>
                    <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                <{/if}>
            <{/if}>
        </div>
    </div>
<{else}>
    <form action="index.php" class="form-inline">
        <div class="form-group">
            <select name="school_year" id="school_year" class="form-control">
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
            <select name="stu_grade" id="stu_grade" class="form-control" <{if !$stu_grade_arr}>style="display:none;"<{/if}>>
                <{if $stu_grade_arr}>
                    <option value="">選年級</option>
                    <{foreach from=$stu_grade_arr item=grade}>
                        <option value="<{$grade}>" <{if $stu_grade==$grade}>selected<{/if}>><{$grade}>年</option>
                    <{/foreach}>
                <{/if}>
            </select>
        </div>
        <div class="form-group">
            <select name="stu_class" id="stu_class" class="form-control" <{if !$stu_class_arr}>style="display:none;"<{/if}>>
                <{if $stu_class_arr}>
                    <option value="">選班級</option>
                    <{foreach from=$stu_class_arr item=class}>
                        <option value="<{$class}>" <{if $stu_class==$class}>selected<{/if}>><{$class}>班</option>
                    <{/foreach}>
                <{/if}>
            </select>
        </div>
        <div class="form-group">
            <select name="stu_id" id="stu_id" class="form-control" <{if !$stu_arr}>style="display:none;"<{/if}>>
                <{if $stu_arr}>
                    <option value="">選學生</option>
                    <{foreach from=$stu_arr item=stu}>
                        <option value="<{$stu.stu_id}>" <{if $stu_id==$stu.stu_id}>selected<{/if}>><{$stu.stu_seat_no}> <{$stu.stu_name}></option>
                    <{/foreach}>
                <{/if}>
            </select>
        </div>
        <div class="form-group">
            <{if $stu_id}>
                <{if $now_op=="scs_students_create" or $now_op=="scs_consult_create"}>
                    <a href="<{$xoops_url}>/modules/scs/index.php" class="btn btn-success"><i class="fa fa-undo"></i> 回列表</a>
                <{else}>
                    <{if $smarty.session.stu_id}>
                        <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit&stu_id=<{$smarty.session.stu_id}>" class="btn btn-warning" style="margin: 0px 2px;"><{$smarty.const._TAD_EDIT}></a>
                    <{elseif $smarty.session.scs_adm or $smarty.session.tea_class_arr}>
                        <{if $now_op=="scs_consult_show"}>
                            <a href="<{$xoops_url}>/modules/scs/consult.php?stu_id=<{$stu_id}>" class="btn btn-success" style="margin: 0px 2px;"><i class="fa fa-heart"></i> 回諮商紀錄</a>
                            <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_edit&stu_id=<{$stu_id}>&consult_id=<{$consult_id}>" class="btn btn-warning" style="margin: 0px 2px;"><i class="fa fa-pencil"></i> <{$smarty.const._TAD_EDIT}></a>
                        <{elseif $now_op=="scs_consult_index"}>
                            <a href="<{$xoops_url}>/modules/scs/index.php?school_year=<{$school_year}>&stu_grade=<{$stu_grade}>&stu_class=<{$stu_class}>" class="btn btn-success" style="margin: 0px 2px;"><i class="fa fa-undo"></i> 回列表</a>
                        <{elseif $now_op=="scs_students_show"}>
                            <a href="<{$xoops_url}>/modules/scs/index.php?school_year=<{$school_year}>&stu_grade=<{$stu_grade}>&stu_class=<{$stu_class}>" class="btn btn-success" style="margin: 0px 2px;"><i class="fa fa-undo"></i> 回列表</a>
                            <a href="<{$xoops_url}>/modules/scs/pdf.php?stu_id=<{$stu_id}>" class="btn btn-danger" style="margin: 0px 2px;"><i class="fa fa-file-pdf-o"></i> 匯出PDF</a>
                            <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit&stu_id=<{$stu_id}>" class="btn btn-warning" style="margin: 0px 2px;"><i class="fa fa-pencil"></i> <{$smarty.const._TAD_EDIT}></a>
                        <{/if}>
                    <{/if}>
                <{/if}>
            <{/if}>

        </div>
        <div class="form-group text-right">
        目前身份：
            <{if $smarty.session.stu_id}>
                學生
            <{/if}>
            <{if $smarty.session.scs_adm}>
                管理員
            <{/if}>
            <{if $smarty.session.tea_class_arr}>
                <{foreach from=$smarty.session.tea_class_arr item=class}>
                    <{$class}>
                <{/foreach}>
                導師
            <{/if}>
        </div>
    </form>

    <script>
        $(document).ready(function(){
            $('#school_year').change(function(){
                $.post('ajax.php', {op:'get_stu_grade_option', school_year:$('#school_year').val()}, function(data){
                    $('#stu_grade').show().html(data);
                });
            });
            $('#stu_grade').change(function(){
                $.post('ajax.php', {op:'get_stu_class_option', school_year:$('#school_year').val(), stu_grade:$('#stu_grade').val()}, function(data){
                    $('#stu_class').show().html(data);
                });
            });
            $('#stu_class').change(function(){
                location.href="<{$smarty.server.PHP_SELF}>?op=<{$now_op}>&school_year="+$('#school_year').val()+"&stu_grade="+$('#stu_grade').val()+"&stu_class="+$('#stu_class').val();
            });
            $('#stu_id').change(function(){
                location.href="<{$smarty.server.PHP_SELF}>?op=<{$now_op}>&school_year="+$('#school_year').val()+"&stu_grade="+$('#stu_grade').val()+"&stu_class="+$('#stu_class').val()+"&stu_id="+$('#stu_id').val();
            });
        });
    </script>
<{/if}>