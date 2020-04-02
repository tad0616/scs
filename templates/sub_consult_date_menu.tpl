<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>

<form action="consult.php" class="form-inline">
    <label for="start">篩選範圍：</label>
    <div class="form-group">
        <input type="text" name="start" id="start" class="form-control" value="<{$smarty.get.start}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="起始日期">
    </div>
    <div class="form-group">
        <input type="text" name="end" id="end" class="form-control" value="<{$smarty.get.end}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="結束日期">
    </div>
    <input type="hidden" name="consult_uid" value="<{$smarty.get.consult_uid}>">
    <input type="hidden" name="stu_id" value="<{$smarty.get.stu_id}>">
    <button type="submit" class="btn btn-primary">送出</button>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
