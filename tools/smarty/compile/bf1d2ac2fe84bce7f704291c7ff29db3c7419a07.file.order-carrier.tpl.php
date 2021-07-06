<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:11:47
         compiled from "F:\OpenServer\domains\realrc.test\themes\p55_gloss_lite\order-carrier.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21789605deba3bce2f7-28529494%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf1d2ac2fe84bce7f704291c7ff29db3c7419a07' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\themes\\p55_gloss_lite\\order-carrier.tpl',
      1 => 1616767884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21789605deba3bce2f7-28529494',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_MODAL' => 0,
    'opc' => 0,
    'base_dir_ssl' => 0,
    'currencySign' => 0,
    'currencyRate' => 0,
    'currencyFormat' => 0,
    'currencyBlank' => 0,
    'virtual_cart' => 0,
    'giftAllowed' => 0,
    'cart' => 0,
    'link' => 0,
    'conditions' => 0,
    'cms_id' => 0,
    'checkedTOS' => 0,
    'link_conditions' => 0,
    'carriers' => 0,
    'HOOK_BEFORECARRIER' => 0,
    'isVirtualCart' => 0,
    'recyclablePackAllowed' => 0,
    'recyclable' => 0,
    'carrier' => 0,
    'isLogged' => 0,
    'checked' => 0,
    'priceDisplay' => 0,
    'use_taxes' => 0,
    'price_for_boxberry' => 0,
    'boxberry_widget_config' => 0,
    'HOOK_EXTRACARRIER' => 0,
    'gift_wrapping_price' => 0,
    'total_wrapping_tax_exc_cost' => 0,
    'total_wrapping_cost' => 0,
    'back' => 0,
    'is_guest' => 0,
    'oldMessage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605deba4314340_85543617',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605deba4314340_85543617')) {function content_605deba4314340_85543617($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'F:\\OpenServer\\domains\\realrc.test\\tools\\smarty\\plugins\\modifier.escape.php';
?>
<?php echo $_smarty_tpl->tpl_vars['HOOK_MODAL']->value;?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?>
	<script type="text/javascript">
	//<![CDATA[
		var baseDir = '<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
';
		var orderProcess = 'order';
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

		var msg = "<?php echo smartyTranslate(array('s'=>'You must agree to the terms of service before continuing.','js'=>1),$_smarty_tpl);?>
";
		
		function acceptCGV()
		{
			if ($('#cgv').length && !$('input#cgv:checked').length)
			{
				alert(msg);
				return false;
			}
			else
				return true;
		}
		
	//]]>
	</script>
