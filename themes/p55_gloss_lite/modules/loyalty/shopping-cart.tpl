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
*  @version  Release: $Revision: 7208 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- MODULE Loyalty -->
<div id="loyalty">
	<p>
	<img src="{$module_template_dir}loyalty.gif" alt="{l s='loyalty' mod='loyalty'}" class="icon" />
	{if $points > 0}
		{l s='By checking out of this shopping cart you can collect up to' mod='loyalty'} <b>{$points} 
		{if $points > 1}{l s='loyalty points' mod='loyalty'}{else}{l s='loyalty point' mod='loyalty'}{/if}</b> 
		{l s='that can be converted into a voucher of' mod='loyalty'} {convertPrice price=$voucher}&nbsp;{if isset($guest_checkout) && $guest_checkout}<span class="starred">*</span>{/if}.

		{if isset($guest_checkout) && $guest_checkout}<p><em><span class="starred">*</span> {l s='Not available for Instant checkout order' mod='loyalty'}</em></p>{/if}
	{else}
		<p>{l s='Add some products to your shopping cart to collect some loyalty points.' mod='loyalty'}</p>
	{/if}
</div>
<!-- END : MODULE Loyalty -->