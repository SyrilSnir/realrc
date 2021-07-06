<?php
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');

/* Header can't be included, so cookie must be created here */
$cookie = new Cookie('psAdmin');
if (!$cookie->id_employee)
	Tools::redirectAdmin('login.php');
if (!isset($_GET['id_order']))
    die (Tools::displayError('Missing order ID'));
    $order = new Order((int)($_GET['id_order']));
if (!Validate::isLoadedObject($order))
    die(Tools::displayError('Cannot find order in database'));
//echo getcwd();
require_once (PS_ADMIN_DIR.'/classes/PHPExcel.php');
require_once (PS_ADMIN_DIR.'/classes/PHPExcel/Writer/Excel5.php');
require_once (PS_ADMIN_DIR.'/PHPExcelFromTpl.php');
$products = $order->getProducts();
$id_order = $order->id;
$nameg = array();
 while($idx =key ($products))
 {
    // echo $idx;
     array_push($nameg, array (
        'name' => $products[$idx]['product_name'],
        'col' => $products[$idx]['product_quantity'],
         'price' => $products[$idx]['product_price']
    ));
     next($products);
 }    
 $order = 'Счет № от '.date('d.m.Y');
// $customerObject = new Customer($order->id_customer);
  /*  array_push($nameg, array (
        'name' => $rValue['product_name'],
        'col' => $rValue['']
    ));*/
//echo getcwd();

PHPExcelFromTpl::convert(PS_ADMIN_DIR.'/template/tmplschet.xlsx',array (
                                                'schet' => $order,
                                                'order' => $id_order,
                                                'nameg' => $nameg,
                                                'data' => date('d.m.Y')
                                                ));



?>