<{if $stu_id}>
    <{if 'index'|have_consult_power:$next.stu_id and $now_op=="scs_consult_show"}>
        <{assign var=new_url value="$xoops_url/modules/scs/consult.php?stu_id=`$next.stu_id`"}>
    <{elseif 'index'|have_scs_power:$next.stu_id and $now_op=="scs_consult_index"}>
        <{assign var=new_url value="$xoops_url/modules/scs/consult.php?school_year=$school_year&stu_grade=$stu_grade&stu_class=$stu_class&stu_id=`$next.stu_id`"}>
    <{elseif 'show'|have_scs_power:$next.stu_id and $now_op=="scs_students_show"}>
        <{assign var=new_url value="$xoops_url/modules/scs/index.php?school_year=$school_year&stu_grade=$stu_grade&stu_class=$stu_class&stu_id=`$next.stu_id`"}>
    <{elseif 'show'|have_scs_power:$next.stu_id and ($now_op=="scs_students_create" or $now_op=="scs_consult_create")}>
        <{assign var=new_url value="$xoops_url/modules/scs/index.php?stu_id=`$next.stu_id`"}>
    <{/if}>
    <a href="<{$new_url}>" data-toggle="tooltip" title="下一位：<{$next.stu_seat_no}> <{$next.stu_name}>" <{if $next.stu_id==''}>class="disabled"<{/if}>><img src="<{$xoops_url}>/modules/scs/images/next.png"></a>
<{/if}>
