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
*  @version  Release: $Revision: 6891 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{if $datesDelivery|count}
	<script type="text/javascript">
	{literal}
		var datesDelivery = new Array();
	{/literal}
	{foreach from=$datesDelivery item=date key=k}
	{if $date}
		datesDelivery[{$k}] = new Array();
		datesDelivery[{$k}]['minimal'] = "{$date.0}";
		datesDelivery[{$k}]['maximal'] = "{$date.1}";
	{/if}
	{/foreach}
	{literal}

	$(function(){
		if (datesDelivery[{/literal}{$id_carrier}{literal}] != undefined)
		{
			$('span#minimal').html('<b>'+datesDelivery[{/literal}{$id_carrier}{literal}]['minimal']+'</b>');
			$('span#maximal').html('<b>'+datesDelivery[{/literal}{$id_carrier}{literal}]['maximal']+'</b>');
		}
		else
			$('#dateofdelivery').hide();
		
		$('input[name=id_carrier]').click(function(){
			if (datesDelivery[$(this).val()] != undefined)
			{
				$('p#dateofdelivery').show();
				$('span#minimal').html('<b>'+datesDelivery[$(this).val()]['minimal']+'</b>');
				$('span#maximal').html('<b>'+datesDelivery[$(this).val()]['maximal']+'</b>');
			}
			else
				$('#dateofdelivery').hide();
		});
	});
	{/literal}
	</script>

	<div id="dateofdelivery">
		<p>{l s='Approximate date of delivery with this carrier is between' mod='dateofdelivery'} <span id="minimal"></span> {l s='and' mod='dateofdelivery'} <span id="maximal"></span> <sup>*</sup></p>
		<p style="font-size:10px;margin:0padding:0;"><span style="color: red;">*</span> {l s='with direct payment methods (e.g: credit card)' mod='dateofdelivery'}</p>
	</div>
{/if}