<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:11:48
         compiled from "F:\OpenServer\domains\realrc.test\themes\p55_gloss_lite\breadcrumb.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17298605deba4da5092-56164209%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d18a7c7f64a438b469ef89f59093362bcd6c45e' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\themes\\p55_gloss_lite\\breadcrumb.tpl',
      1 => 1390293520,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17298605deba4da5092-56164209',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir' => 0,
    'path' => 0,
    'navigationPipe' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605deba4e4fd04_29499034',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605deba4e4fd04_29499034')) {function content_605deba4e4fd04_29499034($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'F:\\OpenServer\\domains\\realrc.test\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<!-- Breadcrumb -->
<?php if (isset(Smarty::$_smarty_vars['capture']['path'])){?><?php $_smarty_tpl->tpl_vars['path'] = new Smarty_variable(Smarty::$_smarty_vars['capture']['path'], null, 0);?><?php }?>
<div class="breadcrumb">
	<a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smartyTranslate(array('s'=>'return to'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
</a><?php if (isset($_smarty_tpl->tpl_vars['path']->value)&&$_smarty_tpl->tpl_vars['path']->value){?><span class="navigation-pipe"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['navigationPipe']->value, 'html', 'UTF-8');?>
</span><?php if (!strpos($_smarty_tpl->tpl_vars['path']->value,'span')){?><span class="navigation_page"><?php echo $_smarty_tpl->tpl_vars['path']->value;?>
</span><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['path']->value;?>
<?php }?><?php }?>
</div>
<!-- /Breadcrumb --><?php }} ?>