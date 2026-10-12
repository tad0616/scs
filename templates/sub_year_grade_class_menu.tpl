<{if $smarty.session.stu_id|default:false}>
    <div class="row">
        <div class="col-md-9">
            <{if $setup.stu_start_sign.0}>
                <{$setup.stu_start_sign.0}> 開放填寫
            <{else}>
                即日起開放填寫
            <{/if}>
            <{if $setup.stu_stop_sign.0}>
                ，<{$setup.stu_stop_sign.0}> 停止填寫
            <{/if}>
        </div>
        <div class="col-md-3 text-right">
            <{if $edit_able|default:false}>
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
        <div class="row">
            <div class="col-lg-9 ">
                <select name="school_year" id="school_year" class="form-control d-inline-block" style="width: auto;">
                    <option value="">選年度</option>
                    <{if $school_year_arr|default:false}>
                        <{foreach from=$school_year_arr item=year}>
                            <option value="<{$year|default:''}>" <{if $school_year==$year}>selected<{/if}>><{$year|default:''}>學年度</option>
                        <{/foreach}>
                    <{else}>
                        <option value="<{$school_year|default:''}>"><{$school_year|default:''}></option>
                    <{/if}>
                </select>

                <select name="stu_grade" id="stu_grade" class="form-control d-inline-block" style="width: auto; <{if !$stu_grade_arr}>display:none;<{/if}>">
                    <{if $stu_grade_arr|default:false}>
                        <option value="">選年級</option>
                        <{foreach from=$stu_grade_arr item=grade}>
                            <option value="<{$grade|default:''}>" <{if $stu_grade==$grade}>selected<{/if}>><{$grade|default:''}>年</option>
                        <{/foreach}>
                    <{/if}>
                </select>

                <select name="stu_class" id="stu_class" class="form-control d-inline-block" style="width: auto; <{if !$stu_class_arr}>display:none;<{/if}>">
                    <{if $stu_class_arr|default:false}>
                        <option value="">選班級</option>
                        <{foreach from=$stu_class_arr item=class}>
                            <option value="<{$class|default:''}>" <{if $stu_class==$class}>selected<{/if}>><{$class|default:''}>班</option>
                        <{/foreach}>
                    <{/if}>
                </select>

                <{if $stu_id|default:false}>
                    <{include file="$xoops_rootpath/modules/scs/templates/sub_previous.tpl"}>
                <{/if}>
                <select name="stu_id" id="stu_id" class="form-control d-inline-block" style="width: auto; <{if !$stu_arr}>display:none;<{/if}>">
                    <{if $stu_arr|default:false}>
                        <option value="">選學生</option>
                        <{foreach from=$stu_arr item=stu}>
                            <option value="<{$stu.stu_id}>" <{if $stu_id==$stu.stu_id}>selected<{/if}>><{$stu.stu_seat_no}> <{$stu.stu_name}></option>
                        <{/foreach}>
                    <{/if}>
                </select>
                <{if $stu_id|default:false}>
                    <{include file="$xoops_rootpath/modules/scs/templates/sub_next.tpl"}>
                <{/if}>

                <{if $stu_id|default:false}>
                    <{if $now_op=="scs_students_create" or $now_op=="scs_consult_create"}>
                        <a href="<{$xoops_url}>/modules/scs/index.php" class="btn btn-success"><i class="fa fa-undo"></i> 回列表</a>
                    <{else}>
                        <{if $smarty.session.stu_id|default:false}>
                            <{if 'update'|have_scs_power:$smarty.session.stu_id}>
                                <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit&stu_id=<{$smarty.session.stu_id}>" class="btn btn-warning" style="margin: 0px 2px;"><{$smarty.const._TAD_EDIT}></a>
                            <{/if}>
                        <{else}>
                            <{if $now_op=="scs_consult_show"}>
                                <{if 'index'|have_consult_power:$stu_id}>
                                    <a href="<{$xoops_url}>/modules/scs/consult.php?stu_id=<{$stu_id|default:''}>" class="btn btn-success" style="margin: 0px 2px;"><i class="fa fa-heart"></i> 回輔導紀錄</a>
                                <{/if}>
                                <{if 'update'|have_consult_power:$stu_id:$consult_id}>
                                    <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_edit&stu_id=<{$stu_id|default:''}>&consult_id=<{$consult_id|default:''}>" class="btn btn-warning" style="margin: 0px 2px;"><i class="fa fa-pencil"></i> <{$smarty.const._TAD_EDIT}></a>
                                <{/if}>
                                <{if 'create'|have_consult_power:$stu_id}>
                                    <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_create&stu_id=<{$stu_id|default:''}>" class="btn btn-primary"><i class="fa fa-plus"></i> 新增紀錄</a>
                                <{/if}>
                            <{elseif $now_op=="scs_consult_index"}>
                                <a href="<{$xoops_url}>/modules/scs/index.php?school_year=<{$school_year|default:''}>&stu_grade=<{$stu_grade|default:''}>&stu_class=<{$stu_class|default:''}>" class="btn btn-success" style="margin: 0px 2px;"><i class="fa fa-undo"></i> 回列表</a>
                                <{if 'create'|have_consult_power:$stu_id}>
                                    <a href="<{$xoops_url}>/modules/scs/consult.php?op=scs_consult_create&stu_id=<{$stu_id|default:''}>" class="btn btn-primary"><i class="fa fa-plus"></i> 新增紀錄</a>
                                <{/if}>
                                <{if 'download'|have_consult_power:$stu_id}>
                                    <a href="<{$xoops_url}>/modules/scs/pdf_consult_stu.php?stu_id=<{$stu_id|default:''}>" class="btn btn-warning"><i class="fa fa-download"></i> 下載輔導表</a>
                                <{/if}>
                            <{elseif $now_op=="scs_students_show"}>
                                <a href="<{$xoops_url}>/modules/scs/index.php?school_year=<{$school_year|default:''}>&stu_grade=<{$stu_grade|default:''}>&stu_class=<{$stu_class|default:''}>" class="btn btn-success" style="margin: 0px 2px;"><i class="fa fa-undo"></i> 回列表</a>
                                <{if 'show'|have_scs_power:$stu_id}>
                                    <a href="<{$xoops_url}>/modules/scs/pdf.php?stu_id=<{$stu_id|default:''}>&school_year=<{$school_year|default:''}>" class="btn btn-danger" style="margin: 0px 2px;"><i class="fa fa-file-pdf"></i> 下載紀錄表</a>
                                <{/if}>
                                <{if 'update'|have_scs_power:$stu_id}>
                                    <a href="<{$xoops_url}>/modules/scs/index.php?op=scs_students_edit&stu_id=<{$stu_id|default:''}>" class="btn btn-warning" style="margin: 0px 2px;"><i class="fa fa-pencil"></i> <{$smarty.const._TAD_EDIT}></a>
                                <{/if}>
                                <{if 'index'|have_consult_power:$stu_id}>
                                    <a href="<{$xoops_url}>/modules/scs/consult.php?stu_id=<{$stu_id|default:''}>" class="btn btn-info" style="margin: 0px 2px;"><i class="fa fa-heart"></i> 輔導紀錄</a>
                                <{/if}>
                                <{if 'download'|have_consult_power:$stu_id}>
                                    <a href="<{$xoops_url}>/modules/scs/pdf_consult_stu.php?stu_id=<{$stu_id|default:''}>" class="btn btn-warning"><i class="fa fa-download"></i> 下載輔導表</a>
                                <{/if}>
                            <{/if}>
                        <{/if}>
                    <{/if}>
                <{/if}>
            </div>
            <div class="col-lg-3 col-lg-auto text-right text-end">
                <{$school_year}>年身份：
                <{if $smarty.session.stu_id|default:false}>
                    學生
                <{/if}>
                <{if $smarty.session.scs_adm|default:false}>
                    管理員
                <{/if}>
                <{if is_array($smarty.session.counselor) and $school_year|in_array:$smarty.session.counselor}>
                    輔導主任
                <{/if}>
                <{if is_array($smarty.session.tutor) and $school_year|in_array:$smarty.session.tutor}>
                    專任輔導教師
                <{/if}>
                <{if $smarty.session.tea_class_arr|default:false}>
                    <{foreach from=$smarty.session.tea_class_arr item=class}>
                        <a href="index.php?op=scs_general_index&class=<{$class|default:''}>"><{$class|default:''}></a>
                    <{/foreach}>
                    導師
                <{/if}>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function(){
            $('#school_year').on('change', function(){
                $.post('ajax.php', {op:'get_stu_grade_option', school_year:$('#school_year').val()}, function(data){
                    $('#stu_grade').show().html(data);
                });
            });
            $('#stu_grade').on('change', function(){
                $.post('ajax.php', {op:'get_stu_class_option', school_year:$('#school_year').val(), stu_grade:$('#stu_grade').val()}, function(data){
                    $('#stu_class').show().html(data);
                });
            });
            $('#stu_class').on('change', function(){
                location.href="<{$smarty.server.PHP_SELF}>?op=<{$now_op|default:''}>&school_year="+$('#school_year').val()+"&stu_grade="+$('#stu_grade').val()+"&stu_class="+$('#stu_class').val();
            });
            $('#stu_id').on('change', function(){
                location.href="<{$smarty.server.PHP_SELF}>?op=<{$now_op|default:''}>&school_year="+$('#school_year').val()+"&stu_grade="+$('#stu_grade').val()+"&stu_class="+$('#stu_class').val()+"&stu_id="+$('#stu_id').val();
            });
        });
    </script>
<{/if}>

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
