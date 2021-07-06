<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:11:51
         compiled from "F:\OpenServer\domains\realrc.test\themes\p55_gloss_lite\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2773605deba7c33df8-63239490%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd786065cd1408bdfd8c2d154bb4cc7bc444d094' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\themes\\p55_gloss_lite\\footer.tpl',
      1 => 1579615103,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2773605deba7c33df8-63239490',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'HOOK_FOOTER' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605deba7c5fe49_68733847',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605deba7c5fe49_68733847')) {function content_605deba7c5fe49_68733847($_smarty_tpl) {?>

		<?php if (!$_smarty_tpl->tpl_vars['content_only']->value){?>
				</div>

<!-- Right -->
  <div id="right_column" class="column">
		<?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>

  </div>
			</div>
<hr class="clear" />
<!-- Footer -->


<div id="footer">

        <?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>


        <a id="theme-copyright-link" href="http://www.realrc.ru">&copy 2013-2020 <span style="color: #3a91e8;">RealRc</span></a> 



<!-- Yandex.Metrika informer 
<a id="theme-ya-metrik" href="http://metrika.yandex.ru/stat/?id=21308263&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/21308263/3_0_5AB1FFFF_3A91E8FF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:21308263,lang:'ru'});return false}catch(e){}"/></a>
 /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter21308263 = new Ya.Metrika({id:21308263,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/21308263" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->



      </div>
		</div>

	<?php }?>
	</body>
</html>
<?php }} ?>