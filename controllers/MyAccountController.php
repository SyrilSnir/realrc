<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class MyAccountControllerCore extends FrontController
{
	public $auth = true;
	public $php_self = 'my-account.php';
	public $authRedirection = 'my-account.php';
	public $ssl = true;
	
	public function setMedia()
	{
		parent::setMedia();
		Tools::addCSS(_THEME_CSS_DIR_.'my-account.css');
	}
	
	public function process()
	{
		parent::process();
		global $cookie;
        $sdiscount = Sdiscount::getSdiscountInfo((int)($cookie->id_customer));
        if(is_array($sdiscount)){                      
                      //$minusSumm = Sdiscount::getPercent($order->getTotalProductsWithTaxes(),$sdiscount['real']); 
                      $statusReal = Sdiscount::getSdicount($sdiscount['real']);
                      if($statusReal != 4){
                        $statusNext = Sdiscount::getSdicount($sdiscount['next']);
                      
                      }else{
                        $statusNext = 0;
                      }
                      
                      $userSdiscount = array('leftOrdered' =>$sdiscount['leftOrdered'],
                                             'reals' =>$statusReal,
                                             'next' =>$statusNext );                  
        }else{
            $userSdiscount = 0;
        }
        
		self::$smarty->assign(array(
            'sdiscount' =>$userSdiscount,
			'voucherAllowed' => (int)(Configuration::get('PS_VOUCHERS')),
			'returnAllowed' => (int)(Configuration::get('PS_ORDER_RETURN'))
		));
		self::$smarty->assign('HOOK_CUSTOMER_ACCOUNT', Module::hookExec('customerAccount'));
	}
	
	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display(_PS_THEME_DIR_.'my-account.tpl');
	}
}

