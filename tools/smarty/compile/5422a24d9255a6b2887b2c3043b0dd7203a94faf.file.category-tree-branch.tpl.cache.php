<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:44:59
         compiled from "F:\OpenServer\domains\realrc.test\modules\blockcategories\category-tree-branch.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25859605df36bf27468-83499680%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5422a24d9255a6b2887b2c3043b0dd7203a94faf' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\modules\\blockcategories\\category-tree-branch.tpl',
      1 => 1364210253,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25859605df36bf27468-83499680',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'last' => 0,
    'node' => 0,
    'currentCategoryId' => 0,
    'child' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605df36c111520_18227648',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605df36c111520_18227648')) {function content_605df36c111520_18227648($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'F:\\OpenServer\\domains\\realrc.test\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<li <?php if (isset($_smarty_tpl->tpl_vars['last']->value)&&$_smarty_tpl->tpl_vars['last']->value=='true'){?>class="last"<?php }?>>
	<a href="<?php echo $_smarty_tpl->tpl_vars['node']->value['link'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['currentCategoryId']->value)&&($_smarty_tpl->tpl_vars['node']->value['id']==$_smarty_tpl->tpl_vars['currentCategoryId']->value)){?>class="selected"<?php }?> title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['node']->value['desc'], 'html', 'UTF-8');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['node']->value['name'], 'html', 'UTF-8');?>
</a>
	<?php if (count($_smarty_tpl->tpl_vars['node']->value['children'])>0){?>
		<ul>
		<?php  $_smarty_tpl->tpl_vars['child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['node']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['child']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['child']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['child']->key => $_smarty_tpl->tpl_vars['child']->value){
$_smarty_tpl->tpl_vars['child']->_loop = true;
 $_smarty_tpl->tpl_vars['child']->iteration++;
 $_smarty_tpl->tpl_vars['child']->last = $_smarty_tpl->tpl_vars['child']->iteration === $_smarty_tpl->tpl_vars['child']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['categoryTreeBranch']['last'] = $_smarty_tpl->tpl_vars['child']->last;
?>
			<?php if (isset($_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['categoryTreeBranch'])&&$_smarty_tpl->getVariable('smarty')->value['foreach']['categoryTreeBranch']['last']){?>
				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['branche_tpl_path']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('node'=>$_smarty_tpl->tpl_vars['child']->value,'last'=>'true'), 0);?>

			<?php }else{ ?>
				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['branche_tpl_path']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('node'=>$_smarty_tpl->tpl_vars['child']->value,'last'=>'false'), 0);?>

			<?php }?>
		<?php } ?>
		</ul>
	<?php }?>
</li>
<?php }} ?>