<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['virtual_cart']->value&&$_smarty_tpl->tpl_vars['giftAllowed']->value&&$_smarty_tpl->tpl_vars['cart']->value->gift==1){?>
<script type="text/javascript">

// <![CDATA[
    $('document').ready( function(){
		if ($('input#gift').is(':checked'))
			$('p#gift_div').show();
    });
//]]>

</script>
<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?>
<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Shipping'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?><h1><?php echo smartyTranslate(array('s'=>'Shipping'),$_smarty_tpl);?>
</h1><?php }else{ ?><h2>2. <?php echo smartyTranslate(array('s'=>'Delivery methods'),$_smarty_tpl);?>
</h2><?php }?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?>
<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('shipping', null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<form id="form" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order.php',true);?>
" method="post" onsubmit="return acceptCGV();">
<?php }else{ ?>
<div id="opc_delivery_methods" class="opc-main-block">
	<div id="opc_delivery_methods-overlay" class="opc-overlay" style="display: none;"></div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['conditions']->value&&$_smarty_tpl->tpl_vars['cms_id']->value){?>
	<h3 class="condition_title"><?php echo smartyTranslate(array('s'=>'Terms of service'),$_smarty_tpl);?>
</h3>
	<p class="checkbox">
		<input type="checkbox" name="cgv" id="cgv" value="1" <?php if ($_smarty_tpl->tpl_vars['checkedTOS']->value){?>checked="checked"<?php }?> />
		<label for="cgv"><?php echo smartyTranslate(array('s'=>'I agree to the terms of service and adhere to them unconditionally.'),$_smarty_tpl);?>
</label> <a href="<?php echo $_smarty_tpl->tpl_vars['link_conditions']->value;?>
" class="iframe"><?php echo smartyTranslate(array('s'=>'(read)'),$_smarty_tpl);?>
</a>
	</p>
	<script type="text/javascript">$('a.iframe').fancybox();</script>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['virtual_cart']->value){?>
	<input id="input_virtual_carrier" class="hidden" type="hidden" name="id_carrier" value="0" />
<?php }else{ ?>
	<h3 class="carrier_title"><?php echo smartyTranslate(array('s'=>'Choose your delivery method'),$_smarty_tpl);?>
</h3>
	
	<div id="HOOK_BEFORECARRIER"><?php if (isset($_smarty_tpl->tpl_vars['carriers']->value)){?><?php echo $_smarty_tpl->tpl_vars['HOOK_BEFORECARRIER']->value;?>
<?php }?></div>
	<?php if (isset($_smarty_tpl->tpl_vars['isVirtualCart']->value)&&$_smarty_tpl->tpl_vars['isVirtualCart']->value){?>
	<p class="warning"><?php echo smartyTranslate(array('s'=>'No carrier needed for this order'),$_smarty_tpl);?>
</p>
	<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['recyclablePackAllowed']->value){?>
	<p class="checkbox">
		<input type="checkbox" name="recyclable" id="recyclable" value="1" <?php if ($_smarty_tpl->tpl_vars['recyclable']->value==1){?>checked="checked"<?php }?> />
		<label for="recyclable"><?php echo smartyTranslate(array('s'=>'I agree to receive my order in recycled packaging'),$_smarty_tpl);?>
.</label>
	</p>
	<?php }?>
	<p class="warning" id="noCarrierWarning" <?php if (isset($_smarty_tpl->tpl_vars['carriers']->value)&&$_smarty_tpl->tpl_vars['carriers']->value&&count($_smarty_tpl->tpl_vars['carriers']->value)){?>style="display:none;"<?php }?>><?php echo smartyTranslate(array('s'=>'There are no carriers available that deliver to this address.'),$_smarty_tpl);?>
</p>
	<table id="carrierTable" class="std" <?php if (!isset($_smarty_tpl->tpl_vars['carriers']->value)||!$_smarty_tpl->tpl_vars['carriers']->value||!count($_smarty_tpl->tpl_vars['carriers']->value)){?>style="display:none;"<?php }?>>
		<thead>
			<tr>
				<th class="carrier_action first_item"></th>
				<th class="carrier_name item"><?php echo smartyTranslate(array('s'=>'Carrier'),$_smarty_tpl);?>
</th>
				<th class="carrier_infos item"><?php echo smartyTranslate(array('s'=>'Information'),$_smarty_tpl);?>
</th>
				<th class="carrier_price last_item"><?php echo smartyTranslate(array('s'=>'Price'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
		<tbody>
		<?php if (isset($_smarty_tpl->tpl_vars['carriers']->value)){?>
			<?php  $_smarty_tpl->tpl_vars['carrier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['carrier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['carriers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['carrier']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['carrier']->iteration=0;
 $_smarty_tpl->tpl_vars['carrier']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['carrier']->key => $_smarty_tpl->tpl_vars['carrier']->value){
$_smarty_tpl->tpl_vars['carrier']->_loop = true;
 $_smarty_tpl->tpl_vars['carrier']->iteration++;
 $_smarty_tpl->tpl_vars['carrier']->index++;
 $_smarty_tpl->tpl_vars['carrier']->first = $_smarty_tpl->tpl_vars['carrier']->index === 0;
 $_smarty_tpl->tpl_vars['carrier']->last = $_smarty_tpl->tpl_vars['carrier']->iteration === $_smarty_tpl->tpl_vars['carrier']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['first'] = $_smarty_tpl->tpl_vars['carrier']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['last'] = $_smarty_tpl->tpl_vars['carrier']->last;
?>
				<tr class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['first']){?>first_item<?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['last']){?>last_item<?php }?> <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['index']%2){?>alternate_item<?php }else{ ?>item<?php }?><?php if ($_smarty_tpl->tpl_vars['carrier']->value['external_module_name']){?> <?php echo $_smarty_tpl->tpl_vars['carrier']->value['external_module_name'];?>
_block<?php }?>">
					<td class="carrier_action radio">
						<input <?php if ($_smarty_tpl->tpl_vars['carrier']->value['external_module_name']){?>class="<?php echo $_smarty_tpl->tpl_vars['carrier']->value['external_module_name'];?>
" <?php }?>type="radio" name="id_carrier" value="<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']);?>
" id="id_carrier<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']);?>
"  <?php if ($_smarty_tpl->tpl_vars['opc']->value){?>onclick="updateCarrierSelectionAndGift();"<?php }?> <?php if (!($_smarty_tpl->tpl_vars['carrier']->value['is_module']&&$_smarty_tpl->tpl_vars['opc']->value&&!$_smarty_tpl->tpl_vars['isLogged']->value)){?><?php if ($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']==$_smarty_tpl->tpl_vars['checked']->value){?>checked="checked"<?php }?><?php }else{ ?>disabled="disabled"<?php }?> />
					</td>
					<td class="carrier_name">
						<label for="id_carrier<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']);?>
">
							<?php if ($_smarty_tpl->tpl_vars['carrier']->value['img']){?><img src="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['carrier']->value['img'], 'htmlall', 'UTF-8');?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['carrier']->value['name'], 'htmlall', 'UTF-8');?>
" /><?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['carrier']->value['name'], 'htmlall', 'UTF-8');?>
<?php }?>
						</label>
					</td>
					<td class="carrier_infos"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['carrier']->value['delay'], 'htmlall', 'UTF-8');?>
</td>
					<td class="carrier_price">
						<?php if ($_smarty_tpl->tpl_vars['carrier']->value['price']){?>
							<span class="price">
								<?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value==1){?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['carrier']->value['price_tax_exc']),$_smarty_tpl);?>
<?php }else{ ?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['carrier']->value['price']),$_smarty_tpl);?>
<?php }?>
							</span>
							<?php if ($_smarty_tpl->tpl_vars['use_taxes']->value){?><?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value==1){?> <?php echo smartyTranslate(array('s'=>'(tax excl.)'),$_smarty_tpl);?>
<?php }else{ ?> <?php echo smartyTranslate(array('s'=>'(tax incl.)'),$_smarty_tpl);?>
<?php }?><?php }?>
                        <?php }elseif($_smarty_tpl->tpl_vars['carrier']->value['carrier_text']!=''){?>
                            <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['carrier']->value['carrier_text'], 'htmlall', 'UTF-8');?>

						<?php }else{ ?>
							<?php echo smartyTranslate(array('s'=>'Free!'),$_smarty_tpl);?>

						<?php }?>
					</td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['carrier']->value['external_module_name']){?>
					<?php if ($_smarty_tpl->tpl_vars['carrier']->value['external_module_name']=='boxberry'){?>
					<tr><td colspan="4">
            <div class="bx_container<?php if ($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']!=$_smarty_tpl->tpl_vars['checked']->value){?> hide<?php }?>" data-price="<?php echo $_smarty_tpl->tpl_vars['price_for_boxberry']->value;?>
">	
		<!--<select id="pickups_list"></select>-->
<script type="text/javascript" src="http://points.boxberry.ru/js/boxberry.js" /></script>                
<script type="text/javascript">
var selectPoint = function( o ) {
    console.log('Boxberry');
    console.log(o);    
$.get('boxberry.php',{ 
    set_pvz : 1,
    pvz_params : {
        "company" : 'Boxberry',
        "address" : o["address"],
        "price" : parseInt(o["price"]),
        "code" : o["id"],
        } 
    }, function(data){
            if (data != 1) {
                location.reload();
            }
           afterSelectPoint (o.price,o.address);
        }); 
}

var afterSelectPoint = function(price,address) {
    var $bxPriceBlock = $('.boxberry_block').find('.carrier_price'),
        $btnNext = $('.cart_navigation > input.exclusive');
    $bxPriceBlock.html('<span class=\'price\'>' + parseInt(price) + ',00 руб</span>');
    $('#selected_pvz').addClass('active').text('Выбран ПВЗ: '+ address);
    $btnNext.removeClass('exclusive_disabled');
    $btnNext.removeAttr('disabled');
}
</script>              
                
                <a href="#" onclick="boxberry.open(function(pvz_data){
                    $.get('boxberry.php',{ set_sum : 1 } , function (a) {
                        if (a != 1) {
                            location.reload();
                        } 
                        else {
                            selectPoint(pvz_data);
                            return false;
                    }
                })},'<?php echo $_smarty_tpl->tpl_vars['boxberry_widget_config']->value['token'];?>
',
                  '<?php echo $_smarty_tpl->tpl_vars['boxberry_widget_config']->value['city'];?>
',
                  '<?php echo $_smarty_tpl->tpl_vars['boxberry_widget_config']->value['target_start'];?>
',
                  '<?php echo $_smarty_tpl->tpl_vars['boxberry_widget_config']->value['price'];?>
',
                  '<?php echo $_smarty_tpl->tpl_vars['boxberry_widget_config']->value['weight'];?>
',
                  '<?php echo $_smarty_tpl->tpl_vars['boxberry_widget_config']->value['paysum'];?>
',
                  '<?php echo $_smarty_tpl->tpl_vars['boxberry_widget_config']->value['height'];?>
',
                  '<?php echo $_smarty_tpl->tpl_vars['boxberry_widget_config']->value['width'];?>
',
                  '<?php echo $_smarty_tpl->tpl_vars['boxberry_widget_config']->value['depth'];?>
')">Выбрать ПВЗ</a>             
		<script src="js/order.js"></script>
              
            </div>
					</td>
					</tr>
					<?php }?>
				<?php }?>
			<?php } ?>
			<tr id="HOOK_EXTRACARRIER"><?php echo $_smarty_tpl->tpl_vars['HOOK_EXTRACARRIER']->value;?>
