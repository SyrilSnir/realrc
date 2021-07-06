<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:31:30
         compiled from "F:\OpenServer\domains\realrc.test\themes\p55_gloss_lite\order-payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6503605df0424b4d28-95563936%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea77393605e6af8e81b8910de036408904b20df4' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\themes\\p55_gloss_lite\\order-payment.tpl',
      1 => 1390293521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6503605df0424b4d28-95563936',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'opc' => 0,
    'base_dir_ssl' => 0,
    'currencySign' => 0,
    'currencyRate' => 0,
    'currencyFormat' => 0,
    'currencyBlank' => 0,
    'HOOK_TOP_PAYMENT' => 0,
    'HOOK_PAYMENT' => 0,
    'total_price' => 0,
    'taxes_enabled' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605df042658ff8_58792278',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605df042658ff8_58792278')) {function content_605df042658ff8_58792278($_smarty_tpl) {?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?>
	<script type="text/javascript">
	// <![CDATA[
	var baseDir = '<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
';
	var currencySign = '<?php echo html_entity_decode($_smarty_tpl->tpl_vars['currencySign']->value,2,"UTF-8");?>
';
	var currencyRate = '<?php echo floatval($_smarty_tpl->tpl_vars['currencyRate']->value);?>
';
	var currencyFormat = '<?php echo intval($_smarty_tpl->tpl_vars['currencyFormat']->value);?>
';
	var currencyBlank = '<?php echo intval($_smarty_tpl->tpl_vars['currencyBlank']->value);?>
';
	var txtProduct = "<?php echo smartyTranslate(array('s'=>'product'),$_smarty_tpl);?>
";
	var txtProducts = "<?php echo smartyTranslate(array('s'=>'products'),$_smarty_tpl);?>
";
	// ]]>
	</script>

	<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Your payment method'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?><h1><?php echo smartyTranslate(array('s'=>'Choose your payment method'),$_smarty_tpl);?>
</h1><?php }else{ ?><h2>3. <?php echo smartyTranslate(array('s'=>'Choose your payment method'),$_smarty_tpl);?>
</h2><?php }?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?>
	<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, 0);?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
	<div id="opc_payment_methods" class="opc-main-block">
		<div id="opc_payment_methods-overlay" class="opc-overlay" style="display: none;"></div>
<?php }?>

<div id="HOOK_TOP_PAYMENT"><?php echo $_smarty_tpl->tpl_vars['HOOK_TOP_PAYMENT']->value;?>
</div>

<?php if ($_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value){?>
	<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?><h4><?php echo smartyTranslate(array('s'=>'Please select your preferred payment method to pay the amount of'),$_smarty_tpl);?>
&nbsp;<span class="price"><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['total_price']->value),$_smarty_tpl);?>
</span> <?php if ($_smarty_tpl->tpl_vars['taxes_enabled']->value){?><?php echo smartyTranslate(array('s'=>'(tax incl.)'),$_smarty_tpl);?>
<?php }?></h4><br /><?php }?>
	<?php if ($_smarty_tpl->tpl_vars['opc']->value){?><div id="opc_payment_methods-content"><?php }?>
		<div id="HOOK_PAYMENT"><?php echo $_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value;?>
</div>
	<?php if ($_smarty_tpl->tpl_vars['opc']->value){?></div><?php }?>
<?php }else{ ?>
	<p class="warning"><?php echo smartyTranslate(array('s'=>'No payment modules have been installed.'),$_smarty_tpl);?>
</p>
<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?>
	<p class="cart_navigation"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order.php',true);?>
?step=2" title="<?php echo smartyTranslate(array('s'=>'Previous'),$_smarty_tpl);?>
" class="button">&laquo; <?php echo smartyTranslate(array('s'=>'Previous'),$_smarty_tpl);?>
</a></p>
<?php }else{ ?>
	</div>
<?php }?>

<?php }} ?>