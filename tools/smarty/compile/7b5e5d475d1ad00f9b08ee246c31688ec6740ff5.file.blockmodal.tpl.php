<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:11:47
         compiled from "F:\OpenServer\domains\realrc.test\modules\blockmodal\blockmodal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8135605deba33164b7-84961906%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b5e5d475d1ad00f9b08ee246c31688ec6740ff5' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\modules\\blockmodal\\blockmodal.tpl',
      1 => 1406690721,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8135605deba33164b7-84961906',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'active' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605deba33444e6_21646622',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605deba33444e6_21646622')) {function content_605deba33444e6_21646622($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['active']->value==1){?>
<div id="contentmodal" style="display: none;"><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
</div>


<!-- Block modal -->
<script>
$(document).ready(function() {

 var content = $("#contentmodal").html();
 var topbox =   $(window).scrollTop()+100;
 var width  = ($(window).width()/2)-445;  
$('.paulund_modal').paulund_modal_box({
                            	title:'Second Title Box',
	                        	description:content,
                                top: topbox+"px",
                                left: width+"px",
                                textbutton: "Ознакомлен",
                                //textbutton: "<?php echo smartyTranslate(array('s'=>'button','mod'=>'blockmodal'),$_smarty_tpl);?>
",
                            
                            
                            });
                            
                            
  });
</script>
<!-- /Block modal-->
<?php }?>
<?php }} ?>