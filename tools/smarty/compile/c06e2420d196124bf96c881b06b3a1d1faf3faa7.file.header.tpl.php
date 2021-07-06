<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:11:47
         compiled from "F:\OpenServer\domains\realrc.test\themes\p55_gloss_lite\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23028605deba33d6d67-35022632%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c06e2420d196124bf96c881b06b3a1d1faf3faa7' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\themes\\p55_gloss_lite\\header.tpl',
      1 => 1475578814,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23028605deba33d6d67-35022632',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang_iso' => 0,
    'meta_title' => 0,
    'meta_description' => 0,
    'meta_keywords' => 0,
    'nobots' => 0,
    'img_ps_dir' => 0,
    'img_update_time' => 0,
    'content_dir' => 0,
    'static_token' => 0,
    'token' => 0,
    'priceDisplayPrecision' => 0,
    'currency' => 0,
    'priceDisplay' => 0,
    'roundMode' => 0,
    'css_files' => 0,
    'css_uri' => 0,
    'media' => 0,
    'js_files' => 0,
    'js_uri' => 0,
    'HOOK_HEADER' => 0,
    'page_name' => 0,
    'content_only' => 0,
    'restricted_country_mode' => 0,
    'geolocation_country' => 0,
    'base_dir' => 0,
    'shop_name' => 0,
    'logo_image_width' => 0,
    'logo_image_height' => 0,
    'HOOK_TOP' => 0,
    'is_ad' => 0,
    'ad_message' => 0,
    'HOOK_LEFT_COLUMN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605deba36446a7_42528077',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605deba36446a7_42528077')) {function content_605deba36446a7_42528077($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'F:\\OpenServer\\domains\\realrc.test\\tools\\smarty\\plugins\\modifier.escape.php';
?>﻿

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
">
	<head>
		<title><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_title']->value, 'htmlall', 'UTF-8');?>
</title>
<?php if (isset($_smarty_tpl->tpl_vars['meta_description']->value)&&$_smarty_tpl->tpl_vars['meta_description']->value){?>
		<meta name="description" content="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_description']->value, 'html', 'UTF-8');?>
" />
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['meta_keywords']->value)&&$_smarty_tpl->tpl_vars['meta_keywords']->value){?>
		<meta name="keywords" content="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_keywords']->value, 'html', 'UTF-8');?>
" />
<?php }?>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="<?php if (isset($_smarty_tpl->tpl_vars['nobots']->value)){?>no<?php }?>index,follow" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
favicon.ico?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
" />
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
favicon.ico?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
" />
		<script type="text/javascript">
			var baseDir = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
';
			var static_token = '<?php echo $_smarty_tpl->tpl_vars['static_token']->value;?>
';
			var token = '<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
';
			var priceDisplayPrecision = <?php echo $_smarty_tpl->tpl_vars['priceDisplayPrecision']->value*$_smarty_tpl->tpl_vars['currency']->value->decimals;?>
;
			var priceDisplayMethod = <?php echo $_smarty_tpl->tpl_vars['priceDisplay']->value;?>
;
			var roundMode = <?php echo $_smarty_tpl->tpl_vars['roundMode']->value;?>
;
		</script>