</tr>
		<?php }?>
		</tbody>
	</table>

	<div style="display: none;" id="extra_carrier"></div>
	
		<?php if ($_smarty_tpl->tpl_vars['giftAllowed']->value){?>
		<h3 class="gift_title"><?php echo smartyTranslate(array('s'=>'Gift'),$_smarty_tpl);?>
</h3>
		<p class="checkbox">
			<input type="checkbox" name="gift" id="gift" value="1" <?php if ($_smarty_tpl->tpl_vars['cart']->value->gift==1){?>checked="checked"<?php }?> onclick="$('#gift_div').toggle('slow');" />
			<label for="gift"><?php echo smartyTranslate(array('s'=>'I would like the order to be gift-wrapped.'),$_smarty_tpl);?>
</label>
			<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if ($_smarty_tpl->tpl_vars['gift_wrapping_price']->value>0){?>
				<span id="gift-wrap-cost">
					(<?php echo smartyTranslate(array('s'=>'Additional cost of'),$_smarty_tpl);?>

					<span class="price" id="gift-price">
						<?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value==1){?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['total_wrapping_tax_exc_cost']->value),$_smarty_tpl);?>
<?php }else{ ?><?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['total_wrapping_cost']->value),$_smarty_tpl);?>
<?php }?>
					</span>
					<?php if ($_smarty_tpl->tpl_vars['use_taxes']->value){?><?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value==1){?> <?php echo smartyTranslate(array('s'=>'(tax excl.)'),$_smarty_tpl);?>
<?php }else{ ?> <?php echo smartyTranslate(array('s'=>'(tax incl.)'),$_smarty_tpl);?>
<?php }?><?php }?>)
				</span>
			<?php }?>
		</p>
		<p id="gift_div" class="textarea">
			<label for="gift_message"><?php echo smartyTranslate(array('s'=>'If you wish, you can add a note to the gift:'),$_smarty_tpl);?>
