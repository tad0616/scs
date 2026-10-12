<div class="container-fluid" style="margin-bottom: 30px;">
    <{if $now_op|default:false}>
        <{include file="$xoops_rootpath/modules/scs/templates/op_`$now_op`.tpl"}>
    <{/if}>
</div>