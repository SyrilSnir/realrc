<?php /* Smarty version Smarty-3.1.11, created on 2021-03-26 17:11:45
         compiled from "F:\OpenServer\domains\realrc.test\modules\homecategoriesplus\catpluscss.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15973605deba1d96be3-70611653%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6c0e612d27edf4eb6a228396b21ac5b7c344144' => 
    array (
      0 => 'F:\\OpenServer\\domains\\realrc.test\\modules\\homecategoriesplus\\catpluscss.tpl',
      1 => 1370436750,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15973605deba1d96be3-70611653',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'modulewidth' => 0,
    'divsize' => 0,
    'divsizeh' => 0,
    'displaycatbor' => 0,
    'displaycatborc' => 0,
    'divcolor' => 0,
    'displaysub19' => 0,
    'prod_marg' => 0,
    'displayprodbor' => 0,
    'displayprodborc' => 0,
    'displaysub11' => 0,
    'displaysub12' => 0,
    'displaysub9' => 0,
    'displaysub1' => 0,
    'displaysub4' => 0,
    'displaysub5' => 0,
    'displaysub2' => 0,
    'displaysub6' => 0,
    'displaysub8' => 0,
    'displaysub15' => 0,
    'displaysub18' => 0,
    'displaysub17' => 0,
    'displaysub20' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_605deba1ea5281_56525558',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_605deba1ea5281_56525558')) {function content_605deba1ea5281_56525558($_smarty_tpl) {?><style type="text/css">
@charset "utf-8";
/* CSS Document */

#CategoriePlus{margin:5px auto;width:<?php echo $_smarty_tpl->tpl_vars['modulewidth']->value;?>
px; text-align:center}
#CategoriePlus .CatPlus{
	padding:0px;
	float:left;
	margin:0;
	margin-left:1px;margin-bottom:1px;
	width:<?php echo $_smarty_tpl->tpl_vars['divsize']->value;?>
px;
	height:<?php echo $_smarty_tpl->tpl_vars['divsizeh']->value;?>
px;
	border:solid <?php echo $_smarty_tpl->tpl_vars['displaycatbor']->value;?>
px #<?php echo $_smarty_tpl->tpl_vars['displaycatborc']->value;?>
}
#CategoriePlus .CatPlus#last_item{margin-right:0}
#CategoriePlus .CatPlus .title{background:#<?php echo $_smarty_tpl->tpl_vars['divcolor']->value;?>
;
display:block;
height:30px;
padding:3px 5px;
font-size:1.1em}
#CategoriePlus h1{background:#<?php echo $_smarty_tpl->tpl_vars['divcolor']->value;?>
}
#CategoriePlus .CatPlus .title a{color:#<?php echo $_smarty_tpl->tpl_vars['displaysub19']->value;?>
;text-decoration:none}

#CategoriePlus .CatPlus .title a:hover{text-decoration:underline}
#CategoriePlus .CatPlus .prod{
  	margin-right:<?php echo $_smarty_tpl->tpl_vars['prod_marg']->value;?>
px;
	border:solid <?php echo $_smarty_tpl->tpl_vars['displayprodbor']->value;?>
px #<?php echo $_smarty_tpl->tpl_vars['displayprodborc']->value;?>
;
	width:<?php echo $_smarty_tpl->tpl_vars['displaysub11']->value;?>
px;
	height:<?php echo $_smarty_tpl->tpl_vars['displaysub12']->value;?>
px;
	display:block;
	padding:2px;
	float:right;
	text-align:center}
#CategoriePlus .CatPlus .prod a{color:#000;width:108px}
#CategoriePlus .CatPlus .prod .discount{
	display: block;
	position: absolute;
	font-size:1em;
	color: #FFF;
	text-align:center;
	height: 23px;width:30px;
	padding:7px 0 0 0;
	margin-left:1px;
  margin-top: 2px;
	background: #da0f00;
	border:solid 1px #fff}
#CategoriePlus .CatPlus span price{color:#990000}
#CategoriePlus .CatPlus ul{list-style:none;margin: 3px}
#CategoriePlus .CatPlus li a{width:<?php echo $_smarty_tpl->tpl_vars['displaysub9']->value;?>
px;/*Sub categories width*/
	display:block;
	text-decoration:none;
	color:#<?php echo $_smarty_tpl->tpl_vars['displaysub1']->value;?>
;
	margin-bottom:1px;
	font-size:<?php echo $_smarty_tpl->tpl_vars['displaysub4']->value;?>
px;/*Sub categories text size*/
	text-decoration:<?php echo $_smarty_tpl->tpl_vars['displaysub5']->value;?>
;
	border-bottom: none/*Sub categories grey underline  to hide them set it to none */}
#CategoriePlus .CatPlus li a:hover{background-color:#<?php echo $_smarty_tpl->tpl_vars['displaysub2']->value;?>
;color:#<?php echo $_smarty_tpl->tpl_vars['displaysub6']->value;?>
;}
#CategoriePlus .CatPlus a.tocat{color:#<?php echo $_smarty_tpl->tpl_vars['displaysub8']->value;?>
;}
#CategoriePlus .remise{color:#FF0000}
#CategoriePlus .old_price{color:#333;text-decoration: line-through}


.mi-slider {height:<?php echo $_smarty_tpl->tpl_vars['displaysub15']->value;?>
px;}
.mi-slider nav {border-top:solid <?php echo $_smarty_tpl->tpl_vars['displaysub18']->value;?>
px #<?php echo $_smarty_tpl->tpl_vars['displaysub17']->value;?>
;top: 120px;}

.mi-slider nav a.mi-selected:before {
	border-top-color: #<?php echo $_smarty_tpl->tpl_vars['displaysub17']->value;?>
}
	
.mi-slider nav a{color:#<?php echo $_smarty_tpl->tpl_vars['displaysub19']->value;?>
}
.mi-slider nav a.mi-selected {color:#<?php echo $_smarty_tpl->tpl_vars['displaysub20']->value;?>
}

</style>




<?php }} ?>