</label>
			<textarea rows="5" cols="35" id="gift_message" name="gift_message"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['cart']->value->gift_message, 'htmlall', 'UTF-8');?>
</textarea>
		</p>
		<?php }?>
	<?php }?>
<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?>
	<p class="cart_navigation submit">
		<input type="hidden" name="step" value="2" />
		<input type="hidden" name="back" value="<?php echo $_smarty_tpl->tpl_vars['back']->value;?>
" />
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order.php',true);?>
<?php if (!$_smarty_tpl->tpl_vars['is_guest']->value){?>?step=1<?php if ($_smarty_tpl->tpl_vars['back']->value){?>&back=<?php echo $_smarty_tpl->tpl_vars['back']->value;?>
<?php }?><?php }?>" title="<?php echo smartyTranslate(array('s'=>'Previous'),$_smarty_tpl);?>
" class="button">&laquo; <?php echo smartyTranslate(array('s'=>'Previous'),$_smarty_tpl);?>
</a>
		<input type="submit" name="processCarrier" value="<?php echo smartyTranslate(array('s'=>'Next'),$_smarty_tpl);?>
 &raquo;" class="exclusive" />
	</p>
</form>
<?php }else{ ?>
	<h3><?php echo smartyTranslate(array('s'=>'Leave a message'),$_smarty_tpl);?>
</h3>
	<div>
		<p><?php echo smartyTranslate(array('s'=>'If you would like to add a comment about your order, please write it below.'),$_smarty_tpl);?>
</p>
		<p><textarea cols="120" rows="3" name="message" id="message"><?php if (isset($_smarty_tpl->tpl_vars['oldMessage']->value)){?><?php echo $_smarty_tpl->tpl_vars['oldMessage']->value;?>
<?php }?></textarea></p>
	</div>
</div>
<?php }?>
<?php }} ?>