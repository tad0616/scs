<{if $stu_id}>
    <{if 'index'|have_consult_power:$previous.stu_id and $now_op=="scs_consult_show"}>
        <{assign var=new_url value="$xoops_url/modules/scs/consult.php?stu_id=`$previous.stu_id`"}>
    <{elseif 'index'|have_scs_power:$previous.stu_id and $now_op=="scs_consult_index"}>
        <{assign var=new_url value="$xoops_url/modules/scs/consult.php?school_year=$school_year&stu_grade=$stu_grade&stu_class=$stu_class&stu_id=`$previous.stu_id`"}>
    <{elseif 'show'|have_scs_power:$previous.stu_id and $now_op=="scs_students_show"}>
        <{assign var=new_url value="$xoops_url/modules/scs/index.php?school_year=$school_year&stu_grade=$stu_grade&stu_class=$stu_class&stu_id=`$previous.stu_id`"}>
    <{elseif 'show'|have_scs_power:$previous.stu_id and ($now_op=="scs_students_create" or $now_op=="scs_consult_create")}>
        <{assign var=new_url value="$xoops_url/modules/scs/index.php?stu_id=`$previous.stu_id`"}>
    <{/if}>
    <a href="<{$new_url}>" data-toggle="tooltip" title="上一位：<{$previous.stu_seat_no}> <{$previous.stu_name}>" <{if $previous.stu_id==''}>class="disabled"<{/if}>><img src="<{$xoops_url}>/modules/scs/images/previous.png"></a>
<{/if}>
