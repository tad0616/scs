<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>

<style>
    .zipcode, .county, .district {width: 120px; display: inline-block}
</style>
<script type="text/javascript" src="<{$xoops_url}>/modules/scs/class/jquery.twzipcode.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/scs/class/datalist.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#twzipcode1").twzipcode();
        $("#twzipcode2").twzipcode();
        $('input.readonly').keyup(resizeInput).each(resizeInput);
        var maxHeight = '200px';
        var openOnClick = true;
        $('input[list]').datalist(maxHeight, openOnClick);
        // $('[data-toggle="tooltip"]').tooltip();
    });

    function resizeInput() {
        var text_length=$(this).val().length;
        if(text_length==0){
            text_length=3;
        }
        $(this).css('width', (text_length * 18) + 20);
    }

</script>

<h2 class="text-center"><{$student.stu_name}>綜合資料紀錄表</h2>

<div class="alert alert-info">
    <{includeq file="$xoops_rootpath/modules/scs/templates/sub_year_grade_class_menu.tpl"}>
</div>

<!--套用formValidator驗證機制-->
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal">

    <{includeq file="$xoops_rootpath/modules/scs/templates/sub_scs_students_form0.tpl"}>

    <div id="demoTab">
        <ul class="resp-tabs-list vert">
            <li>1.本人概況</li>
            <li>2.家長狀況</li>
            <li>3.學習概況</li>
            <li>4.自傳</li>
            <li>5.自我認識</li>
            <li>6.生活感想</li>
            <li>7.畢業後計畫</li>
            <li>8.備註</li>
        </ul>

        <div class="resp-tabs-container vert">
            <div><{includeq file="$xoops_rootpath/modules/scs/templates/sub_scs_students_form1.tpl"}></div>
            <div><{includeq file="$xoops_rootpath/modules/scs/templates/sub_scs_students_form2.tpl"}></div>
            <div><{includeq file="$xoops_rootpath/modules/scs/templates/sub_scs_students_form3.tpl"}></div>
            <div><{includeq file="$xoops_rootpath/modules/scs/templates/sub_scs_students_form4.tpl"}></div>
            <div><{includeq file="$xoops_rootpath/modules/scs/templates/sub_scs_students_form5.tpl"}></div>
            <div><{includeq file="$xoops_rootpath/modules/scs/templates/sub_scs_students_form6.tpl"}></div>
            <div><{includeq file="$xoops_rootpath/modules/scs/templates/sub_scs_students_form7.tpl"}></div>
            <div><{includeq file="$xoops_rootpath/modules/scs/templates/sub_scs_students_form8.tpl"}></div>
        </div>
    </div>

    <div class="text-center" style="margin:30px auto;">
        <{$token_form}>
        <input type="hidden" name="op" value="<{$next_op}>">
        <input type="hidden" name="stu_id" value="<{$stu_id}>">
        <input type="hidden" name="school_year" value="<{$school_year}>">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>
