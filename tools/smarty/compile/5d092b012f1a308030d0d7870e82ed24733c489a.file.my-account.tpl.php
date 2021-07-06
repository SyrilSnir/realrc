<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:48:33
         compiled from "F:\OpenServer\domains\realrc.test\modules\mailalerts\my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21177605df4418ca704-68465898%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d092b012f1a308030d0d7870e82ed24733c489a' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\modules\\mailalerts\\my-account.tpl',
      1 => 1364210258,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21177605df4418ca704-68465898',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir_ssl' => 0,
    'module_template_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605df44190f159_77450945',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605df44190f159_77450945')) {function content_605df44190f159_77450945($_smarty_tpl) {?>

<!-- MODULE MailAlerts -->
<li>
	<a href="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/mailalerts/myalerts.php" title="<?php echo smartyTranslate(array('s'=>'My alerts','mod'=>'mailalerts'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['module_template_dir']->value;?>
logo.gif" alt="<?php echo smartyTranslate(array('s'=>'alerts','mod'=>'mailalerts'),$_smarty_tpl);?>
" class="icon" /></a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/mailalerts/myalerts.php" title="<?php echo smartyTranslate(array('s'=>'My alerts','mod'=>'mailalerts'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My alerts','mod'=>'mailalerts'),$_smarty_tpl);?>
</a>
</li>
<!-- END : MODULE MailAlerts --><?php }} ?>