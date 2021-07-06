<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:48:33
         compiled from "F:\OpenServer\domains\realrc.test\themes\p55_gloss_lite\my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18174605df4419c2dd9-66692372%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d83937c590b7f2a75c790be132aeae2ba005610' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\themes\\p55_gloss_lite\\my-account.tpl',
      1 => 1409651802,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18174605df4419c2dd9-66692372',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir_ssl' => 0,
    'sdiscount' => 0,
    'link' => 0,
    'img_dir' => 0,
    'returnAllowed' => 0,
    'voucherAllowed' => 0,
    'HOOK_CUSTOMER_ACCOUNT' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605df441d1ca32_41935892',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605df441d1ca32_41935892')) {function content_605df441d1ca32_41935892($_smarty_tpl) {?>

<script type="text/javascript">
//<![CDATA[
	var baseDir = '<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
';
//]]>
</script>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'My account'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<h1><?php echo smartyTranslate(array('s'=>'My account'),$_smarty_tpl);?>
</h1>
<h4><?php echo smartyTranslate(array('s'=>'Welcome to your account. Here you can manage your addresses and orders.'),$_smarty_tpl);?>
</h4>
<?php if ($_smarty_tpl->tpl_vars['sdiscount']->value!=0){?>
<h4 style="font-size: 12px;">Ваш текущий статус – <?php echo $_smarty_tpl->tpl_vars['sdiscount']->value['reals']['name_sdiscount'];?>
, скидка: <?php echo $_smarty_tpl->tpl_vars['sdiscount']->value['reals']['percent_sdiscount'];?>
%.<?php if ($_smarty_tpl->tpl_vars['sdiscount']->value['reals']['id_sdiscount']!=4){?> До следующего статуса: <?php echo $_smarty_tpl->tpl_vars['sdiscount']->value['next']['name_sdiscount'];?>
, скидка: <?php echo $_smarty_tpl->tpl_vars['sdiscount']->value['next']['percent_sdiscount'];?>
% Вам осталось сделать заказов на сумму: <?php echo $_smarty_tpl->tpl_vars['sdiscount']->value['leftOrdered'];?>
 руб.
<?php }?>
</h4>
<?php }?>
<ul>
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('history.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Orders'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/order.gif" alt="<?php echo smartyTranslate(array('s'=>'Orders'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('history.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Orders'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'History and details of my orders'),$_smarty_tpl);?>
</a></li>
	<?php if ($_smarty_tpl->tpl_vars['returnAllowed']->value){?>
		<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order-follow.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Merchandise returns'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/return.gif" alt="<?php echo smartyTranslate(array('s'=>'Merchandise returns'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order-follow.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Merchandise returns'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My merchandise returns'),$_smarty_tpl);?>
</a></li>
	<?php }?>
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order-slip.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Credit slips'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/slip.gif" alt="<?php echo smartyTranslate(array('s'=>'Credit slips'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order-slip.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Credit slips'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My credit slips'),$_smarty_tpl);?>
</a></li>
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('addresses.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Addresses'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/addrbook.gif" alt="<?php echo smartyTranslate(array('s'=>'Addresses'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('addresses.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Addresses'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My addresses'),$_smarty_tpl);?>
</a></li>
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('identity.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Information'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/userinfo.gif" alt="<?php echo smartyTranslate(array('s'=>'Information'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('identity.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Information'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My personal information'),$_smarty_tpl);?>
</a></li>
	<?php if ($_smarty_tpl->tpl_vars['voucherAllowed']->value){?>
		<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('discount.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Vouchers'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/voucher.gif" alt="<?php echo smartyTranslate(array('s'=>'Vouchers'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('discount.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Vouchers'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My vouchers'),$_smarty_tpl);?>
</a></li>
	<?php }?>
    
    <?php if ($_smarty_tpl->tpl_vars['sdiscount']->value!=0){?>
     <div style="height: 150px;width: 304px; border: 0px solid #E4E4E4; float:right;margin: -150px 0 0 0;" >
     <div style="float: left; height: 150px;width: 150px;border:1px solid #E4E4E4 ;" >
       <span style="color: #3A91E8;font-size: 65px;font-weight: bold;display: block;text-align: center; margin-top:30px;">-<?php echo $_smarty_tpl->tpl_vars['sdiscount']->value['reals']['percent_sdiscount'];?>
%</span>
     </div>
     <div style="float: right; height: 150px;width: 150px;border:1px solid #E4E4E4 ;" >
      <?php if ($_smarty_tpl->tpl_vars['sdiscount']->value['reals']['file_sdiscount']==1){?>
      <object width="150" height="150">
         <param name="movie" value="/img/<?php echo $_smarty_tpl->tpl_vars['sdiscount']->value['reals']['image_sdiscount'];?>
">
         <embed src="/img/<?php echo $_smarty_tpl->tpl_vars['sdiscount']->value['reals']['image_sdiscount'];?>
" width="150" height="150"></embed>
      </object>
      
      <?php }else{ ?>
      
        <img src="/img/<?php echo $_smarty_tpl->tpl_vars['sdiscount']->value['reals']['image_sdiscount'];?>
"/>
      
      <?php }?>
     </div>
      
     
     </div>
    
    <?php }?>
    
	<?php echo $_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value;?>

</ul>
<p><a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/home.gif" alt="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
</a></p>
<?php }} ?>