<h2>匯入臺南市學籍系統 Excel</h2>
<div class="alert alert-info">
<ol>
<li>1.格式一律為xlsx</li>
<li>2.欄位需和範例檔一致：<a href="../demo.xlsx">範例檔</a></li>
<li>3.每學年都要匯入一次</li>
<li>4.可匯入多次，同一個學年的話會以後面匯入的資料蓋掉前面的資料</li>
</ol>
</div>
<form action="main.php" method="post" enctype="multipart/form-data">
    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label">
            學年度
        </label>
        <div class="col-sm-4">
            <input type="text" name="school_year" id="school_year" class="form-control validate[required]" value="<{$school_year}>" placeholder="請設定學年度">
        </div>
    </div>

    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label">
            匯入模式
        </label>
        <div class="col-sm-4">
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="mode" id="scs_import_excel" value="scs_import_excel">
                    預覽後再匯入（適合量小，約1000人以下）
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="mode" id="scs_import_to_db" value="scs_import_to_db" checked>
                    直接匯入（適合量大，約1000人以上）
                </label>
            </div>
        </div>
    </div>


    <!--請選擇 xlsx 檔-->
    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label">
            請選擇 xlsx 檔
        </label>
        <div class="col-sm-4">
            <input type="file" name="userfile" id="userfile" class="form-control validate[required]"  placeholder="請選擇 xlsx 檔">
        </div>
    </div>
    <input type="hidden" name="op" value="scs_import_excel">
    <button type="submit" class="btn btn-primary">匯入</button>
</form>