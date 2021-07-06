<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:30:16
         compiled from "F:\OpenServer\domains\realrc.test\modules\homecategoriesplus\homecategoriesplus.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21603605deff8f2b3f7-72846782%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4915e9fce29ecc1f117b3b489eaf325248e7c92c' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\modules\\homecategoriesplus\\homecategoriesplus.tpl',
      1 => 1369227474,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21603605deff8f2b3f7-72846782',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'jquery' => 0,
    'categories' => 0,
    'categorie' => 0,
    'link' => 0,
    'categoryLink' => 0,
    'displaycatimg' => 0,
    'img_cat_dir' => 0,
    'displayprod' => 0,
    'produc' => 0,
    'getproductLink' => 0,
    'displayprice' => 0,
    'priceDisplay' => 0,
    'displaybtn' => 0,
    'allow_buy_when_out_of_stock' => 0,
    'base_dir' => 0,
    'displaycat' => 0,
    'subcategorie' => 0,
    'scategoryLink' => 0,
    'displaysubcatimg' => 0,
    'displaysub7' => 0,
    'jquerylink' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605deff94f7fb0_99349932',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605deff94f7fb0_99349932')) {function content_605deff94f7fb0_99349932($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include 'F:\\OpenServer\\domains\\realrc.test\\tools\\smarty\\plugins\\function.math.php';
?><?php if ($_smarty_tpl->tpl_vars['jquery']->value==0){?>
		<?php if ($_smarty_tpl->tpl_vars['categories']->value){?>
				  <div id="CategoriePlus">
                  <h1><?php echo smartyTranslate(array('s'=>'Categories','mod'=>'homecategoriesplus'),$_smarty_tpl);?>
</h1>
				  <?php  $_smarty_tpl->tpl_vars['categorie'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categorie']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['categorie']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['categorie']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['categorie']->key => $_smarty_tpl->tpl_vars['categorie']->value){
$_smarty_tpl->tpl_vars['categorie']->_loop = true;
 $_smarty_tpl->tpl_vars['categorie']->iteration++;
 $_smarty_tpl->tpl_vars['categorie']->last = $_smarty_tpl->tpl_vars['categorie']->iteration === $_smarty_tpl->tpl_vars['categorie']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['cats']['last'] = $_smarty_tpl->tpl_vars['categorie']->last;
?>
				  <?php $_smarty_tpl->tpl_vars['categoryLink'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['categorie']->value['id'],$_smarty_tpl->tpl_vars['categorie']->value['link_rewrite']), null, 0);?>
				       <div class="CatPlus" <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['cats']['last']){?>id="last_item"<?php }?>>
				          <span class="title"><a href="<?php echo $_smarty_tpl->tpl_vars['categoryLink']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['categorie']->value['titre'];?>
</a></span>
		                  <?php if ($_smarty_tpl->tpl_vars['displaycatimg']->value==1){?><a class="theme-align-center" href="<?php echo $_smarty_tpl->tpl_vars['categoryLink']->value;?>
">
		                  <img class="theme-align-center" align="middle" src="<?php echo $_smarty_tpl->tpl_vars['img_cat_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['categorie']->value['id'];?>
-medium.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['categorie']->value['titre'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['categorie']->value['titre'];?>
" id="categoryImage" /></a><?php }?>
		                 <?php if ($_smarty_tpl->tpl_vars['categorie']->value['prod']&&$_smarty_tpl->tpl_vars['displayprod']->value==1){?> 
		                  <?php  $_smarty_tpl->tpl_vars['produc'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['produc']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categorie']->value['prod']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['produc']->key => $_smarty_tpl->tpl_vars['produc']->value){
$_smarty_tpl->tpl_vars['produc']->_loop = true;
?>
				              <?php $_smarty_tpl->tpl_vars['getproductLink'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getproductLink($_smarty_tpl->tpl_vars['produc']->value['id'],$_smarty_tpl->tpl_vars['produc']->value['link_rewrite']), null, 0);?>
				                  <span class="prod">
				                      <?php if ($_smarty_tpl->tpl_vars['produc']->value['on_sale']&&$_smarty_tpl->tpl_vars['produc']->value['show_price']){?>
				                          <span class="on_sale"><?php echo smartyTranslate(array('s'=>'On sale!'),$_smarty_tpl);?>
</span>
				                       <?php }elseif(isset($_smarty_tpl->tpl_vars['produc']->value['reduction_price'])&&$_smarty_tpl->tpl_vars['produc']->value['reduction_price']){?>
				                       
				                          <span class="discount"> <?php if ($_smarty_tpl->tpl_vars['produc']->value['reduction_type']=='percentage'){?><?php echo $_smarty_tpl->tpl_vars['produc']->value['reduction_price'];?>
% <?php }else{ ?> -<?php echo smarty_function_math(array('equation'=>'(x/y)*z','x'=>$_smarty_tpl->tpl_vars['produc']->value['reduction_price'],'y'=>$_smarty_tpl->tpl_vars['produc']->value['price'],'z'=>100,'format'=>"%.0f"),$_smarty_tpl);?>
% <?php }?></span><br /> 
				                      <?php }?>
				                          <a href="<?php echo $_smarty_tpl->tpl_vars['getproductLink']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['produc']->value['link_rewrite'],$_smarty_tpl->tpl_vars['produc']->value['id_image'],'medium');?>
" alt="<?php echo $_smarty_tpl->tpl_vars['produc']->value['titre'];?>
" width="80" height="80" /></a><br />
				                          
				                          <a href="<?php echo $_smarty_tpl->tpl_vars['getproductLink']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['produc']->value['titre'];?>
</a><br />
				                     
				                        <?php if ($_smarty_tpl->tpl_vars['displayprice']->value==1){?> <span class="price"><?php echo smartyTranslate(array('s'=>'Price','mod'=>'homecategoriesplus'),$_smarty_tpl);?>
:<?php echo Product::convertPrice(array('price'=>$_smarty_tpl->tpl_vars['produc']->value['price']),$_smarty_tpl);?>
 <?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value==2){?> <?php echo smartyTranslate(array('s'=>'+Tx','mod'=>'homecategoriesplus'),$_smarty_tpl);?>
 HT<?php echo smartyTranslate(array('s'=>'-Tx','mod'=>'homecategoriesplus'),$_smarty_tpl);?>
<?php }?></span><br /><?php }?>
				                     	<?php if ($_smarty_tpl->tpl_vars['displaybtn']->value==1){?>
		                                <?php if ($_smarty_tpl->tpl_vars['allow_buy_when_out_of_stock']->value||($_smarty_tpl->tpl_vars['produc']->value['quantity']&&$_smarty_tpl->tpl_vars['produc']->value['quantity']>0)){?>
		                                 <a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_<?php echo $_smarty_tpl->tpl_vars['produc']->value['id'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
cart.php?qty=1&amp;id_product=<?php echo $_smarty_tpl->tpl_vars['produc']->value['id'];?>
&amp;add" title="<?php echo smartyTranslate(array('s'=>'Add to cart','mod'=>'homecategoriesplus'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Add to cart','mod'=>'homecategoriesplus'),$_smarty_tpl);?>
</a><?php }?>
		                                <?php }?>
				                     </span>
				      
				           <?php } ?>
		                   <?php }?>
				                  <?php if (isset($_smarty_tpl->tpl_vars['categorie']->value['subs'])&&$_smarty_tpl->tpl_vars['displaycat']->value==1){?>
				                      <ul>
				                          <?php  $_smarty_tpl->tpl_vars['subcategorie'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subcategorie']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categorie']->value['subs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subcategorie']->key => $_smarty_tpl->tpl_vars['subcategorie']->value){
$_smarty_tpl->tpl_vars['subcategorie']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['subcategorie']->key;
?>
				                          <?php $_smarty_tpl->tpl_vars['scategoryLink'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['subcategorie']->value['id'],$_smarty_tpl->tpl_vars['subcategorie']->value['link_rewrite']), null, 0);?>
				                              <li><a class="theme-align-center" href="<?php echo $_smarty_tpl->tpl_vars['scategoryLink']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['subcategorie']->value['titre'];?>
</a>
		                                     <?php if ($_smarty_tpl->tpl_vars['displaysubcatimg']->value==1){?><a href="<?php echo $_smarty_tpl->tpl_vars['scategoryLink']->value;?>
"><img class="theme-align-center" align="middle" src="<?php echo $_smarty_tpl->tpl_vars['img_cat_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['subcategorie']->value['id'];?>
-medium.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['subcategorie']->value['titre'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['subcategorie']->value['titre'];?>
" id="categoryImage" /></a><?php }?>
		                                     </li>
				                          <?php }
if (!$_smarty_tpl->tpl_vars['subcategorie']->_loop) {
?>
				                              
				                          <?php } ?>
				                      </ul>
				                  <?php }?>
		                       <?php if ($_smarty_tpl->tpl_vars['displaysub7']->value==1){?> <a href="<?php echo $_smarty_tpl->tpl_vars['categoryLink']->value;?>
" class="tocat"><?php echo smartyTranslate(array('s'=>'See all categories','mod'=>'homecategoriesplus'),$_smarty_tpl);?>
 >></a><?php }?>
				       </div>
				  <?php }
if (!$_smarty_tpl->tpl_vars['categorie']->_loop) {
?>
				  	<?php echo smartyTranslate(array('s'=>'Price','mod'=>'Ooooopss, no category'),$_smarty_tpl);?>

				  <?php } ?>
				  </div>
				  <br style="clear:both" />
		<?php }?>		  
<?php }else{ ?>	
<br style="clear:both" />	
		<div class="main">
						<div id="mi-slider" class="mi-slider">
		                          <?php  $_smarty_tpl->tpl_vars['categorie'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categorie']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['categorie']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['categorie']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['categorie']->key => $_smarty_tpl->tpl_vars['categorie']->value){
$_smarty_tpl->tpl_vars['categorie']->_loop = true;
 $_smarty_tpl->tpl_vars['categorie']->iteration++;
 $_smarty_tpl->tpl_vars['categorie']->last = $_smarty_tpl->tpl_vars['categorie']->iteration === $_smarty_tpl->tpl_vars['categorie']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['cats']['last'] = $_smarty_tpl->tpl_vars['categorie']->last;
?>
				                      <?php if (isset($_smarty_tpl->tpl_vars['categorie']->value['subs'])&&$_smarty_tpl->tpl_vars['displaycat']->value==1){?><ul>
		                              
				                          <?php  $_smarty_tpl->tpl_vars['subcategorie'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subcategorie']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categorie']->value['subs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subcategorie']->key => $_smarty_tpl->tpl_vars['subcategorie']->value){
$_smarty_tpl->tpl_vars['subcategorie']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['subcategorie']->key;
?>
				                          <?php $_smarty_tpl->tpl_vars['scategoryLink'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['subcategorie']->value['id'],$_smarty_tpl->tpl_vars['subcategorie']->value['link_rewrite']), null, 0);?>
				                              <li><a class="theme-align-center" href="<?php echo $_smarty_tpl->tpl_vars['scategoryLink']->value;?>
"><img class="theme-align-center" align="middle" src="<?php echo $_smarty_tpl->tpl_vars['img_cat_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['subcategorie']->value['id'];?>
-medium.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['subcategorie']->value['titre'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['subcategorie']->value['titre'];?>
" id="categoryImage" /><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['subcategorie']->value['titre'],21);?>
</a></li>
			                              
				                          <?php } ?>
				                      </ul><?php }?>
		                          <?php } ?>    
				                  
							<nav>
								  <?php  $_smarty_tpl->tpl_vars['categorie'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categorie']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['categorie']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['categorie']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['categorie']->key => $_smarty_tpl->tpl_vars['categorie']->value){
$_smarty_tpl->tpl_vars['categorie']->_loop = true;
 $_smarty_tpl->tpl_vars['categorie']->iteration++;
 $_smarty_tpl->tpl_vars['categorie']->last = $_smarty_tpl->tpl_vars['categorie']->iteration === $_smarty_tpl->tpl_vars['categorie']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['cats']['last'] = $_smarty_tpl->tpl_vars['categorie']->last;
?>
								  <?php $_smarty_tpl->tpl_vars['categoryLink'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['categorie']->value['id'],$_smarty_tpl->tpl_vars['categorie']->value['link_rewrite']), null, 0);?>
								  <a class="theme-align-center" href="#"><?php echo $_smarty_tpl->tpl_vars['categorie']->value['titre'];?>

                                  <?php if ($_smarty_tpl->tpl_vars['displaycatimg']->value==1){?><br /><img class="theme-align-center" align="middle" src="<?php echo $_smarty_tpl->tpl_vars['img_cat_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['categorie']->value['id'];?>
-medium.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['categorie']->value['titre'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['categorie']->value['titre'];?>
" id="categoryImage" /></a><?php }?>
								  <?php } ?>      
							</nav>
						</div>
					</div>
				
				<?php if ($_smarty_tpl->tpl_vars['jquerylink']->value==1){?><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script><?php }?>
				<script src="modules/homecategoriesplus/js/modernizr.custom.63321.js"></script>
				<script src="modules/homecategoriesplus/js/jquery.catslider.js"></script>
				<script>
					$(function() {
		
						$( '#mi-slider' ).catslider();
		
					});
				</script>
			<link rel="stylesheet" type="text/css" href="modules/homecategoriesplus/css/style.css" />
<?php }?><?php }} ?>