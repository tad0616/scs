<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>

<form action="consult.php" >
    <div class="row">
        <div class="col-auto">
            <div class="input-group">
                <span class="input-group-text">篩選範圍：</span>
                <input type="text" name="start" id="start" class="form-control" value="<{$smarty.get.start}>" style="width: 10rem" onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="起始日期">
                <span class="input-group-text">至</span>
                <input type="text" name="end" id="end" class="form-control" value="<{$smarty.get.end}>"  style="width: 10rem" onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="結束日期">

                <input type="hidden" name="consult_uid" value="<{$smarty.get.consult_uid}>">
                <input type="hidden" name="stu_id" value="<{$smarty.get.stu_id}>">
                <button type="submit" class="btn btn-primary">送出</button>

            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
