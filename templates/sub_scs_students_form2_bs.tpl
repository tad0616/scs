
<h3 id="bs_zone">兄弟姊妹</h4>
<div id="new_form">
    <{foreach from=$brother_sister key=i item=bs}>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close remove_me" data-dismiss="alert" id="<{$i|default:''}>" aria-hidden="true">
                &times;
            </button>

            <div class="form-group row mb-3 custom-gutter">
                <!--稱謂-->
                <label class="col-md-1 col-form-label text-md-right control-label">
                    稱謂
                </label>
                <div class="col-md-2">
                    <select name="scs_brother_sister[bs_relationship][<{$i|default:''}>]" id="bs_relationship<{$i|default:''}>" class="form-control " size=1>
                        <{foreach from=$bs_relationship_arr key=k item=title}>
                            <option value="<{$title|default:''}>" <{if $bs.bs_relationship == $title}>selected="selected"<{/if}>><{$title|default:''}></option>
                        <{/foreach}>
                    </select>
                </div>

                <!--姓名-->
                <label class="col-md-1 col-form-label text-md-right control-label">
                    姓名
                </label>
                <div class="col-md-2">
                    <input type="text" name="scs_brother_sister[bs_name][<{$i|default:''}>]" id="bs_name<{$i|default:''}>" class="form-control" value="<{$bs.bs_name}>" placeholder="姓名">
                </div>

                <!--畢業（肄）學校-->
                <label class="col-md-1 col-form-label text-md-right control-label">
                    畢業校
                </label>
                <div class="col-md-2">
                    <input type="text" name="scs_brother_sister[bs_school][<{$i|default:''}>]" id="bs_school<{$i|default:''}>" class="form-control" value="<{$bs.bs_school}>" placeholder="畢（肄）業學校">
                </div>

                <!--出生年次-->
                <label class="col-md-1 col-form-label text-md-right control-label">
                    出生年
                </label>
                <div class="col-md-2">
                    <input type="text" name="scs_brother_sister[bs_year][<{$i|default:''}>]" id="bs_year<{$i|default:''}>" class="form-control " value="<{$bs.bs_year}>" placeholder="出生年">
                </div>
            </div>

            <!--備註-->
            <div class="form-group row mb-3 custom-gutter">
                <label class="col-md-1 col-form-label text-md-right control-label">
                    <{$smarty.const._MD_SCS_BS_NOTE}>
                </label>
                <div class="col-md-11">
                    <input type="text" name="scs_brother_sister[bs_note][<{$i|default:''}>]" id="bs_note<{$i|default:''}>" class="form-control " value="<{$bs.bs_note}>" placeholder="<{$smarty.const._MD_SCS_BS_NOTE}>">
                </div>
            </div>
        </div>
    <{/foreach}>
</div>

<!--表單樣板-->

<div style="display:none;">
    <div class="alert alert-success alert-dismissable" id="form_data">
        <button type="button" class="close" data-dismiss="alert" id="remove_me" aria-hidden="true">
            &times;
        </button>
        <div class="form-group row mb-3 custom-gutter">
            <!--稱謂-->
            <label class="col-md-1 col-form-label text-md-right control-label">
                稱謂
            </label>
            <div class="col-md-2">
                <select data-name="scs_brother_sister[bs_relationship]" id="bs_relationship" class="form-control " size=1>
                    <{foreach from=$bs_relationship_arr key=k item=title}>
                        <option value="<{$title|default:''}>"><{$title|default:''}></option>
                    <{/foreach}>
                </select>
            </div>

            <!--姓名-->
            <label class="col-md-1 col-form-label text-md-right control-label">
                姓名
            </label>
            <div class="col-md-2">
                <input type="text" data-name="scs_brother_sister[bs_name]" id="bs_name" class="form-control" value="" placeholder="姓名">
            </div>

            <!--畢業（肄）學校-->
            <label class="col-md-1 col-form-label text-md-right control-label">
                畢業校
            </label>
            <div class="col-md-2">
                <input type="text" data-name="scs_brother_sister[bs_school]" id="bs_school" class="form-control" value="" placeholder="畢（肄）業學校">
            </div>

            <!--出生年次-->
            <label class="col-md-1 col-form-label text-md-right control-label">
                出生年
            </label>
            <div class="col-md-2">
                <input type="text" data-name="scs_brother_sister[bs_year]" id="bs_year" class="form-control " value="" placeholder="出生年">
            </div>
        </div>

        <!--備註-->
        <div class="form-group row mb-3 custom-gutter">
            <label class="col-md-1 col-form-label text-md-right control-label">
                <{$smarty.const._MD_SCS_BS_NOTE}>
            </label>
            <div class="col-md-11">
                <input type="text" data-name="scs_brother_sister[bs_note]" id="bs_note" class="form-control " value="" placeholder="<{$smarty.const._MD_SCS_BS_NOTE}>">
            </div>
        </div>
    </div>
    <button type="button" id="remove_me" class="btn btn-sm btn-danger" ><{$smarty.const._TAD_DEL}></button>
</div>

<div class="text-right">
    <a href="#bs_zone" id="add_form" class="btn btn-success">新增兄弟姊妹</a>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        <{if $bs|default:false}>
            var form_index=<{$i|default:''}>;
        <{else}>
            var form_index=0;
            form_index = clone_form(form_index);
        <{/if}>

        $("#add_form").click(function(){
            form_index = clone_form(form_index);
        });

        $(".remove_me").click(function(){
            $(this).closest("#form_data" + $(this).prop("id")).remove();
        });
    });



    function clone_form(form_index){

        form_index++;
        //複製表單
        $("#new_form").append($("#form_data").clone().prop("id","form_data" + form_index));

        $("#form_data" + form_index + "  input").each(function(){
            $(this).prop("name",$(this).data("name") + "[" + form_index+"]");
            $(this).prop("id",$(this).prop("id") + form_index);
            $(this).data("id", form_index);
        });

        $("#form_data" + form_index + "  select").each(function(){
            $(this).prop("name",$(this).data("name") + "[" + form_index+"]");
            $(this).prop("id",$(this).prop("id") + form_index);
            $(this).data("id", form_index);
        });

        $("#form_data" + form_index + "  div").each(function(){
            $(this).prop("id",$(this).prop("id") + form_index);
        });

        $("#remove_me" + form_index).click(function(){
            $(this).closest("#form_data" + form_index).remove();
        });

        return form_index;
    }

</script>