<?php if (isset($_smarty_tpl->tpl_vars['css_files']->value)){?>
	<?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['media']->_loop = false;
 $_smarty_tpl->tpl_vars['css_uri'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['css_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value){
$_smarty_tpl->tpl_vars['media']->_loop = true;
 $_smarty_tpl->tpl_vars['css_uri']->value = $_smarty_tpl->tpl_vars['media']->key;
?>
	<link href="<?php echo $_smarty_tpl->tpl_vars['css_uri']->value;?>
" rel="stylesheet" type="text/css" media="<?php echo $_smarty_tpl->tpl_vars['media']->value;?>
" />
	<?php } ?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['js_files']->value)){?>
	<?php  $_smarty_tpl->tpl_vars['js_uri'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js_uri']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['js_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js_uri']->key => $_smarty_tpl->tpl_vars['js_uri']->value){
$_smarty_tpl->tpl_vars['js_uri']->_loop = true;
?>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_uri']->value;?>
"></script>
	<?php } ?>
<?php }?>
		<?php echo $_smarty_tpl->tpl_vars['HOOK_HEADER']->value;?>

	</head>
	
	<body <?php if ($_smarty_tpl->tpl_vars['page_name']->value){?>id="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['page_name']->value, 'htmlall', 'UTF-8');?>
"<?php }?> <?php if ($_smarty_tpl->tpl_vars['content_only']->value){?>class="content_only"<?php }?>>
	<?php if (!$_smarty_tpl->tpl_vars['content_only']->value){?>
		<?php if (isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&$_smarty_tpl->tpl_vars['restricted_country_mode']->value){?>
		<div id="restricted-country">
			<p><?php echo smartyTranslate(array('s'=>'You cannot place a new order from your country.'),$_smarty_tpl);?>
 <span class="bold"><?php echo $_smarty_tpl->tpl_vars['geolocation_country']->value;?>
</span></p>
		</div>
		<?php }?>
		<div id="page">

			<!-- Header -->
			<div id="header" style="position: relative">
                        <div style="position: absolute; top: 63px; left: 222px; font-size: 24px; color: #3A91E8; font-weight: bold; line-height: 14px; text-align: left;">+7(926)499-41-93<br />
                        <span style="font-size: 14px;">Москва(ПН-ПТ с 10:00 до 18:00)</span>
                        </div>
                        <div style="position: absolute; top: 35px; left: 222px; font-size: 20px; color: #3A91E8;   line-height: 14px; text-align: left;">Rеальные цены, Rеально в наличии!</div>
 
				<a id="header_logo" href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['shop_name']->value, 'htmlall', 'UTF-8');?>
">
					<img class="logo" src="<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
logo.gif?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['shop_name']->value, 'htmlall', 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['logo_image_width']->value){?>width="<?php echo $_smarty_tpl->tpl_vars['logo_image_width']->value;?>
"<?php }?> <?php if ($_smarty_tpl->tpl_vars['logo_image_height']->value){?>height="<?php echo $_smarty_tpl->tpl_vars['logo_image_height']->value;?>
" <?php }?> />
				</a>
				<div id="header_right">
					<?php echo $_smarty_tpl->tpl_vars['HOOK_TOP']->value;?>

				</div>

<!--
<div style="clear:both;"></div>

<div style="padding-bottom: 0px; padding-top: 10px; margin-bottom: 10 px; margin: 1px 8px 1px 10px;">
<div style="clear: both; margin: 0px; margin-bottom: 5px;">

    <div style="padding: 3px; font-size: 12px; color: #ff0033;  text-align: center; font-weight: bold; font-family: Sans-Serif; border: 1px solid rgb(228, 228, 228);">
        УВАЖАЕМЫЕ ПОКУПАТЕЛИ! В связи с введением новой системы скидок для постоянных покупателей, начисление и использование бонус-баллов будет работать только до 1 сентября. Надеемся на ваше понимание!
    </div>
</div>
</div>
 -->

			</div>
    <?php if ($_smarty_tpl->tpl_vars['is_ad']->value==1){?>
     <div style="clear:both;"></div>

<div style="padding-bottom: 0px; padding-top: 10px; margin-bottom: 10 px; margin: 1px 8px 1px 10px;">
<div style="clear: both; margin: 0px; margin-bottom: 5px;">

    <div style="padding: 3px; font-size: 12px; color: #ff0033;  text-align: center; font-weight: bold; font-family: Sans-Serif; border: 1px solid rgb(228, 228, 228);">
        <?php echo $_smarty_tpl->tpl_vars['ad_message']->value;?>

    </div>
</div>
</div>
     
 <?php }?>
                                

			<div id="columns">
				<!-- Left -->
				<div id="left_column" class="column">
					<?php echo $_smarty_tpl->tpl_vars['HOOK_LEFT_COLUMN']->value;?>

				</div>

				<!-- Center -->
				<div id="center_column">
	<?php }?><?php }} ?>