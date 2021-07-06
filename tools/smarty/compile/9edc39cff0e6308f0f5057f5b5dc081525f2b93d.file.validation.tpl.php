<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:31:32
         compiled from "F:\OpenServer\domains\realrc.test\modules\cashondelivery\validation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27867605df0441cd6b4-89823879%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9edc39cff0e6308f0f5057f5b5dc081525f2b93d' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\modules\\cashondelivery\\validation.tpl',
      1 => 1476348853,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27867605df0441cd6b4-89823879',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this_path_ssl' => 0,
    'this_path' => 0,
    'currencies' => 0,
    'total' => 0,
    'use_taxes' => 0,
    'oldMessage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605df0442da654_77758709',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605df0442da654_77758709')) {function content_605df0442da654_77758709($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Shipping','mod'=>'cashondelivery'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<h2><?php echo smartyTranslate(array('s'=>'Order summation','mod'=>'cashondelivery'),$_smarty_tpl);?>
</h2>

<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<h3><?php echo smartyTranslate(array('s'=>'Cash on delivery (COD) payment','mod'=>'cashondelivery'),$_smarty_tpl);?>
</h3>

<form action="<?php echo $_smarty_tpl->tpl_vars['this_path_ssl']->value;?>
validation.php" method="post">
	<input type="hidden" name="confirm" value="1" />
	<p>
		<img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
cashondelivery.jpg" alt="<?php echo smartyTranslate(array('s'=>'Cash on delivery (COD) payment','mod'=>'cashondelivery'),$_smarty_tpl);?>
" style="float:left; margin: 0px 10px 5px 0px;" />
		<?php echo smartyTranslate(array('s'=>'You have chosen the cash on delivery method.','mod'=>'cashondelivery'),$_smarty_tpl);?>

		<br/><br />
		<?php echo smartyTranslate(array('s'=>'The total amount of your order is','mod'=>'cashondelivery'),$_smarty_tpl);?>

		<span id="amount_<?php echo $_smarty_tpl->tpl_vars['currencies']->value[0]['id_currency'];?>
" class="price"><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['total']->value),$_smarty_tpl);?>
</span>
		<?php if ($_smarty_tpl->tpl_vars['use_taxes']->value==1){?>
		    <?php echo smartyTranslate(array('s'=>'(tax incl.)','mod'=>'cashondelivery'),$_smarty_tpl);?>

		<?php }?>
	</p>
	<p>
            <div id="ordermsg">
                <p>Если вы хотели бы добавить комментарий о вашем заказе, пожалуйста, напишите его ниже.</p>
                <p class="textarea"><textarea cols="60" rows="3" name="message"><?php if (isset($_smarty_tpl->tpl_vars['oldMessage']->value)){?><?php echo $_smarty_tpl->tpl_vars['oldMessage']->value;?>
<?php }?></textarea></p>
            </div>
		<br /><br />
		<br /><br />
		<b><?php echo smartyTranslate(array('s'=>'Please confirm your order by clicking \'I confirm my order\'','mod'=>'cashondelivery'),$_smarty_tpl);?>
.</b>
	</p>
	<p class="cart_navigation">
		<!--</a><a href="</a>-->
		<input type="submit" name="submit" value="<?php echo smartyTranslate(array('s'=>'I confirm my order','mod'=>'cashondelivery'),$_smarty_tpl);?>
" class="exclusive_large" />
	</p>
</form>
<?php }} ?>