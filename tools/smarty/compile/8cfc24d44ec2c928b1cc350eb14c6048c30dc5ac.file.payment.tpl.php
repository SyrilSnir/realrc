<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:31:30
         compiled from "F:\OpenServer\domains\realrc.test\modules\cashondelivery\payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14630605df04237bb25-75310049%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8cfc24d44ec2c928b1cc350eb14c6048c30dc5ac' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\modules\\cashondelivery\\payment.tpl',
      1 => 1390293506,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14630605df04237bb25-75310049',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this_path_ssl' => 0,
    'this_path' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605df0423f4bf9_05111706',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605df0423f4bf9_05111706')) {function content_605df0423f4bf9_05111706($_smarty_tpl) {?>

<p class="payment_module">
	<a href="<?php echo $_smarty_tpl->tpl_vars['this_path_ssl']->value;?>
validation.php" title="<?php echo smartyTranslate(array('s'=>'Pay with cash on delivery (COD)','mod'=>'cashondelivery'),$_smarty_tpl);?>
">
		<img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
cashondelivery.gif" alt="<?php echo smartyTranslate(array('s'=>'Pay with cash on delivery (COD)','mod'=>'cashondelivery'),$_smarty_tpl);?>
" style="float:left;" />
		<br /><?php echo smartyTranslate(array('s'=>'Pay with cash on delivery (COD)','mod'=>'cashondelivery'),$_smarty_tpl);?>

		<br /><?php echo smartyTranslate(array('s'=>'You pay for the merchandise upon delivery','mod'=>'cashondelivery'),$_smarty_tpl);?>

		<br style="clear:both;" />
	</a>
</p><?php }} ?>