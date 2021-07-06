<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:11:46
         compiled from "F:\OpenServer\domains\realrc.test\themes\p55_gloss_lite\modules\blockpermanentlinks\blockpermanentlinks-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28651605deba2346420-77753936%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e0b4993e9104b817270b91ef2a9e8468924ff705' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\themes\\p55_gloss_lite\\modules\\blockpermanentlinks\\blockpermanentlinks-header.tpl',
      1 => 1390293521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28651605deba2346420-77753936',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'come_from' => 0,
    'meta_title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605deba23c2af0_31624743',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605deba23c2af0_31624743')) {function content_605deba23c2af0_31624743($_smarty_tpl) {?>

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
	<li id="header_link_contact"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('contact-form.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'contact','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'contact','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
</a></li>
	<li id="header_link_sitemap"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('sitemap.php');?>
" title="<?php echo smartyTranslate(array('s'=>'sitemap','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'sitemap','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
</a></li>
	<li id="header_link_bookmark">
	 
		<script type="text/javascript">writeBookmarkLink('<?php echo $_smarty_tpl->tpl_vars['come_from']->value;?>
', '<?php echo addslashes(addslashes($_smarty_tpl->tpl_vars['meta_title']->value));?>
', '<?php echo smartyTranslate(array('s'=>'bookmark','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
');</script>
	</li>
</ul>
<!-- /Block permanent links module HEADER --><?php }} ?>