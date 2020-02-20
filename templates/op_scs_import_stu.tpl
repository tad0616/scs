<h2>匯入臺南市學籍系統 Excel</h2>
<div class="row">
    <div class="col-sm-6">
        <ol>
            <li style="line-height:1.5em;">1.請從臺南市國中學籍系統匯出學生資料（如右圖），格式後請另存成xlsx格式</li>
            <li style="line-height:1.5em;">2.欄位需和範例檔一致：<a href="../demo.xlsx">範例檔</a></li>
            <li style="line-height:1.5em;">3.每學年都要匯入一次</li>
            <li style="line-height:1.5em;">4.可匯入多次，同一個學年的話會以後面匯入的資料蓋掉前面的資料</li>
            <li style="line-height:1.5em;">5.若有罕見字（如：𧛟）導致匯入錯誤，可<a href="https://www.online-toolz.com/tools/unicode-html-entities-convertor.php" target="_blank">透過此工具將罕見字轉為特殊碼</a>，並修改Excel檔內容（如：<img src="../images/html_unicode.png">）再匯入。</li>
        </ol>
        </br>
        <form action="main.php" method="post" enctype="multipart/form-data">
            <div class="form-group row custom-gutter">
                <label class="col-sm-4 col-form-label">
                    學年度
                </label>
                <div class="col-sm-8">
                    <input type="text" name="school_year" id="school_year" class="form-control validate[required]" value="<{$school_year}>" placeholder="請設定學年度">
                </div>
            </div>

            <div class="form-group row custom-gutter">
                <label class="col-sm-4 col-form-label">
                    匯入模式
                </label>
                <div class="col-sm-8">
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
                <label class="col-sm-4 col-form-label">
                    請選擇 xlsx 檔
                </label>
                <div class="col-sm-8">
                    <input type="file" name="userfile" id="userfile" class="form-control validate[required]"  placeholder="請選擇 xlsx 檔">
                </div>
            </div>
            <input type="hidden" name="op" value="scs_import_excel">
            <button type="submit" class="btn btn-primary">匯入</button>
        </form>
    </div>
    <div class="col-sm-6">
        <img src="../images/export.png" alt="從臺南市國中學籍系統匯出學生資料" class="img-fluid img-responsive">
    </div>
</div>