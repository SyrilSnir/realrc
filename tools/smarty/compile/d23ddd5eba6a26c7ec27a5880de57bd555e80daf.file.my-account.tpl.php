<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:48:33
         compiled from "F:\OpenServer\domains\realrc.test\modules\blockwishlist\my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7296605df44177d5d3-77772074%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd23ddd5eba6a26c7ec27a5880de57bd555e80daf' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\modules\\blockwishlist\\my-account.tpl',
      1 => 1364210254,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7296605df44177d5d3-77772074',
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
  'unifunc' => 'content_605df4417ee098_39441937',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605df4417ee098_39441937')) {function content_605df4417ee098_39441937($_smarty_tpl) {?>

<!-- MODULE WishList -->
<li>
<a href="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/blockwishlist/mywishlist.php" title="<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['module_template_dir']->value;?>
logo.gif" alt="<?php echo smartyTranslate(array('s'=>'wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/blockwishlist/mywishlist.php" title="<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
</a>
</li>
<!-- END : MODULE WishList --><?php }} ?>