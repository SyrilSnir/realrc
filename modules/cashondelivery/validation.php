<?php
/*
* 2007-2013 PrestaShop
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
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../header.php');
include(dirname(__FILE__).'/cashondelivery.php');

$cashOnDelivery = new CashOnDelivery();
$carrier = new CarrierCore($cart->id_carrier);
$external_module = $carrier->external_module_name;
if ($external_module == 'boxberry') {
Sessions::sessionInit();
//Sessions::setValueToVar('ORDER_TOTAL', $orderTotal);
$order_total = Sessions::getVarSession('CARD_TOTAL_SUM');
$current_order_total = $cart->getOrderTotal(true,Cart::ONLY_PRODUCTS_WITHOUT_SHIPPING);
    if ($order_total != $current_order_total) {
        Tools::redirectLink(__PS_BASE_URI__.'order.php?step=1');
    }
}if ($cart->id_customer == 0 OR $cart->id_address_delivery == 0 OR $cart->id_address_invoice == 0 OR !$cashOnDelivery->active)
	//Tools::redirectLink(__PS_BASE_URI__.'order.php?step=1');

// Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
$authorized = false;
foreach (Module::getPaymentModules() as $module)
	if ($module['name'] == 'cashondelivery')
	{
		$authorized = true;
		break;
	}
if (!$authorized)
    Tools::redirectLink(__PS_BASE_URI__);
	//die(Tools::displayError('This payment method is not available.'));
	
$customer = new Customer((int)$cart->id_customer);

if (!Validate::isLoadedObject($customer))
	Tools::redirectLink(__PS_BASE_URI__.'order.php?step=1');

/* Validate order */
if (Tools::getValue('confirm'))
{
        $messageContent = Tools::getValue('message');
	$customer = new Customer((int)$cart->id_customer);
        if ($messageContent) {
            $message = new Message();
            $message->message = htmlentities($messageContent, ENT_COMPAT, 'UTF-8');
            $message->id_cart = (int)($cart->id);
            $message->id_customer = (int)($cart->id_customer);
            $message->add();
        }
        echo $messageContent;
        
	$total = $cart->getOrderTotal(true, Cart::BOTH);
        $cashOnDelivery->validateOrder((int)$cart->id, Configuration::get('PS_OS_PREPARATION'), $total, $cashOnDelivery->displayName, NULL, array(), NULL, false, $customer->secure_key);
	$order = new OrderCore((int)$cashOnDelivery->currentOrder);
       // $messageContent = Tools::getValue('message');
	Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?key='.$customer->secure_key.'&id_cart='.(int)($cart->id).'&id_module='.(int)$cashOnDelivery->id.'&id_order='.(int)$cashOnDelivery->currentOrder);
}
else
{
    $total = $cart->getOrderTotal(true, Cart::BOTH); 
    $total_prod = (float)($cart->getOrderTotal(true, Cart::ONLY_PRODUCTS));
    $sdiscount = Sdiscount::getSdiscountInfo((int)($cart->id_customer));
        if(is_array($sdiscount)){
            
          $minusSumm = Sdiscount::getPercent($total_prod,$sdiscount['real']); 
          $total  = $total - $minusSumm;
    }
	/* or ask for confirmation */ 
	$smarty->assign(array(
		'total' => $total,
		'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/cashondelivery/'            
	));

	$smarty->assign('this_path', __PS_BASE_URI__.'modules/cashondelivery/');
        if ($external_module == 'boxberry') {
            $selectedPvz = SessionsCore::getVarSession('SELECTED_PVZ');
            $smarty->assign([
               'is_boxberry' => true,
               'pvz_address' => $selectedPvz['address']
            ]);                    
        } else {
            $smarty->assign([
               'is_boxberry' => false
            ]);             
        }
        
	$template = 'validation.tpl';
	echo Module::display('cashondelivery', $template);
}

include(dirname(__FILE__).'/../../footer.php');