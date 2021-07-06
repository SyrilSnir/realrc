<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:31:43
         compiled from "F:\OpenServer\domains\realrc.test\modules\cashondelivery\confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25364605df04fc1ed61-08438912%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f81a6f8718f35a74ce0ea09bf01ee9738f7ea79d' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\modules\\cashondelivery\\confirmation.tpl',
      1 => 1390293506,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25364605df04fc1ed61-08438912',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shop_name' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605df04fcb0a47_04519078',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605df04fcb0a47_04519078')) {function content_605df04fcb0a47_04519078($_smarty_tpl) {?>

<p><?php echo smartyTranslate(array('s'=>'Your order on','mod'=>'cashondelivery'),$_smarty_tpl);?>
 <span class="bold"><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</span> <?php echo smartyTranslate(array('s'=>'is complete.','mod'=>'cashondelivery'),$_smarty_tpl);?>

	<br /><br />
	<?php echo smartyTranslate(array('s'=>'You have chosen the cash on delivery method.','mod'=>'cashondelivery'),$_smarty_tpl);?>

	<br /><br /><span class="bold"><?php echo smartyTranslate(array('s'=>'Your order will be sent very soon.','mod'=>'cashondelivery'),$_smarty_tpl);?>
</span>
	<br /><br /><?php echo smartyTranslate(array('s'=>'For any questions or for further information, please contact our','mod'=>'cashondelivery'),$_smarty_tpl);?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('contact-form.php',true);?>
"><?php echo smartyTranslate(array('s'=>'customer support','mod'=>'cashondelivery'),$_smarty_tpl);?>
</a>.
</p>
<?php }} ?>