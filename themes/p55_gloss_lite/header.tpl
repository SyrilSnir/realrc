{*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6594 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_iso}">
	<head>
		<title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
{if isset($meta_description) AND $meta_description}
		<meta name="description" content="{$meta_description|escape:html:'UTF-8'}" />
{/if}
{if isset($meta_keywords) AND $meta_keywords}
		<meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}" />
{/if}
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,follow" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$img_ps_dir}favicon.ico?{$img_update_time}" />
		<link rel="shortcut icon" type="image/x-icon" href="{$img_ps_dir}favicon.ico?{$img_update_time}" />
		<script type="text/javascript">
			var baseDir = '{$content_dir}';
			var static_token = '{$static_token}';
			var token = '{$token}';
			var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
			var priceDisplayMethod = {$priceDisplay};
			var roundMode = {$roundMode};
		</script>
{if isset($css_files)}
	{foreach from=$css_files key=css_uri item=media}
	<link href="{$css_uri}" rel="stylesheet" type="text/css" media="{$media}" />
	{/foreach}
{/if}
{if isset($js_files)}
	{foreach from=$js_files item=js_uri}
	<script type="text/javascript" src="{$js_uri}"></script>
	{/foreach}
{/if}
		{$HOOK_HEADER}
	</head>
	
	<body {if $page_name}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if} {if $content_only}class="content_only"{/if}>
	{if !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
		<div id="restricted-country">
			<p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country}</span></p>
		</div>
		{/if}
		<div id="page">

			<!-- Header -->
			<div id="header" style="position: relative">
                        <div style="position: absolute; top: 63px; left: 222px; font-size: 24px; color: #3A91E8; font-weight: bold; line-height: 14px; text-align: left;">+7(926)499-41-93<br />
                        <span style="font-size: 14px;">Москва(ПН-ПТ с 10:00 до 18:00)</span>
                        </div>
                        <div style="position: absolute; top: 35px; left: 222px; font-size: 20px; color: #3A91E8;   line-height: 14px; text-align: left;">Rеальные цены, Rеально в наличии!</div>
 
				<a id="header_logo" href="{$base_dir}" title="{$shop_name|escape:'htmlall':'UTF-8'}">
					<img class="logo" src="{$img_ps_dir}logo.gif?{$img_update_time}" alt="{$shop_name|escape:'htmlall':'UTF-8'}" {if $logo_image_width}width="{$logo_image_width}"{/if} {if $logo_image_height}height="{$logo_image_height}" {/if} />
				</a>
				<div id="header_right">
					{$HOOK_TOP}
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
    {if $is_ad == 1}
     <div style="clear:both;"></div>

<div style="padding-bottom: 0px; padding-top: 10px; margin-bottom: 10 px; margin: 1px 8px 1px 10px;">
<div style="clear: both; margin: 0px; margin-bottom: 5px;">

    <div style="padding: 3px; font-size: 12px; color: #ff0033;  text-align: center; font-weight: bold; font-family: Sans-Serif; border: 1px solid rgb(228, 228, 228);">
        {$ad_message}
    </div>
</div>
</div>
     
 {/if}
                                

			<div id="columns">
				<!-- Left -->
				<div id="left_column" class="column">
					{$HOOK_LEFT_COLUMN}
				</div>

				<!-- Center -->
				<div id="center_column">
	{/if}