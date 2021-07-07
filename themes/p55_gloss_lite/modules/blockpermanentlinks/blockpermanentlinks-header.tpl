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

<script type="text/javascript">
/* Copied from the default Prestashop /js/tools.js and modified by P55 to display 'bookmark' link in Safari/Chrome. */
// update standard bookmarking feature to include options for chrome/safari
function writeBookmarkLink(url, title, text, img)
{
	var insert = '';
	if (img)
		insert = writeBookmarkLinkObject(url, title, '<img src="' + img + '" alt="' + escape(text) + '" title="' + escape(text) + '" />') + '&nbsp';
	insert += writeBookmarkLinkObject(url, title, text);
	document.write(insert);
}

function writeBookmarkLinkObject(url, title, insert)
{
	if (window.navigator.userAgent.indexOf('Chrome') != -1)
		return ('<a href="#" onclick="alert(\'Press CTRL + D on your keyboard to bookmark this page\')">'+ insert +'</a>');
  else if (window.navigator.userAgent.indexOf('Safari') != -1)
    return ('<a href="#" onclick="alert(\'Press CTRL + D on your keyboard to bookmark this page (if you are on a mobile device, you will need to add this bookmark manually).\')">'+ insert +'</a>');
	else if (window.sidebar || window.external)
		return ('<a href="javascript:addBookmark(\'' + escape(url) + '\', \'' + escape(title) + '\')">' + insert + '</a>');
	else if (window.opera && window.print)
		return ('<a rel="sidebar" href="' + escape(url) + '" title="' + escape(title) + '">' + insert + '</a>');
	return ('');
}
</script>

<!-- Block permanent links module HEADER -->
<ul id="header_links">
	<li id="header_link_contact"><a href="{$link->getPageLink('contact-form.php', true)}" title="{l s='contact' mod='blockpermanentlinks'}">{l s='contact' mod='blockpermanentlinks'}</a></li>
	<li id="header_link_sitemap"><a href="{$link->getPageLink('sitemap.php')}" title="{l s='sitemap' mod='blockpermanentlinks'}">{l s='sitemap' mod='blockpermanentlinks'}</a></li>
	<li id="header_link_bookmark">
	 
		<script type="text/javascript">writeBookmarkLink('{$come_from}', '{$meta_title|addslashes|addslashes}', '{l s='bookmark' mod='blockpermanentlinks'}');</script>
	</li>
</ul>
<!-- /Block permanent links module HEADER -->