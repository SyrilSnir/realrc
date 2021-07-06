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


ini_set("display_errors",1);
 error_reporting(E_ALL);

class SdiscountCore extends ObjectModel
{
	
    
	protected static $_historyCache = array();
   	
       
    public function getHistorys($id_lang,$id_order = false,$id_order_state = false, $no_hidden = false, $filters = 0,$id_order = false)
	{
		if (!$id_order_state)
			$id_order_state = 0;
		
            
        
        
		$logable = false;
		$delivery = false;
		if ($filters > 0)
		{
			if ($filters & OrderState::FLAG_NO_HIDDEN)
				$no_hidden = true;
			if ($filters & OrderState::FLAG_DELIVERY)
				$delivery = true;
			if ($filters & OrderState::FLAG_LOGABLE)
				$logable = true;
		}

		if (!isset(self::$_historyCache[$id_order.'_'.$id_order_state.'_'.$filters]) || $no_hidden)
		{
			$id_lang = $id_lang ? (int)$id_lang : 'o.`id_lang`';
			$result = Db::getInstance()->ExecuteS('
			SELECT oh.*, e.`firstname` employee_firstname, e.`lastname` employee_lastname, osl.`name` ostate_name
			FROM `'._DB_PREFIX_.'orders` o
			LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (o.`id_order` = oh.`id_order`)
			LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
			LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$id_lang.')
			LEFT JOIN `'._DB_PREFIX_.'employee` e ON e.`id_employee` = oh.`id_employee`
			WHERE oh.id_order = '.(int)$id_order.'
			'.($no_hidden ? ' AND os.hidden = 0' : '').'
			'.($logable ? ' AND os.logable = 1' : '').'
			'.($delivery ? ' AND os.delivery = 1' : '').'
			'.((int)$id_order_state ? ' AND oh.`id_order_state` = '.(int)$id_order_state : '').'
			ORDER BY oh.date_add DESC, oh.id_order_history DESC');
			if ($no_hidden)
				return $result;
			self::$_historyCache[$id_order.'_'.$id_order_state.'_'.$filters] = $result;
		}
		return self::$_historyCache[$id_order.'_'.$id_order_state.'_'.$filters];
	}


   public function getSdiscountInfo($id_customer){
       
        global $cookie;          
        $counPrice = $this->getSum($id_customer);     
        $sdicountStats = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'sdiscount`
		ORDER BY `id_sdiscount` DESC');
        
        foreach($sdicountStats as $stats) {
	         if($stats['sum_sdiscount']<=$counPrice){
	           
               $customerSdiscount = $stats;
               
	         }
    
        }      
       
      return $customerSdiscount;
    
   }
   
   public static function getSum($id_customer)
   {
        global $cookie;
        $counPrice = 0;
        $orderReceived = Db::getInstance()->ExecuteS('
		SELECT `id_order`,`id_order`,`id_customer`,`total_paid`
		FROM `'._DB_PREFIX_.'orders`
		WHERE `id_customer` = '.(int)$id_customer.'
		ORDER BY `date_add` DESC');
        foreach ($orderReceived as $items) {
	         $statLast  = self::getHistorys($cookie->id_lang,$items['id_order']);
             $newStatsE  =  array_shift($statLast);
                    if($newStatsE['id_order_state']==5){
                        
                        $counPrice += $items['total_paid'];
                    }
             
         }
    
     return $counPrice;
    
   }
   






}