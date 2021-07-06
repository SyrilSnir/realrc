<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:30:31
         compiled from "F:\OpenServer\domains\realrc.test\themes\p55_gloss_lite\product-compare.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1502605df0079984d3-28560548%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0dda7335b6c26feb4065925d4bb84d69bc4bf2d' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\themes\\p55_gloss_lite\\product-compare.tpl',
      1 => 1390293521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1502605df0079984d3-28560548',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'comparator_max_item' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605df007a1daf5_26845599',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605df007a1daf5_26845599')) {function content_605df007a1daf5_26845599($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['comparator_max_item']->value){?>
<script type="text/javascript">
// <![CDATA[
	var min_item = '<?php echo smartyTranslate(array('s'=>'Please select at least one product.','js'=>1),$_smarty_tpl);?>
';
	var max_item = "<?php echo smartyTranslate(array('s'=>'You cannot add more than','js'=>1),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['comparator_max_item']->value;?>
 <?php echo smartyTranslate(array('s'=>'product(s) in the product comparator','js'=>1),$_smarty_tpl);?>
";
//]]>
</script>
	<form class="productsCompareForm" method="get" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('products-comparison.php',true);?>
" onsubmit="true">
		<p>
		<input type="submit" class="button" value="<?php echo smartyTranslate(array('s'=>'Compare'),$_smarty_tpl);?>
" style="float:right" />
		<input type="hidden" name="compare_product_list" class="compare_product_list" value="" />
		</p>
	</form>
<?php }?>

<?php }} ?>