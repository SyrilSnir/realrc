<?php
//ini_set("display_errors",1);
// error_reporting(E_ALL);

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


class AdminOrders extends AdminTab
{
	public function __construct()
	{
		global $cookie;

	 	$this->table = 'order';
	 	$this->className = 'Order';
	 	$this->view = true;
		$this->colorOnBackground = true;
                $this->delete = true;

	 	$this->_select = '
			a.`id_order` AS `id_pdf`, a.`total_products_markup` as `total_products_markup`, a.`order_collected` as `order_collected`, a.`id_carrier`, car.`name` as `delivery`,
                            CASE WHEN c.`lastname`=\'-\' THEN 
                        c.`firstname` ELSE 
			CONCAT(LEFT(c.`firstname`, 1), \'. \', c.`lastname`) END AS `customer`,
			osl.`name` AS `osname`,
			os.`color`,
			IF((SELECT COUNT(so.id_order) FROM `'._DB_PREFIX_.'orders` so WHERE so.id_customer = a.id_customer) > 1, 0, 1) as new,
			(SELECT COUNT(od.`id_order`) FROM `'._DB_PREFIX_.'order_detail` od WHERE od.`id_order` = a.`id_order` GROUP BY `id_order`) AS product_number';
	 	$this->_join = 'LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = a.`id_customer`)
	 	LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (oh.`id_order` = a.`id_order` AND (oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `'._DB_PREFIX_.'order_history` moh WHERE moh.`id_order` = a.`id_order` GROUP BY moh.`id_order`)))
		LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
        LEFT JOIN `'._DB_PREFIX_.'carrier` car ON (car.`id_carrier` = a.`id_carrier`)
		LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)($cookie->id_lang).')';

		$statesArray = array();
		$states = OrderState::getOrderStates((int)($cookie->id_lang));       
		foreach ($states as $state){
			$statesArray[$state['id_order_state']] = $state['name'];
         }
         
         $carriersArray = array();
         $carriers = Carrier::getCarriers(6); 
  	     foreach ($carriers as $carrier){
			$carriersArray[$carrier['id_carrier']] = $carrier['name'];
         }
           
 		$this->fieldsDisplay = array(
		'id_order' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 10),
		'new' => array('title' => $this->l('New'), 'width' => 10, 'align' => 'center', 'type' => 'bool', 'filter_key' => 'new', 'tmpTableFilter' => true, 'icon' => array(0 => 'blank.gif', 1 => 'news-new.gif'), 'orderby' => false),
		'customer' => array('title' => $this->l('Customer'), 'widthColumn' => 70, 'width' => 70, 'filter_key' => 'customer', 'tmpTableFilter' => true),
		'total_paid' => array('title' => $this->l('Total'), 'width' => 70, 'align' => 'right', 'prefix' => '<b>', 'suffix' => '</b>', 'price' => true, 'currency' => true),
        'total_products_markup' => array('title' => $this->l('Markup'), 'width' => 70, 'align' => 'right', 'price' => true, 'currency' => true),    
		'payment' => array('title' => $this->l('Payment'), 'width' => 70),
        'delivery' => array('title' => $this->l('Delivery'),  'widthColumn' => 90, 'type' => 'select', 'select' => $carriersArray, 'filter_key' => 'a!id_carrier', 'filter_type' => 'int', 'width' => 85),
		'osname' => array('title' => $this->l('Status'), 'widthColumn' => 90, 'type' => 'select', 'select' => $statesArray, 'filter_key' => 'os!id_order_state', 'filter_type' => 'int', 'width' => 85),
		'order_collected' => array('title' => $this->l('Order collected'), 'width' => 25, 'align' => 'center', 'type' => 'bool', 'filter_key' => 'order_collected', 'orderby' => true, 'noLink' => '1', 'collect' => true),
        'date_add' => array('title' => $this->l('Date'), 'width' => 60, 'align' => 'right', 'type' => 'datetime', 'filter_key' => 'a!date_add'),
		'id_pdf' => array('title' => $this->l('PDF'), 'callback' => 'printPDFIcons', 'orderby' => false, 'search' => false)
		);
        
		parent::__construct();
        $this->_conf = array(
		1 => $this->l('Deletion successful'), 2 => $this->l('Selection successfully deleted'),
		3 => $this->l('Creation successful'), 4 => $this->l('Update successful'),
		5 => $this->l('Status update successful'), 6 => $this->l('Settings update successful'),
		7 => $this->l('Image successfully deleted'), 8 => $this->l('Module downloaded successfully'),
		9 => $this->l('Thumbnails successfully regenerated'), 10 => $this->l('Message sent to the customer'),
		11 => $this->l('Comment added'), 12 => $this->l('Module installed successfully'),
		13 => $this->l('Module uninstalled successfully'), 14 => $this->l('Language successfully copied'),
		15 => $this->l('Translations successfully added'), 16 => $this->l('Module transplanted successfully to hook'),
		17 => $this->l('Module removed successfully from hook'), 18 => $this->l('Upload successful'),
		19 => $this->l('Duplication completed successfully'), 20 => $this->l('Translation added successfully but the language has not been created'),
		21 => $this->l('Module reset successfully'), 22 => $this->l('Module deleted successfully'),
		23 => $this->l('Localization pack imported successfully'), 24 => $this->l('Refund Successful'),
		25 => $this->l('Images successfully moved'),
        26 => $this->l('Объединение прошло успешно.'),
        27 => $this->l('Товар успешно добавлен'),
        28 => $this->l('Товар успешно удален.'),
        29 => $this->l('Способ доставки изменен.'),
        30 => $this->l('Количество товара изменено.')
        );
	}

	/**
	  * @global object $cookie Employee cookie necessary to keep trace of his/her actions
	  */
	public function postProcess()
	{
		global $currentIndex, $cookie;

		/* Update shipping number */
		if (Tools::isSubmit('submitShippingNumber') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
		{
			if ($this->tabAccess['edit'] === '1')
			{
				if (!$order->hasBeenShipped())
					die(Tools::displayError('The shipping number can only be set once the order has been shipped.'));
				$_GET['view'.$this->table] = true;

				$shipping_number = pSQL(Tools::getValue('shipping_number'));
				$order->shipping_number = $shipping_number;
				$order->update();
				if ($shipping_number)
				{
					global $_LANGMAIL;
					$customer = new Customer((int)($order->id_customer));
					$carrier = new Carrier((int)($order->id_carrier));
					if (!Validate::isLoadedObject($customer) OR !Validate::isLoadedObject($carrier))
						die(Tools::displayError());
					$templateVars = array(
						'{followup}' => str_replace('@', $order->shipping_number, $carrier->url),
						'{firstname}' => $customer->firstname,
                        '{middlename}' => $customer->middlename,
						'{lastname}' => $customer->lastname,
						'{id_order}' => (int)($order->id)
					);
					@Mail::Send((int)$order->id_lang, 'in_transit', Mail::l('Package in transit', (int)$order->id_lang), $templateVars,
						$customer->email, $customer->firstname.' '.$customer->middlename .' '.$customer->lastname, null, null, null, null,
						_PS_MAIL_DIR_, true);
				}
			}
			else
				$this->_errors[] = Tools::displayError('You do not have permission to edit here.');
		}

		/* Change order state, add a new entry in order history and send an e-mail to the customer if needed */
		elseif (Tools::isSubmit('submitState') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
		{
			if ($this->tabAccess['edit'] === '1')
			{
				$_GET['view'.$this->table] = true;
				if (!$newOrderStatusId = (int)(Tools::getValue('id_order_state')))
					$this->_errors[] = Tools::displayError('Invalid new order status');
				else
				{
                    /*
					$history = new OrderHistory();
					$history->id_order = (int)$id_order;
					$history->id_employee = (int)($cookie->id_employee);
					$history->changeIdOrderState((int)($newOrderStatusId), (int)($id_order));
					$order = new Order((int)$order->id);
					$carrier = new Carrier((int)($order->id_carrier), (int)($order->id_lang));
					$templateVars = array();
					if ($history->id_order_state == Configuration::get('PS_OS_SHIPPING') AND $order->shipping_number)
						$templateVars = array('{followup}' => str_replace('@', $order->shipping_number, $carrier->url));
					elseif ($history->id_order_state == Configuration::get('PS_OS_CHEQUE'))
						$templateVars = array(
							'{cheque_name}' => (Configuration::get('CHEQUE_NAME') ? Configuration::get('CHEQUE_NAME') : ''),
							'{cheque_address_html}' => (Configuration::get('CHEQUE_ADDRESS') ? nl2br(Configuration::get('CHEQUE_ADDRESS')) : ''));
					elseif ($history->id_order_state == Configuration::get('PS_OS_BANKWIRE'))
						$templateVars = array(
							'{bankwire_owner}' => (Configuration::get('BANK_WIRE_OWNER') ? Configuration::get('BANK_WIRE_OWNER') : ''),
							'{bankwire_details}' => (Configuration::get('BANK_WIRE_DETAILS') ? nl2br(Configuration::get('BANK_WIRE_DETAILS')) : ''),
							'{bankwire_address}' => (Configuration::get('BANK_WIRE_ADDRESS') ? nl2br(Configuration::get('BANK_WIRE_ADDRESS')) : ''));
					if ($history->addWithemail(true, $templateVars)) 
                        Tools::redirectAdmin($currentIndex.'&id_order='.$id_order.'&vieworder'.'&token='.$this->token);
                        $this->_errors[] = Tools::displayError('An error occurred while changing the status or was unable to send e-mail to the customer.');
                    */
                    if ($this->changeOrderState($id_order, $newOrderStatusId)) {
                        Tools::redirectAdmin($currentIndex.'&id_order='.$id_order.'&vieworder'.'&token='.$this->token);
                    }
				}
			}
			else
				$this->_errors[] = Tools::displayError('You do not have permission to edit here.');
		}if (Tools::isSubmit('submitState') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
		{
			if ($this->tabAccess['edit'] === '1')
			{
				$_GET['view'.$this->table] = true;
				if (!$newOrderStatusId = (int)(Tools::getValue('id_order_state')))
					$this->_errors[] = Tools::displayError('Invalid new order status');
				else
				{
                    /*
					$history = new OrderHistory();
					$history->id_order = (int)$id_order;
					$history->id_employee = (int)($cookie->id_employee);
					$history->changeIdOrderState((int)($newOrderStatusId), (int)($id_order));
					$order = new Order((int)$order->id);
					$carrier = new Carrier((int)($order->id_carrier), (int)($order->id_lang));
					$templateVars = array();
					if ($history->id_order_state == Configuration::get('PS_OS_SHIPPING') AND $order->shipping_number)
						$templateVars = array('{followup}' => str_replace('@', $order->shipping_number, $carrier->url));
					elseif ($history->id_order_state == Configuration::get('PS_OS_CHEQUE'))
						$templateVars = array(
							'{cheque_name}' => (Configuration::get('CHEQUE_NAME') ? Configuration::get('CHEQUE_NAME') : ''),
							'{cheque_address_html}' => (Configuration::get('CHEQUE_ADDRESS') ? nl2br(Configuration::get('CHEQUE_ADDRESS')) : ''));
					elseif ($history->id_order_state == Configuration::get('PS_OS_BANKWIRE'))
						$templateVars = array(
							'{bankwire_owner}' => (Configuration::get('BANK_WIRE_OWNER') ? Configuration::get('BANK_WIRE_OWNER') : ''),
							'{bankwire_details}' => (Configuration::get('BANK_WIRE_DETAILS') ? nl2br(Configuration::get('BANK_WIRE_DETAILS')) : ''),
							'{bankwire_address}' => (Configuration::get('BANK_WIRE_ADDRESS') ? nl2br(Configuration::get('BANK_WIRE_ADDRESS')) : ''));
					if ($history->addWithemail(true, $templateVars)) 
                        Tools::redirectAdmin($currentIndex.'&id_order='.$id_order.'&vieworder'.'&token='.$this->token);
                        $this->_errors[] = Tools::displayError('An error occurred while changing the status or was unable to send e-mail to the customer.');
                    */
                    if ($this->changeOrderState($id_order, $newOrderStatusId)) {
                        Tools::redirectAdmin($currentIndex.'&id_order='.$id_order.'&vieworder'.'&token='.$this->token);
                    }
				}
			}
			else
				$this->_errors[] = Tools::displayError('You do not have permission to edit here.');
		}if (isset($_GET['deleteproduct']) AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
		{
                    $sdiscount = Sdiscount::getSdiscountInfo((int)($order->id_customer));
                    if(is_array($sdiscount) and $order->sdiscount >0)
                    {
                       $statusUserDisc = Sdiscount::getSdicount($order->sdiscount);
                       $prcDisc = intval($statusUserDisc['percent_sdiscount']);
                        
                    }


          $detalProduct  = Tools::getValue('detal_product');
          $producId = Tools::getValue('product_id');
          $DelProduct =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_order_detail`
                                                               WHERE   id_order_detail = "' . $detalProduct . '"');  
          
         
          
          //print_r($order);
         // exit();
          /*
          
           if($Ship[0]['total_paid'] >=10000){
            
            Db::getInstance()->Execute('UPDATE `ps_orders` SET      `total_paid` = total_paid - "' . $Ship[0]['total_shipping'] . '",
                                                                     `total_paid_real` = total_paid_real - "' . $Ship[0]['total_shipping'] . '",
                                                                      `total_shipping` = 0  
                                                               
                                                               WHERE `id_order` = ' . $order->id);
            
           }
          
          */                                          
          
            Db::getInstance()->Execute('
        		DELETE FROM `ps_order_detail`
        		       WHERE   id_order_detail = "' . $detalProduct . '"');  
             
            
            $minusPrice = $DelProduct[0]['product_price'] * $DelProduct[0]['product_quantity'];
                        if (!empty($prcDisc))
            {
                $minusPrice2 = $minusPrice - ($minusPrice/100*$prcDisc);
            }
            else {
                $minusPrice2 = $minusPrice;
             }
            
           Db::getInstance()->Execute('UPDATE `ps_orders` SET      `total_paid` = total_paid - "' .$minusPrice2 . '",
                                                                     `total_paid_real` = total_paid_real - "' . $minusPrice2 . '",
                                                                     `total_products` = total_products - "' .$minusPrice. '",
                                                                     `total_products_wt` = total_products_wt - "' . $minusPrice. '" ,
                                                                     `total_products_markup` =total_products_markup - "' . $DelProduct[0]['product_markup'].'"   
                                                               
                                                               WHERE `id_order` = ' . $order->id);
                                                               
                                                               
          
         if($order->total_paid>10000){
           
            
            $priceNew = $order->total_paid;
            $UniPrice = $priceNew - $minusPrice;
            if($UniPrice<10000){
          
            $shipers =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_delivery`
                                                               WHERE  `id_carrier` = "' . $order->id_carrier . '"');  
            
                
            //print_r($shipers);
            //exit();   
            Db::getInstance()->Execute('UPDATE `ps_orders` SET       `total_paid` = total_paid + "' . $shipers[0]['price'] . '",
                                                                     `total_paid_real` = total_paid_real + "' . $shipers[0]['price'] . '",
                                                                     `total_shipping` = "' . $shipers[0]['price'] . '" 
                                                               
                                                               WHERE `id_order` = ' . $order->id);
                
             
             
             }
            }
                                                               
          
         Db::getInstance()->Execute('UPDATE `ps_product` SET  `quantity` = quantity + "' .$DelProduct[0]['product_quantity'] . '"
                                                            
                                                               
                                                                    WHERE `id_product` = ' . $producId);
               
         
         
         
         
            
            $DelProductCount =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_order_detail`
                                                               WHERE   product_id = "' . $producId . '"');
                                                              
            $SmvtProduct =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_stock_mvt`
                                                               WHERE  id_product = "' . $producId . '"  and id_order = "' . $order->id . '"');  
            
            if(count($DelProductCount) > 0 ){
                
            
            $productNew =   Db::getInstance()->ExecuteS('SELECT  `quantity` FROM `ps_product`
                                                                 WHERE  `id_product` = ' . $producId);  
           
           $quantityAdd = abs($SmvtProduct[0]['quantity']) - $DelProduct[0]['product_quantity'];
        
           $quantityMvt = -$quantityAdd; 
           $quanNew  = $productNew[0]['quantity']; 
            Db::getInstance()->Execute('UPDATE `ps_stock_mvt` 
                                        SET      
                                                                `quantity` =  "' . $quantityMvt . '" ,
                                                                `in_stock` =  "' . $quanNew . '" 
                                                               
                                                               
                                                                  
                                                               
                                                               WHERE  `id_product` = "' . $producId.'" and `id_order` = "'.$id_order.'"');       
            
            }else{
         
           Db::getInstance()->Execute('
        		DELETE FROM `ps_stock_mvt`
        		       WHERE   id_order = "' . $id_order . '"  and `id_product` = "' . $producId.'"');                                                       
           }
          /*Db::getInstance()->Execute('INSERT INTO ps_stock_mvt (
                                                                         id_product,
                                                                         id_order,
                                                                         id_product_attribute,
                                                                         id_stock_mvt_reason,
                                                                         id_employee,
                                                                         quantity,
                                                                         quantity_ordered,
                                                                         in_stock,
                                                                         date_add,
                                                                         date_upd
                                                                         ) 
                                                                       
                                                                       VALUES (
                                                                         
                                                                         "' . $producId.'",
                                                                         "' .$order->id .'",
                                                                         "' . $productNew->product_attribute_id .'",
                                                                         "3",
                                                                         "0",
                                                                         "' .$quantityMvt.'",
                                                                         "' .$quantityAdd .'",
                                                                         "' . $productNew->quantity.'",
                                                                         "' . date("Y-m-d H:i:s").'",
                                                                         "' . date("Y-m-d H:i:s").'")');
                                                                         */ 
                                                                                                                                  
$order->clearCache();                                                                    
        header("Location: $currentIndex&id_order=$order->id&conf=28&view$this->table&token=$this->token");
        }
        
        if (
            Tools::isSubmit('submitMore') AND 
            ($id_order = (int)(Tools::getValue('id_order'))) AND 
            Validate::isLoadedObject($order = new Order($id_order))
            ) {
            $this->mergeOrders($order,$currentIndex,$productNew);            
        }
                
            if (Tools::isSubmit('submitCarrierCh') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
            {  $payOdrerMin =  Configuration::get('PS_SHIPPING_FREE_PRICE');
                $oldCarrier = new Carrier((int)($order->id_carrier));
           if($oldCarrier->is_free == 0){
             if($order->total_products < $payOdrerMin){
             
                
                 Db::getInstance()->Execute('UPDATE `ps_orders`
                                            SET `total_paid` = total_paid - "' . $order->total_shipping . '",
                                                               `total_paid_real` = total_paid_real - "' . $order->total_shipping . '"
                                             WHERE `id_order` = ' . (int)$order->id);
             }
           }
            $newCarrier = new Carrier((int)(Tools::getValue('id_carrier'))); 
            $order = new Order($id_order);
            if($newCarrier->is_free == 0){
             if($order->total_products < $payOdrerMin){
                 $sql = 'SELECT `price` 
                         FROM `ps_delivery`
                         WHERE  id_carrier = "' . $newCarrier->id . '" and id_zone = 9';
               	 $PriceDelivery =   Db::getInstance()->ExecuteS($sql);  
                 $PriceDelivery[0]['price'];
                 Db::getInstance()->Execute('UPDATE `ps_orders`
                                             SET `total_paid` = total_paid + "' . $PriceDelivery[0]['price']. '",
                                                               `total_paid_real` = total_paid_real + "' . $PriceDelivery[0]['price']. '",
                                                               `total_shipping` = "' . $PriceDelivery[0]['price']. '"
                                            WHERE `id_order` = ' . (int)$order->id);
                
               }
             
             }
             
           
           
		  // echo "<pre>";
          // print_r($newCarrier);
          // echo "</pre>";
           
           
           Db::getInstance()->Execute('UPDATE `ps_orders` 
                                       SET `id_carrier` = "' . Tools::getValue('id_carrier') . '"
                                       WHERE `id_order` = ' . (int)$order->id);
          $order->clearCache();
          header("Location: $currentIndex&id_order=$order->id&conf=29&view$this->table&token=$this->token");
        
        }if (Tools::isSubmit('SubmintProductChange') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
		{ 
	  $quantityAdd = (int)(Tools::getValue('qty_product'));
          $quantityOld = (int)(Tools::getValue('oldprice'));
          $producId = Tools::getValue('product_id');
          $productQt = new Product($producId, true,$cookie->id_lang);
          $newAdd = $quantityAdd + $productQt->quantity;
          if($quantityAdd < $quantityOld){
               $newAddProduct = true;
          }elseif($quantityAdd < $newAdd){
            $newAddProduct = true;
          }else{
            $newAddProduct = false;
          }
         // echo $quantityOld;
         // print_r($productQt);
          if($newAddProduct){
            
          
          
		  
          
          $detalProduct  = Tools::getValue('detal_product');
          $DelProduct =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_order_detail`
                                                                WHERE  product_id = "' . $producId . '"  and id_order_detail = "' . $detalProduct . '"');  
   
          Db::getInstance()->Execute('
        		DELETE FROM `ps_order_detail`
        		      WHERE  id_order_detail = "' . $detalProduct . '"  and product_id = "' . $producId . '"');  
          $sdiscount = Sdiscount::getSdiscountInfo((int)($order->id_customer));
                    if(is_array($sdiscount) and $order->sdiscount >0)
                    {
                       $statusUserDisc = Sdiscount::getSdicount($order->sdiscount);
                       $prcDisc = intval($statusUserDisc['percent_sdiscount']);
                        
                    }
             
            $minusPrice = $DelProduct[0]['product_price'] * $DelProduct[0]['product_quantity'];
            $totalMarkup = $DelProduct[0]['product_markup'];
            if (!empty($prcDisc))
            {
                $minusPrice2 = $minusPrice - ($minusPrice/100*$prcDisc);
            }
            else {
                $minusPrice2 = $minusPrice;
             }
            $ORDERProduct =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_orders`
                                                                WHERE   `id_order` = "' . $order->id . '"');  
   
           // echo $totalMarkup;
            //echo "<pre>";
           // print_r($DelProduct);
           // print_r($ORDERProduct);
           // echo "<pre>";
           // exit();
           Db::getInstance()->Execute('UPDATE `ps_orders` SET      `total_paid` = total_paid - "' .$minusPrice2 . '",
                                                                     `total_paid_real` = total_paid_real - "' . $minusPrice2 . '",
                                                                     `total_products` = total_products - "' .$minusPrice. '",
                                                                     `total_products_wt` = total_products_wt - "' . $minusPrice. '" ,
                                                                     `total_products_markup` = total_products_markup - "' . $totalMarkup.'"   
                                                               
                                                               WHERE `id_order` = ' . $order->id);
                                                               
          
         Db::getInstance()->Execute('UPDATE `ps_product` SET  `quantity` = quantity + "' .$DelProduct[0]['product_quantity'] . '"
                                                              
                                                               
                                                                    WHERE `id_product` = ' . $producId);
		 
       
		      
            
              $productAdd = $producId;
                      
		  
           if(isset($productAdd) and isset($quantityAdd) ){
            
             $productNew = new Product($productAdd, true,$cookie->id_lang);
            
             
             //$orderTemp = new Order((int)$order->id); 
             if($productNew->ind_markup == 1){
                $indMarkup = true;
             }else{
                $indMarkup = false;
             }
            
            $markupRuble =  Product::calculatePriceParams($productNew->wholesale_price,$productNew->markup,$indMarkup,$productNew->id);
            // print_r($markupRuble);
             //exit();
                            if (!empty($prcDisc))
            {
                $totalPrice = $productNew->price - ($productNew->price/100*$prcDisc);
            }
                else 
                    {
                      $totalPrice = $productNew->price;
                    }
             for($i=0;$quantityAdd>$i;$i++){

             
             
             Db::getInstance()->Execute('UPDATE `ps_orders` SET      `total_paid` = total_paid + "' . $totalPrice . '",
                                                                     `total_paid_real` = total_paid_real + "' . $totalPrice . '",
                                                                     `total_products` = total_products + "' .$productNew->price . '",
                                                                     `total_products_wt` = total_products_wt + "' . $productNew->price. '" ,
                                                                     `total_products_markup` = total_products_markup + "' . $markupRuble['markup'].'"   
                                                               
                                                               WHERE `id_order` = ' . $order->id);
             
           
           }
           
           $Ship  =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_orders` WHERE `id_order` = "' . $order->id . '"');
           $shipers =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_delivery`
                                                               WHERE  `id_carrier` = "' . $order->id_carrier . '"');  
            
                
            //print_r($shipers);
            //exit();   
 
              
           
           if($Ship[0]['total_paid'] >=10000 and $ORDERProduct[0]['total_paid']<10000){
          
          
            Db::getInstance()->Execute('UPDATE `ps_orders` SET       `total_paid` = total_paid - "' . $shipers[0]['price'] . '",
                                                                     `total_paid_real` = total_paid_real - "' . $shipers[0]['price'] . '",
                                                                      `total_shipping` = 0  
                                                               
                                                               WHERE `id_order` = ' . $order->id);
            
           }
           if($Ship[0]['total_paid'] < 10000 and $ORDERProduct[0]['total_paid']>10000){
          
           
            Db::getInstance()->Execute('UPDATE `ps_orders` SET       `total_paid` = total_paid + "' . $shipers[0]['price'] . '",
                                                                     `total_paid_real` = total_paid_real + "' . $shipers[0]['price'] . '",
                                                                      `total_shipping` = "' . $shipers[0]['price'] . '"  
                                                               
                                                               WHERE `id_order` = ' . $order->id);
            
           }
           
            Db::getInstance()->Execute('INSERT INTO ps_order_detail (
                                                                        id_order,
                                                                        product_id,
                                                                        product_attribute_id,
                                                                        product_name,
                                                                        product_quantity,
                                                                        product_quantity_in_stock,
                                                                        product_quantity_refunded,
                                                                        product_quantity_return,
                                                                        product_quantity_reinjected,
                                                                        product_price,
                                                                        product_markup,
                                                                        reduction_percent,
                                                                        reduction_amount,
                                                                        group_reduction,
                                                                        product_quantity_discount,
                                                                        product_ean13,
                                                                        product_upc,
                                                                        product_reference,
                                                                        product_supplier_reference,
                                                                        product_weight,
                                                                        tax_name,
                                                                        tax_rate,
                                                                        ecotax,
                                                                        ecotax_tax_rate,
                                                                        discount_quantity_applied,
                                                                        download_hash,
                                                                        download_nb,
                                                                        download_deadline) 
                                                                       
                                                                       VALUES (
                                                                         
                                                                         "' . $order->id .'",
                                                                         "' . $productNew->id.'",
                                                                         "' . $productNew->product_attribute_id  .'",
                                                                         "' . $productNew->name.'",
                                                                         "' . $quantityAdd.'",
                                                                         "' . $productNew->product_quantity_in_stock.'",
                                                                         "' . $productNew->product_quantity_refunded.'",
                                                                         "' . $productNew->product_quantity_return.'",
                                                                         "' . $productNew->product_quantity_reinjected.'",
                                                                         "' . $productNew->price .'",
                                                                         "' . $markupRuble['markup']*$quantityAdd .'",
                                                                         "' . $productNew->reduction_percent.'",
                                                                         "' . $productNew->reduction_amount.'",
                                                                         "' . $productNew->group_reduction.'",
                                                                         "' . $productNew->product_quantity_discount.'",
                                                                         "' . $productNew->product_ean13.'",
                                                                         "' . $productNew->product_upc.'",
                                                                         "' . $productNew->reference.'",
                                                                         "' . $productNew->product_supplier_reference.'",
                                                                         "' . $productNew->product_weight.'",
                                                                         "' . $productNew->tax_name.'",
                                                                         "' . $productNew->tax_rate.'",
                                                                         "' . $productNew->ecotax.'",
                                                                         "' . $productNew->ecotax_tax_rate.'",
                                                                         "' . $productNew->discount_quantity_applied.'",
                                                                         "' . $productNew->download_hash.'",
                                                                         "' . $productNew->download_nb.'",
                                                                         "' . $productNew->download_deadline .'")');
           
           
         
           Db::getInstance()->Execute('UPDATE `ps_product` SET      `quantity` =  	quantity - "' . $quantityAdd . '" 
                                                                  
                                                               
                                                               WHERE  `id_product` = ' . $productAdd);
                                                               
           
           
     
   
           $DelProductCount =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_order_detail`
                                                               WHERE   product_id = "' . $productAdd . '"');
                                                              
            $SmvtProduct =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_stock_mvt`
                                                               WHERE  id_product = "' . $productAdd . '"  and id_order = "' . $order->id . '"');  
            
            if(count($DelProductCount) > 0 ){
                
            
            $productNew =   Db::getInstance()->ExecuteS('SELECT  `quantity` FROM `ps_product`
                                                                 WHERE  `id_product` = ' . $productAdd);  
           
           
         
           $quantityAddMwt = abs($SmvtProduct[0]['quantity']) -$quantityOld;
           $quantityAddMwt = $quantityAdd+$quantityAddMwt;
           $quantityMvt = -$quantityAddMwt; 
           $quanNew  = $productNew[0]['quantity']; 
            Db::getInstance()->Execute('UPDATE `ps_stock_mvt` 
                                        SET      
                                                                `quantity` =  "' . $quantityMvt . '" ,
                                                                `in_stock` =  "' . $quanNew . '" 
                                                               
                                                               
                                                                  
                                                               
                                                               WHERE  `id_product` = "' . $productAdd.'" and `id_order` = "'.$id_order.'"');       
            
            }else{
          
           $quantityMvt = -$quantityAdd; 
           $quanNew  = $productNew[0]['quantity']; 
            Db::getInstance()->Execute('UPDATE `ps_stock_mvt` 
                                        SET      
                                                                `quantity` =  "' . $quantityMvt . '" ,
                                                                `in_stock` =  "' . $quanNew . '" 
                                                               
                                                               
                                                                  
                                                               
                                                               WHERE  `id_product` = "' . $productAdd.'" and `id_order` = "'.$id_order.'"');       
          
 
            }
            header("Location: $currentIndex&id_order=$order->id&conf=30&view$this->table&token=$this->token");
            }
         }else{
            	$this->_errors[] = Tools::displayError('Не достататочно товара на складе.');
                 //header("Location: $currentIndex&id_order=$order->id&error=29&view$this->table&token=$this->token");
            }
        
        }
        if (Tools::isSubmit('addbprod') AND ($id_order = (int)(Tools::getValue('id_order'))) AND Validate::isLoadedObject($order = new Order($id_order)))
		{
		  if(isset($_POST['prodquan']) and !empty($_POST['prodquan'])){
		      
              $quantityAdd = (int)(Tools::getValue('prodquan'));
                      
		  }
          if(isset($_POST['prod_id']) and !empty($_POST['prod_id'])){
		      
              $productAdd = (int)(Tools::getValue('prod_id'));
                      
		  }
         
          $producId = $productAdd;
          $productQt = new Product($producId, true,$cookie->id_lang);
         // print_r($productQt);
          if($quantityAdd <= $productQt->quantity){
            
           if(isset($productAdd) and isset($quantityAdd) ){
            
             $productNew = new Product($productAdd, true,$cookie->id_lang);
             
              if($productNew->ind_markup == 1){
                $indMarkup = true;
             }else{
                $indMarkup = false;
             }
            
            $markupRuble =  Product::calculatePriceParams($productNew->wholesale_price,$productNew->markup,$indMarkup,$productNew->id);
                      $sdiscount = Sdiscount::getSdiscountInfo((int)($order->id_customer));
                    if(is_array($sdiscount) and $order->sdiscount >0)
                    {
                       $statusUserDisc = Sdiscount::getSdicount($order->sdiscount);
                       $prcDisc = intval($statusUserDisc['percent_sdiscount']);
                        
                    }
                     if (!empty($prcDisc))
            {
                $totalPrice = $productNew->price - ($productNew->price/100*$prcDisc);
            }
                else 
                    {
                      $totalPrice = $productNew->price;
                    }
                    
  
            
             
             //$orderTemp = new Order((int)$order->id); 
             //print_r($productNew);
        
             for($i=0;$quantityAdd>$i;$i++){
                
             
             
             Db::getInstance()->Execute('UPDATE `ps_orders` SET      `total_paid` = total_paid + "' . $totalPrice . '",
                                                                     `total_paid_real` = total_paid_real + "' . $totalPrice . '",
                                                                     `total_products` = total_products + "' .$productNew->price . '",
                                                                     `total_products_wt` = total_products_wt + "' . $productNew->price. '" ,
                                                                     `total_products_markup` =total_products_markup + "' . $markupRuble['markup'].'"   
                                                               
                                                               WHERE `id_order` = ' . $order->id);
             
           
           }
           $Ship  =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_orders` WHERE `id_order` = "' . $order->id . '"');
           
           if($Ship[0]['total_paid'] >=10000){
            
            Db::getInstance()->Execute('UPDATE `ps_orders` SET      `total_paid` = total_paid - "' . $Ship[0]['total_shipping'] . '",
                                                                     `total_paid_real` = total_paid_real - "' . $Ship[0]['total_shipping'] . '",
                                                                      `total_shipping` = 0  
                                                               
                                                               WHERE `id_order` = ' . $order->id);
            
           }
           
            
            Db::getInstance()->Execute('INSERT INTO ps_order_detail (
                                                                        id_order,
                                                                        product_id,
                                                                        product_attribute_id,
                                                                        product_name,
                                                                        product_quantity,
                                                                        product_quantity_in_stock,
                                                                        product_quantity_refunded,
                                                                        product_quantity_return,
                                                                        product_quantity_reinjected,
                                                                        product_price,
                                                                        product_markup,
                                                                        reduction_percent,
                                                                        reduction_amount,
                                                                        group_reduction,
                                                                        product_quantity_discount,
                                                                        product_ean13,
                                                                        product_upc,
                                                                        product_reference,
                                                                        product_supplier_reference,
                                                                        product_weight,
                                                                        tax_name,
                                                                        tax_rate,
                                                                        ecotax,
                                                                        ecotax_tax_rate,
                                                                        discount_quantity_applied,
                                                                        download_hash,
                                                                        download_nb,
                                                                        download_deadline) 
                                                                       
                                                                       VALUES (
                                                                         
                                                                         "' . $order->id .'",
                                                                         "' . $productNew->id.'",
                                                                         "' . $productNew->product_attribute_id  .'",
                                                                         "' . $productNew->name.'",
                                                                         "' . $quantityAdd.'",
                                                                         "' . $productNew->product_quantity_in_stock.'",
                                                                         "' . $productNew->product_quantity_refunded.'",
                                                                         "' . $productNew->product_quantity_return.'",
                                                                         "' . $productNew->product_quantity_reinjected.'",
                                                                         "' . $productNew->price .'",
                                                                         "' . $markupRuble['markup'].'",
                                                                         "' . $productNew->reduction_percent.'",
                                                                         "' . $productNew->reduction_amount.'",
                                                                         "' . $productNew->group_reduction.'",
                                                                         "' . $productNew->product_quantity_discount.'",
                                                                         "' . $productNew->product_ean13.'",
                                                                         "' . $productNew->product_upc.'",
                                                                         "' . $productNew->reference.'",
                                                                         "' . $productNew->product_supplier_reference.'",
                                                                         "' . $productNew->product_weight.'",
                                                                         "' . $productNew->tax_name.'",
                                                                         "' . $productNew->tax_rate.'",
                                                                         "' . $productNew->ecotax.'",
                                                                         "' . $productNew->ecotax_tax_rate.'",
                                                                         "' . $productNew->discount_quantity_applied.'",
                                                                         "' . $productNew->download_hash.'",
                                                                         "' . $productNew->download_nb.'",
                                                                         "' . $productNew->download_deadline .'")');
           
           
         
           Db::getInstance()->Execute('UPDATE `ps_product` SET      `quantity` =  	quantity - "' . $quantityAdd . '" 
                                                                  
                                                               
                                                               WHERE  `id_product` = ' . $productAdd);
                                                               
           
           
           
           
            $SmvtProduct =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_stock_mvt`
                                                                WHERE  id_product = "' . $productNew->id . '"  and id_order = "' . $order->id . '"');  
            if(!empty($SmvtProduct)){
                
            
            $productNew =   Db::getInstance()->ExecuteS('SELECT  `quantity` FROM `ps_product`
                                                                 WHERE  `id_product` = ' . $productAdd);  
           
           $quantityAdd = abs($SmvtProduct[0]['quantity']) + $quantityAdd;
           $quantityMvt = -$quantityAdd; 
           $quanNew  = $productNew[0]['quantity']; 
            Db::getInstance()->Execute('UPDATE `ps_stock_mvt` 
                                        SET      
                                                                `quantity` =  "' . $quantityMvt . '" ,
                                                                `in_stock` =  "' . $quanNew . '" 
                                                               
                                                               
                                                                  
                                                               
                                                               WHERE  `id_product` = "' . $productAdd.'" and `id_order` = "'.$id_order.'"');       
            
            }else{
                
            
            
                
           $productNew = new Product($productAdd, true,$cookie->id_lang);
           $quantityMvt = -$quantityAdd; 
           $quanNew  = $productNew->quantity-$quantityAdd;
           Db::getInstance()->Execute('INSERT INTO ps_stock_mvt (
                                                                         id_product,
                                                                         id_order,
                                                                         id_product_attribute,
                                                                         id_stock_mvt_reason,
                                                                         id_employee,
                                                                         quantity,
                                                                         quantity_ordered,
                                                                         in_stock,
                                                                         date_add,
                                                                         date_upd
                                                                         ) 
                                                                       
                                                                       VALUES (
                                                                         
                                                                         "' . $productNew->id.'",
                                                                         "' .$order->id .'",
                                                                         "' . $productNew->product_attribute_id .'",
                                                                         "3",
                                                                         "0",
                                                                         "' .$quantityMvt.'",
                                                                         "0",
                                                                         "' . $quanNew.'",
                                                                         "' . date("Y-m-d H:i:s").'",
                                                                         "' . date("Y-m-d H:i:s").'")');
                                                                         
            }                                                                                                                 
            header("Location: $currentIndex&id_order=$order->id&conf=27&view$this->table&token=$this->token");                                                   
           }else{
             echo "ERROR";
           }
         }else{
            $this->_errors[] = Tools::displayError('Не достататочно товара на складе.');
         }
          
          
          //print_r($_POST);
		}

		/* Add a new message for the current order and send an e-mail to the customer if needed */
		elseif (isset($_POST['submitMessage']))
		{
			$_GET['view'.$this->table] = true;
		 	if ($this->tabAccess['edit'] === '1')
			{
				if (!($id_order = (int)(Tools::getValue('id_order'))) OR !($id_customer = (int)(Tools::getValue('id_customer'))))
					$this->_errors[] = Tools::displayError('An error occurred before sending message');
				elseif (!Tools::getValue('message'))
					$this->_errors[] = Tools::displayError('Message cannot be blank');
				else
				{
					/* Get message rules and and check fields validity */
					$rules = call_user_func(array('Message', 'getValidationRules'), 'Message');
					foreach ($rules['required'] AS $field)
						if (($value = Tools::getValue($field)) == false AND (string)$value != '0')
							if (!Tools::getValue('id_'.$this->table) OR $field != 'passwd')
								$this->_errors[] = Tools::displayError('field').' <b>'.$field.'</b> '.Tools::displayError('is required.');
					foreach ($rules['size'] AS $field => $maxLength)
						if (Tools::getValue($field) AND Tools::strlen(Tools::getValue($field)) > $maxLength)
							$this->_errors[] = Tools::displayError('field').' <b>'.$field.'</b> '.Tools::displayError('is too long.').' ('.$maxLength.' '.Tools::displayError('chars max').')';
					foreach ($rules['validate'] AS $field => $function)
						if (Tools::getValue($field))
							if (!Validate::$function(htmlentities(Tools::getValue($field), ENT_COMPAT, 'UTF-8')))
								$this->_errors[] = Tools::displayError('field').' <b>'.$field.'</b> '.Tools::displayError('is invalid.');
					if (!sizeof($this->_errors))
					{
						$message = new Message();
                        $order = new Order((int)($id_order));
						$message->id_employee = (int)($cookie->id_employee);
						$message->message = htmlentities(Tools::getValue('message'), ENT_COMPAT, 'UTF-8');
                        if(Tools::getValue('submitTracking', 'N') == 'Y') {
                            $shipping_number = (string)Tools::getValue('shipping_number', '');
                            $cash_on_delivery = (float)Tools::getValue('cash_on_delivery', 0.00);
                            $carrier = new Carrier((int)($order->id_carrier));
                            $message->message = str_replace(array('[sum]', '[num]', '[delivery]'), array($cash_on_delivery, $shipping_number, $carrier->name), $message->message);
                        }
						$message->id_order = $id_order;
						$message->private = Tools::getValue('visibility', 0);
						if (!$message->add())
							$this->_errors[] = Tools::displayError('An error occurred while sending message.');
						elseif ($message->private)
							Tools::redirectAdmin($currentIndex.'&id_order='.$id_order.'&vieworder&conf=11'.'&token='.$this->token);
						elseif (Validate::isLoadedObject($customer = new Customer($id_customer)))
						{
							if (Validate::isLoadedObject($order))
							{
								$varsTpl = array('{lastname}' => $customer->lastname, '{firstname}' => $customer->firstname, '{middlename}' => $customer->middlename, '{id_order}' => $message->id_order, '{message}' => (Configuration::get('PS_MAIL_TYPE') == 2 ? $message->message : nl2br2($message->message)));
								if (@Mail::Send((int)($order->id_lang), 'order_merchant_comment',
									Mail::l('New message regarding your order', (int)($order->id_lang)), $varsTpl, $customer->email,
									$customer->firstname.' '.$customer->middlename .' '.$customer->lastname, null, null, null, null, _PS_MAIL_DIR_, true)) {
                                    if (Tools::getValue('submitTracking', 'N') == 'Y') {
                                        $redirect = $this->changeOrderState($id_order, (int)(Tools::getValue('id_order_state', 4)));
                                        $order->shipping_number = pSQL($shipping_number);
                                        $order->cash_on_delivery = pSQL($cash_on_delivery);
                                        $order->update();
                                    }
                                    else {
                                        $redirect = true;
                                    }
                                    if ($redirect === true) {
                                        Tools::redirectAdmin($currentIndex.'&id_order='.$id_order.'&vieworder&conf=11'.'&token='.$this->token);
                                    }
                                }
                                
							}
						}
						$this->_errors[] = Tools::displayError('An error occurred while sending e-mail to customer.');
					}
				}
			}
			else
				$this->_errors[] = Tools::displayError('You do not have permission to delete here.');
		}

		/* Cancel product from order */
		elseif (Tools::isSubmit('cancelProduct') && Validate::isLoadedObject($order = new Order((int)Tools::getValue('id_order'))))
		{
			if ($this->tabAccess['delete'] === '1')
			{
				$productList = Tools::getValue('id_order_detail');
				$customizationList = Tools::getValue('id_customization');
				$qtyList = Tools::getValue('cancelQuantity');
				$customizationQtyList = Tools::getValue('cancelCustomizationQuantity');

				$full_product_list = $productList;
				$full_quantity_list = $qtyList;

				if ($customizationList)
					foreach ($customizationList as $key => $id_order_detail)
					{
						$full_product_list[$id_order_detail] = $id_order_detail;
						if (!isset($full_quantity_list[$id_order_detail]))
							$full_quantity_list[$id_order_detail] = 0;
						$full_quantity_list[$id_order_detail] += $customizationQtyList[$key];
					}

				if ($productList || $customizationList)
				{
					if ($productList)
					{
						$id_cart = Cart::getCartIdByOrderId($order->id);
						$customization_quantities = Customization::countQuantityByCart($id_cart);

						foreach ($productList as $key => $id_order_detail)
						{
							$qtyCancelProduct = abs($qtyList[$key]);
							if (!$qtyCancelProduct)
								$this->_errors[] = Tools::displayError('No quantity selected for product.');

							// check actionable quantity
							$order_detail = new OrderDetail($id_order_detail);
							$customization_quantity = 0;
							if (array_key_exists($order_detail->product_id, $customization_quantities) && array_key_exists($order_detail->product_attribute_id, $customization_quantities[$order_detail->product_id]))
								$customization_quantity = (int)$customization_quantities[$order_detail->product_id][$order_detail->product_attribute_id];

							if (($order_detail->product_quantity - $customization_quantity - $order_detail->product_quantity_refunded - $order_detail->product_quantity_return) < $qtyCancelProduct)
								$this->_errors[] = Tools::displayError('Invalid quantity selected for product.');

						}
					}

					if ($customizationList)
					{
						$customization_quantities = Customization::retrieveQuantitiesFromIds(array_keys($customizationList));

						foreach ($customizationList as $id_customization => $id_order_detail)
						{
							$qtyCancelProduct = abs($customizationQtyList[$id_customization]);
							$customization_quantity = $customization_quantities[$id_customization];

							if (!$qtyCancelProduct)
								$this->_errors[] = Tools::displayError('No quantity selected for product.');

							if ($qtyCancelProduct > ($customization_quantity['quantity'] - ($customization_quantity['quantity_refunded'] + $customization_quantity['quantity_returned'])))
								$this->_errors[] = Tools::displayError('Invalid quantity selected for product.');
						}
					}

					if (!count($this->_errors) && $productList)
						foreach ($productList as $key => $id_order_detail)
						{
							$qtyCancelProduct = abs($qtyList[$key]);
							$orderDetail = new OrderDetail((int)$id_order_detail);

							// Reinject product
							if (!$order->hasBeenDelivered() || ($order->hasBeenDelivered() && Tools::isSubmit('reinjectQuantities')))
							{
								$reinjectableQuantity = (int)$orderDetail->product_quantity - (int)$orderDetail->product_quantity_reinjected;

								$quantityToReinject = $qtyCancelProduct > $reinjectableQuantity ? $reinjectableQuantity : $qtyCancelProduct;
								if (!Product::reinjectQuantities($orderDetail, $quantityToReinject))
									$this->_errors[] = Tools::displayError('Cannot re-stock product').' <span class="bold">'.Tools::safeOutput($orderDetail->product_name).'</span>';
								else
								{
									$updProductAttributeID = !empty($orderDetail->product_attribute_id) ? (int)$orderDetail->product_attribute_id : null;

									$newProductQty = Product::getQuantity((int)$orderDetail->product_id, $updProductAttributeID);
									$product = get_object_vars(new Product((int)$orderDetail->product_id, false, (int)$cookie->id_lang));
									if (!empty($orderDetail->product_attribute_id))
									{
										$updProduct['quantity_attribute'] = (int)$newProductQty;
										$product['quantity_attribute'] = $updProduct['quantity_attribute'];
									}
									else
									{
										$updProduct['stock_quantity'] = (int)$newProductQty;
										$product['stock_quantity'] = $updProduct['stock_quantity'];
									}
									Hook::updateQuantity($product, $order);
								}
							}

							// Delete product
							if (!$order->deleteProduct($order, $orderDetail, $qtyCancelProduct))
								$this->_errors[] = Tools::displayError('An error occurred during deletion of the product.').' <span class="bold">'.Tools::safeOutput($orderDetail->product_name).'</span>';
							Module::hookExec('cancelProduct', array('order' => $order, 'id_order_detail' => (int)$id_order_detail));
						}

					if (!count($this->_errors) && $customizationList)
						foreach ($customizationList as $id_customization => $id_order_detail)
						{
							$orderDetail = new OrderDetail((int)$id_order_detail);
							$qtyCancelProduct = abs($customizationQtyList[$id_customization]);
							if (!$order->deleteCustomization((int)$id_customization, (int)$qtyCancelProduct, $orderDetail))
								$this->_errors[] = Tools::displayError('An error occurred during deletion of product customization.').' '.(int)$id_customization;
							elseif (!$order->hasBeenDelivered() || ($order->hasBeenDelivered() && Tools::isSubmit('reinjectQuantities')))
							{
								if (!Product::reinjectQuantities($orderDetail, (int)$qtyCancelProduct))
									$this->_errors[] = Tools::displayError('Cannot re-stock product').' <span class="bold">'.Tools::safeOutput($orderDetail->product_name).'</span>';
								$product = get_object_vars(new Product((int)$orderDetail->product_id, false, (int)$cookie->id_lang));
								if (!empty($orderDetail->product_attribute_id))
								{
									$updProduct['quantity_attribute'] = (int)($newProductQty);
									$product['quantity_attribute'] = $updProduct['quantity_attribute'];
								}
								else
								{
									$updProduct['stock_quantity'] = (int)($newProductQty);
									$product['stock_quantity'] = $updProduct['stock_quantity'];
								}
								Hook::updateQuantity($product, $order);
							}
						}

					// E-mail params
					if ((isset($_POST['generateCreditSlip']) || isset($_POST['generateDiscount'])) && !count($this->_errors))
					{
						$customer = new Customer((int)$order->id_customer);
						$params['{lastname}'] = $customer->lastname;
						$params['{firstname}'] = $customer->firstname;
                        $params['{middlename}'] = $customer->middlename;
						$params['{id_order}'] = $order->id;
					}

					// Generate credit slip
					if (isset($_POST['generateCreditSlip']) && !count($this->_errors))
					{
						if (!OrderSlip::createOrderSlip($order, $full_product_list, $full_quantity_list, isset($_POST['shippingBack'])))
							$this->_errors[] = Tools::displayError('Cannot generate credit slip');
						else
						{
							Module::hookExec('orderSlip', array('order' => $order, 'productList' => $full_product_list, 'qtyList' => $full_quantity_list));
							@Mail::Send((int)$order->id_lang, 'credit_slip', Mail::l('New credit slip regarding your order', (int)$order->id_lang),
							$params, $customer->email, $customer->firstname.' '.$customer->middlename .' '.$customer->lastname, null, null, null, null,
							_PS_MAIL_DIR_, true);
						}
					}

					// Generate voucher
					if (isset($_POST['generateDiscount']) && !count($this->_errors))
					{
						if (!$voucher = Discount::createOrderDiscount($order, $full_product_list, $full_quantity_list, $this->l('Credit Slip concerning the order #'), isset($_POST['shippingBack'])))
							$this->_errors[] = Tools::displayError('Cannot generate voucher');
						else
						{
							$currency = new Currency(_PS_CURRENCY_DEFAULT_);
							$params['{voucher_amount}'] = Tools::displayPrice($voucher->value, $currency, false);
							$params['{voucher_num}'] = $voucher->name;
							@Mail::Send((int)$order->id_lang, 'voucher', Mail::l('New voucher regarding your order', (int)$order->id_lang),
							$params, $customer->email, $customer->firstname.' '.$customer->middlename .' '.$customer->lastname, null, null, null,
							null, _PS_MAIL_DIR_, true);
						}
					}
				}
				else
					$this->_errors[] = Tools::displayError('No product or quantity selected.');

				// Redirect if no errors
				if (!count($this->_errors))
					Tools::redirectAdmin($currentIndex.'&id_order='.$order->id.'&vieworder&conf=24&token='.$this->token);
			}
			else
				$this->_errors[] = Tools::displayError('You do not have permission to delete here.');
		}
		elseif (isset($_GET['messageReaded']))
			Message::markAsRead((int)$_GET['messageReaded'], (int)$cookie->id_employee);

		parent::postProcess();
	}

	private function displayCustomizedDatas(&$customizedDatas, &$product, &$currency, &$image, $tokenCatalog, $id_order_detail)
	{
		if (!($order = $this->loadObject()))
			return;

		if (is_array($customizedDatas) AND isset($customizedDatas[(int)($product['product_id'])][(int)($product['product_attribute_id'])]))
		{
			$imageObj = new Image($image['id_image']);
			echo '
			<tr>
				<td align="center">'.(isset($image['id_image']) ? cacheImage(_PS_IMG_DIR_.'p/'.$imageObj->getExistingImgPath().'.jpg',
				'product_mini_'.(int)($product['product_id']).((isset($product['product_attribute_id']) && $product['product_attribute_id'] > 0)? '_'.(int)($product['product_attribute_id']) : '').'.jpg', 45, 'jpg') : '--').'</td>
				<td><a href="index.php?tab=AdminCatalog&id_product='.$product['product_id'].'&updateproduct&token='.$tokenCatalog.'">
					<span class="productName">'.$product['product_name'].' - '.$this->l('customized').'</span><br />
					'.($product['product_reference'] ? $this->l('Ref:').' '.$product['product_reference'].'<br />' : '')
					.($product['product_supplier_reference'] ? $this->l('Ref Supplier:').' '.$product['product_supplier_reference'] : '')
					.'</a></td>
				<td align="center">'.Tools::displayPrice($product['product_price_wt'], $currency, false).'</td>
				<td align="center" class="productQuantity">'.$product['customizationQuantityTotal'].'</td>
				'.($order->hasBeenPaid() ? '<td align="center" class="productQuantity">'.$product['customizationQuantityRefunded'].'</td>' : '').'
				'.($order->hasBeenDelivered() ? '<td align="center" class="productQuantity">'.$product['customizationQuantityReturned'].'</td>' : '').'
				<td align="center" class="productQuantity">'.(isset($product['stock_quantity']) ? (int)$product['stock_quantity'] : '--').'</td>
				<td align="center">'.Tools::displayPrice(Tools::ps_round($order->getTaxCalculationMethod() == PS_TAX_EXC ? $product['product_price'] : $product['product_price_wt'], 2) * $product['customizationQuantityTotal'], $currency, false).'</td>
				<td align="center" class="cancelCheck">&nbsp;</td>
			</tr>';
			foreach ($customizedDatas[(int)($product['product_id'])][(int)($product['product_attribute_id'])] AS $customizationId => $customization)
			{
				echo '
				<tr>
					<td colspan="2">';
				foreach ($customization['datas'] AS $type => $datas)
					if ($type == _CUSTOMIZE_FILE_)
					{
						$i = 0;
						echo '<ul style="margin: 4px 0px 4px 0px; padding: 0px; list-style-type: none;">';
						foreach ($datas AS $data)
							echo '<li style="display: inline; margin: 2px;">
									<a href="displayImage.php?img='.$data['value'].'&name='.(int)($order->id).'-file'.++$i.'" target="_blank"><img src="'._THEME_PROD_PIC_DIR_.$data['value'].'_small" alt="" /></a>
								</li>';
						echo '</ul>';
					}
					elseif ($type == _CUSTOMIZE_TEXTFIELD_)
					{
						$i = 0;
						echo '<ul style="margin: 0px 0px 4px 0px; padding: 0px 0px 0px 6px; list-style-type: none;">';
						foreach ($datas AS $data)
							echo '<li>'.($data['name'] ? $data['name'] : $this->l('Text #').++$i).$this->l(':').' '.$data['value'].'</li>';
						echo '</ul>';
					}
				echo '</td>
					<td align="center">-</td>
					<td align="center" class="productQuantity">'.$customization['quantity'].'</td>
					'.($order->hasBeenPaid() ? '<td align="center">'.$customization['quantity_refunded'].'</td>' : '').'
					'.($order->hasBeenDelivered() ? '<td align="center">'.$customization['quantity_returned'].'</td>' : '').'
					<td align="center">-</td>
					<td align="center">'.Tools::displayPrice(Tools::ps_round($order->getTaxCalculationMethod() == PS_TAX_EXC ? $product['product_price'] : $product['product_price_wt'], 2) * $customization['quantity'], $currency, false).'</td>
					<td class="cancelCheck" style="padding-left: 10px;">
						<input type="hidden" name="totalQtyReturn" id="totalQtyReturn" value="'.(int)($customization['quantity_returned']).'" />
						<input type="hidden" name="totalQty" id="totalQty" value="'.(int)($customization['quantity']).'" />
						<input type="hidden" name="productName" id="productName" value="'.$product['product_name'].'" />';
				if ((!$order->hasBeenDelivered() || Configuration::get('PS_ORDER_RETURN')) && (int)($customization['quantity_returned'] < (int)$customization['quantity']))
					echo '
						<input type="checkbox" name="id_customization['.$customizationId.']" id="id_customization['.$customizationId.']" value="'.$id_order_detail.'" onchange="setCancelQuantity(this, \''.$customizationId.'\', \''.(int)($customization['quantity'] - $customization['quantity_refunded']).'\')" '.(((int) ($customization['quantity_returned'] + $customization['quantity_refunded']) >= (int)($customization['quantity'])) ? 'disabled="disabled" ' : '').'/>';

				if ((int)($customization['quantity_returned'] + $customization['quantity_refunded']) >= (int)($customization['quantity']))
					echo '<input type="hidden" name="cancelCustomizationQuantity['.$customizationId.']" value="0" />';
				elseif (!$order->hasBeenDelivered() || Configuration::get('PS_ORDER_RETURN'))
					echo '
						<input type="text" id="cancelQuantity_'.$customizationId.'" name="cancelCustomizationQuantity['.$customizationId.']" size="2" onclick="selectCheckbox(this);" value="" /> ';
				echo ($order->hasBeenDelivered() ? (int)($customization['quantity_returned']).'/'.((int)($customization['quantity']) - (int)($customization['quantity_refunded'])) : ($order->hasBeenPaid() ? (int)($customization['quantity_refunded']).'/'.(int)($customization['quantity']) : '')).'
					</td>';
				echo '
				</tr>';
			}
		}
	}

	private function getCancelledProductNumber(&$order, &$product)
	{
		$productQuantity = array_key_exists('customizationQuantityTotal', $product) ? $product['product_quantity'] - $product['customizationQuantityTotal'] : $product['product_quantity'];
		$productRefunded = $product['product_quantity_refunded'];
		$productReturned = $product['product_quantity_return'];
		$content = '0/'.$productQuantity;
		if ($order->hasBeenDelivered())
			$content = $productReturned.'/'.($productQuantity - $productRefunded);
		elseif ($order->hasBeenPaid())
			$content = $productRefunded.'/'.$productQuantity;
		return $content;
	}
    
    public function getCurrentStateFull($id_lang,$id)
	{
		return Db::getInstance()->getRow('
		SELECT oh.`id_order_state`, osl.`name`, os.`logable`
		FROM `'._DB_PREFIX_.'order_history` oh
		LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (osl.`id_order_state` = oh.`id_order_state`)
		LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
		WHERE osl.`id_lang` = '.(int)$id_lang.' AND oh.`id_order` = '.(int)$this->id.'
		ORDER BY `date_add` DESC, `id_order_history` DESC');
	}
	public function viewDetails()
	{
		global $currentIndex, $cookie, $link;
		$irow = 0;
		if (!($order = $this->loadObject()))
			return;

		$customer = new Customer($order->id_customer);
		$customerStats = $customer->getStats();
       
        //print_r($orderReceived);
        
        
		$addressInvoice = new Address($order->id_address_invoice, (int)($cookie->id_lang));
		if (Validate::isLoadedObject($addressInvoice) AND $addressInvoice->id_state)
			$invoiceState = new State((int)($addressInvoice->id_state));
		$addressDelivery = new Address($order->id_address_delivery, (int)($cookie->id_lang));
		if (Validate::isLoadedObject($addressDelivery) AND $addressDelivery->id_state)
			$deliveryState = new State((int)($addressDelivery->id_state));
		$carrier = new Carrier($order->id_carrier);
        //echo $order->id_carrier;
		$history = $order->getHistory($cookie->id_lang);
		$products = $order->getProducts();
		$customizedDatas = Product::getAllCustomizedDatas((int)($order->id_cart));
		Product::addCustomizationPrice($products, $customizedDatas);
		$discounts = $order->getDiscounts();
		$messages = Message::getMessagesByOrderId($order->id, true);
		$states = OrderState::getOrderStates((int)($cookie->id_lang));
		$currency = new Currency($order->id_currency);
		$currentLanguage = new Language((int)($cookie->id_lang));
		$currentState = OrderHistory::getLastOrderState($order->id);
		$sources = ConnectionsSource::getOrderSources($order->id);
		$cart = Cart::getCartByOrderId($order->id);

		$row = array_shift($history);

		if ($prevOrder = Db::getInstance()->getValue('SELECT id_order FROM '._DB_PREFIX_.'orders WHERE id_order < '.(int)$order->id.' ORDER BY id_order DESC'))
			$prevOrder = '<a href="'.$currentIndex.'&token='.Tools::getValue('token').'&vieworder&id_order='.$prevOrder.'"><img style="width:24px;height:24px" src="../img/admin/arrow-left.png" /></a>';
		if ($nextOrder = Db::getInstance()->getValue('SELECT id_order FROM '._DB_PREFIX_.'orders WHERE id_order > '.(int)$order->id.' ORDER BY id_order ASC'))
			$nextOrder = '<a href="'.$currentIndex.'&token='.Tools::getValue('token').'&vieworder&id_order='.$nextOrder.'"><img style="width:24px;height:24px" src="../img/admin/arrow-right.png" /></a>';


		if ($order->total_paid != $order->total_paid_real)
			echo '<center><span class="warning" style="font-size: 16px">'.$this->l('Warning:').' '.Tools::displayPrice($order->total_paid_real, $currency, false).' '.$this->l('paid instead of').' '.Tools::displayPrice($order->total_paid, $currency, false).' !</span></center><div class="clear"><br /><br /></div>';

		// display bar code if module enabled
		$hook = Module::hookExec('invoice', array('id_order' => $order->id));
		if (!empty($hook))
			echo '<div style="float: right; margin: -40px 40px 10px 0;">'.$hook.'</div><br class="clear" />';

		// display order header
		echo '
		<h2>'.$prevOrder.' '.(Validate::isLoadedObject($customer) ? Tools::safeOutput($customer->firstname.' '.$customer->middlename .' '.$customer->lastname).' - ' : '').$this->l('Order #').sprintf('%06d', (int)$order->id).' '.$nextOrder.'</h2>
		<div style="float:left" style="width:440px">
			<div style="width:429px">
				'.((((Validate::isLoadedObject($currentState) && $currentState->invoice) || $order->invoice_number) && count($products))
					? '<a href="pdf.php?id_order='.$order->id.'&pdf"><img src="../img/admin/charged_ok.gif" alt="'.$this->l('View invoice').'" /> '.$this->l('View invoice').'</a>'
					: '<img src="../img/admin/charged_ko.gif" alt="'.$this->l('No invoice').'" /> '.$this->l('No invoice')).' -
				'.(((Validate::isLoadedObject($currentState) && $currentState->delivery) || $order->delivery_number)
					? '<a href="pdf.php?id_delivery='.(int)$order->delivery_number.'"><img src="../img/admin/delivery.gif" alt="'.$this->l('View delivery slip').'" /> '.$this->l('View delivery slip').'</a>'
					: '<img src="../img/admin/delivery_ko.gif" alt="'.$this->l('No delivery slip').'" /> '.$this->l('No delivery slip')).' -
				<a href="javascript:window.print()"><img src="../img/admin/printer.gif" alt="'.$this->l('Print order').'" title="'.$this->l('Print order').'" /> '.$this->l('Print page').'</a>
			</div>
			<div class="clear">&nbsp;</div>';

		/* Display current status */
		if(isset($row['id_order_state']))		
			echo '
				<table cellspacing="0" cellpadding="0" class="table" style="width: 429px">
					<tr>
						<th>'.Tools::displayDate($row['date_add'], (int)($cookie->id_lang), true).'</th>
						<th><img src="../img/os/'.(int)$row['id_order_state'].'.gif" /></th>
						<th>'.Tools::safeOutput(stripslashes($row['ostate_name'])).'</th>
						<th>'.((!empty($row['employee_lastname'])) ? '('.Tools::safeOutput(stripslashes(Tools::substr($row['employee_firstname'], 0, 1)).'. '.stripslashes($row['employee_lastname'])).')' : '').'</th>
					</tr>';
			/* Display previous status */
			if(is_array($history))			
				foreach ($history AS $row)
				{
					echo '
					<tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
						<td>'.Tools::displayDate($row['date_add'], (int)($cookie->id_lang), true).'</td>
						<td><img src="../img/os/'.(int)$row['id_order_state'].'.gif" /></td>
						<td>'.Tools::safeOutput(stripslashes($row['ostate_name'])).'</td>
						<td>'.((!empty($row['employee_lastname'])) ? '('.Tools::safeOutput(stripslashes(Tools::substr($row['employee_firstname'], 0, 1)).'. '.stripslashes($row['employee_lastname'])).')' : '').'</td>
					</tr>';
			}
		echo '
			</table>
			<br />';

		/* Display status form */
        
  
     function getState($id_lang ,$order_id)
	 {
		return Db::getInstance()->getRow('
		SELECT oh.`id_order_state`, osl.`name`, os.`logable`
		FROM `'._DB_PREFIX_.'order_history` oh
		LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (osl.`id_order_state` = oh.`id_order_state`)
		LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
		WHERE osl.`id_lang` = '.(int)$id_lang.' AND oh.`id_order` = '.(int)$order_id.'
		ORDER BY `date_add` DESC, `id_order_history` DESC');
     }
     
     
       
     
        //print_r($currentState);
        //print_r($history);    
        $sqlTable = $this->table == 'order' ? 'orders' : $this->table;
            
        $sql = 'SELECT id_order FROM `ps_orders`
                                  WHERE  id_customer = "' . $order->id_customer . '" and  merge = 0 and  id_order != "'.$order->id .'"';
                                  
         $currentStateTab = $order->getCurrentStateFull($cookie->id_lang);
        $ordersData = Db::getInstance()->ExecuteS($sql);
      
           foreach ($ordersData AS $key => $value) {
        
          $state_orders = getState($cookie->id_lang,$value['id_order']);  
          //print_r($state_orders);
          if($state_orders['id_order_state'] != 3 && $state_orders['id_order_state'] != 13){
            unset($ordersData[$key]);
          }
        
       }
     
       
		echo '
			<form action="'.$currentIndex.'&view'.$this->table.'&token='.$this->token.'" method="post" style="text-align:center;">
				<select name="id_order_state">';
		
		foreach ($states AS $state) {
            if ($state['template'] == 'shipped') {
                $this->submitStateTrack = $state['id_order_state'];
            }
			echo '<option value="'.$state['id_order_state'].'"'.(($state['id_order_state'] == $currentStateTab['id_order_state']) ? ' selected="selected"' : '').'>'.stripslashes($state['name']).'</option>';
        }
        echo '
				</select>
				<input type="hidden" name="id_order" value="'.$order->id.'" />
				<input type="submit" name="submitState" value="'.$this->l('Change').'" class="button" />
			</form>';
         
         /*dispaly more order */ 
         
    // print_r($currentStateTab['id_order_state']);
     if($currentStateTab['id_order_state'] == 3 or $currentStateTab['id_order_state']==13){
        if(!empty($ordersData) ){
         
            
            echo '<br>
			<form action="'.$currentIndex.'&view'.$this->table.'&token='.$this->token.'" method="post" style="text-align:center;">
				<select style="width:250px;" name="id_order_more">';
	
		foreach ($ordersData AS $moreOrders) {
			 echo '<option   value="'.$moreOrders['id_order'].'">Объединить с заказом №00'.$moreOrders['id_order'].'</option>';
        }
        echo '
				</select>
				<input type="hidden" name="id_order" value="'.$order->id.'" />
				<input type="submit" name="submitMore" value="Объеденить" class="button" />
			</form>';
        }
   }
        /* Display customer information */
		if (Validate::isLoadedObject($customer))
		{
			echo '<br />
			<fieldset style="width: 400px">
				<legend><img src="../img/admin/tab-customers.gif" /> '.$this->l('Customer information').'</legend>
                                    <div id="userInfoWrapper">
                                    <div id="field1" class="lsuserinfo">
				<p><a href="?tab=AdminCustomers&id_customer='.$customer->id.'&viewcustomer&token='.Tools::getAdminToken('AdminCustomers'.(int)(Tab::getIdFromClassName('AdminCustomers')).(int)($cookie->id_employee)).'"> '.$customer->firstname.' '.$customer->middlename .' '.$customer->lastname.'</a></p> ('.$this->l('#').$customer->id.')</div><div class="rsuserinfo"><p id="name" title="Скопировать в буфер обмена">Имя</p></div>
				<div id="field2" class="lsuserinfo">(<a href="mailto:'.$customer->email.'">'.$customer->email.'</a>)</div><div class="rsuserinfo"><p id="email" title="Скопировать в буфер обмена">Email</p></div>
                <div id="field3" class="lsuserinfo">Телефон: <span>'.$customer->phone.'</span></div><div class="rsuserinfo"><p id="phone" title="Скопировать в буфер обмена">Телефон</p></div></div>
                <button style="display: none" class="btn">Copy</button>';
			if ($customer->isGuest())
			{
				echo '
				'.$this->l('This order has been placed by a').' <b>'.$this->l('guest').'</b>';
				if (!Customer::customerExists($customer->email, false, true))
				{
					echo '<form method="POST" action="index.php?tab=AdminCustomers&id_customer='.(int)$customer->id.'&token='.Tools::getAdminTokenLite('AdminCustomers').'">
						<input type="hidden" name="id_lang" value="'.(int)$order->id_lang.'" />
						<p class="center"><input class="button" type="submit" name="submitGuestToCustomer" value="'.$this->l('Transform to customer').'" /></p>
						'.$this->l('This feature will generate a random password and send an e-mail to the customer').'
					</form>';
				}
				else
					echo '<div><b style="color:red;">'.$this->l('A registered customer account exists with the same email address').'</b></div>';
			}
			else
			{
			 
                $sdiscounts = Sdiscount::getSum($order->id_customer);
				echo $this->l('Account registered:').' '.Tools::displayDate($customer->date_add, (int)($cookie->id_lang), true).'<br />
				'.$this->l('Valid orders placed:').' <b>'.(int)$customerStats['nb_orders'].'</b><br />
				'.$this->l('Total paid since registration:').' <b>'.Tools::displayPrice(Tools::ps_round(Tools::convertPrice($customerStats['total_orders'], $currency), 2), $currency, false).'</b><br />
                '.'Доставленных заказов на сумму: <b>'.Tools::displayPrice(Tools::ps_round(Tools::convertPrice($sdiscounts, $currency), 2), $currency, false).'
                
                </b><br />';
			    //
               // print_r($customerStats);
            }
			echo '</fieldset>';
		}

		/* Display sources */
		if (sizeof($sources))
		{
			echo '<br />
			<fieldset style="width: 400px;"><legend><img src="../img/admin/tab-stats.gif" /> '.$this->l('Sources').'</legend><ul '.(sizeof($sources) > 3 ? 'style="height: 200px; overflow-y: scroll; width: 360px;"' : '').'>';
			foreach ($sources as $source)
				echo '<li>
						'.Tools::displayDate($source['date_add'], (int)($cookie->id_lang), true).'<br />
						<b>'.$this->l('From:').'</b> <a href="'.$source['http_referer'].'">'.preg_replace('/^www./', '', parse_url($source['http_referer'], PHP_URL_HOST)).'</a><br />
						<b>'.$this->l('To:').'</b> '.$source['request_uri'].'<br />
						'.($source['keywords'] ? '<b>'.$this->l('Keywords:').'</b> '.$source['keywords'].'<br />' : '').'<br />
					</li>';
			echo '</ul></fieldset>';
		}
		// display hook specified to this page : AdminOrder
		if (($hook = Module::hookExec('adminOrder', array('id_order' => $order->id))) !== false)
			echo $hook;

		echo '
		</div>
		<div style="float: left; margin-left: 40px">';

		/* Display invoice information */
		echo '<fieldset style="width: 400px">';
		if ((Validate::isLoadedObject($currentState) && ($currentState->invoice) OR $order->invoice_number) AND count($products))
			echo '<legend><a href="pdf.php?id_order='.$order->id.'&pdf"><img src="../img/admin/charged_ok.gif" /> '.$this->l('Invoice').'</a></legend>
				<a href="pdf.php?id_order='.$order->id.'&pdf">'.$this->l('Invoice #').'<b>'.Configuration::get('PS_INVOICE_PREFIX', (int)($cookie->id_lang)).sprintf('%06d', $order->invoice_number).'</b></a>
				<br />'.$this->l('Created on:').' '.Tools::displayDate($order->invoice_date, (int)$cookie->id_lang, true).
                        '<br/><a style="float:left;margin-right:5px" onclick="javascript:document.getElementById(\'shipping\').submit()" href="#"><img src="../img/admin/excel_ico.png" />Док-ты для ЮР лиц</a>
                        <form id="shipping" action="excel.php" method="GET"><input style="margin-right:5px" type="TEXT" name="shipping" size="4">Добавить доставку,руб
                        <input type="HIDDEN" name="id_order" value="'.$order->id.'"></form>';
		else
			echo '<legend><img src="../img/admin/charged_ko.gif" />'.$this->l('Invoice').'</legend>
				'.$this->l('No invoice yet.');
		echo '</fieldset><br />';

		/* Display shipping infos */
		echo '
		<fieldset style="width:400px">
			<legend><img src="../img/admin/delivery.gif" /> '.$this->l('Shipping information').'</legend>
			'.$this->l('Total weight:').' <b>'.number_format($order->getTotalWeight(), 3).' '.Configuration::get('PS_WEIGHT_UNIT').'</b><br />
			'.$this->l('Carrier:').' <b>'.($carrier->name == '0' ? Configuration::get('PS_SHOP_NAME') : $carrier->name).'</b><br />
			'.((Validate::isLoadedObject($currentState) &&($currentState->delivery) OR $order->delivery_number) ? '<br /><a href="pdf.php?id_delivery='.$order->delivery_number.'">'.$this->l('Delivery slip #').'<b>'.Configuration::get('PS_DELIVERY_PREFIX', (int)($cookie->id_lang)).sprintf('%06d', $order->delivery_number).'</b></a><br />' : '');               
			if ($order->shipping_number)
				echo $this->l('Tracking number:').' <b>'.$order->shipping_number.'</b> '.(!empty($carrier->url) ? '(<a href="'.str_replace('@', $order->shipping_number, $carrier->url).'" target="_blank">'.$this->l('Track the shipment').'</a>)' : '');
    
			/* Carrier module */                        
                        $is_boxberry = false;
			if ($carrier->is_module == 1)
			{
                            if ($carrier->external_module_name == 'boxberry') {
                                $is_boxberry = true;
                            }
                            
                            $module = Module::getInstanceByName($carrier->external_module_name);
                            if (method_exists($module, 'displayInfoByCart'))                                        
                                    echo call_user_func(array($module, 'displayInfoByCart'), $order->id_cart);
                            if (method_exists($module, 'displayInfoByOrder'))
                                    echo call_user_func(array($module, 'displayInfoByOrder'), $order);
			}
            
        $sql = 'SELECT *
                FROM `'._DB_PREFIX_.'carrier`
                WHERE  deleted = 0 and active = 1 and id_carrier !='.$carrier->id;
                                  
        $carrierData = Db::getInstance()->ExecuteS($sql);
        
        //print_R($carrierData);
           
           	echo '<br> <br>
			<form action=" " method="post" style="text-align:left;">
				<select style="width:250px;" name="id_carrier">';
		
		foreach ($carrierData AS $item) {
           
			echo '<option value="'.$item['id_carrier'].'">'.$item['name'] .'</option>';
        }
        echo '
				</select>
				<input type="hidden" name="id_order" value="'.$order->id.'" />
				<input type="submit" name="submitCarrierCh" value="'.$this->l('Change').'" class="button" />
			</form>';
            

			/* Display shipping number field */
			/*if ($carrier->url && $order->hasBeenShipped())
			 echo '
				<form action="'.$currentIndex.'&view'.$this->table.'&token='.$this->token.'" method="post" style="margin-top:10px;">
					<input type="text" name="shipping_number" value="'. $order->shipping_number.'" />
					<input type="hidden" name="id_order" value="'.$order->id.'" />
					<input type="submit" name="submitShippingNumber" value="'.$this->l('Set shipping number').'" class="button" />
				</form>';*/
			echo '
		</fieldset>';
        

		/* Display summary order */
		echo '
		<br />
		<fieldset style="width: 400px">
			<legend><img src="../img/admin/details.gif" /> '.$this->l('Order details').'</legend>
			<label>'.$this->l('Original cart:').' </label>
			<div style="margin: 2px 0 1em 190px;"><a href="?tab=AdminCarts&id_cart='.$cart->id.'&viewcart&token='.Tools::getAdminToken('AdminCarts'.(int)(Tab::getIdFromClassName('AdminCarts')).(int)($cookie->id_employee)).'">'.$this->l('Cart #').sprintf('%06d', $cart->id).'</a></div>
			<label>'.$this->l('Payment mode:').' </label>
			<div style="margin: 2px 0 1em 190px;">'.Tools::substr($order->payment, 0, 32).' '.($order->module ? '('.$order->module.')' : '').'</div>
			<div style="margin: 2px 0 1em 50px;">
				<table class="table" width="300px;" cellspacing="0" cellpadding="0">
					<tr><td width="150px;">'.$this->l('Products').'</td><td align="right">'.Tools::displayPrice($order->getTotalProductsWithTaxes(), $currency, false).'</td></tr>
					'.($order->total_discounts > 0 ? '<tr><td>'.$this->l('Discounts').'</td><td align="right">-'.Tools::displayPrice($order->total_discounts, $currency, false).'</td></tr>' : '').'
					'.($order->total_wrapping > 0 ? '<tr><td>'.$this->l('Wrapping').'</td><td align="right">'.Tools::displayPrice($order->total_wrapping, $currency, false).'</td></tr>' : '').'
					<tr><td>'.$this->l('Shipping').'</td><td align="right">'.Tools::displayPrice($order->total_shipping, $currency, false).'</td></tr>
					<tr style="font-size: 20px"><td><p id="total" title="Скопировать в буфер обмена" class="copyToClipboard">'.$this->l('Total').'</p></td><td id="field4" align="right">'.Tools::displayPrice($order->total_paid, $currency, false).($order->total_paid != $order->total_paid_real ? '<br /><font color="red">('.$this->l('Paid:').' '.Tools::displayPrice($order->total_paid_real, $currency, false, false).')</font>' : '').'</td></tr>';
                    
                    $sdiscount = Sdiscount::getSdiscountInfo((int)($order->id_customer));
                    if(is_array($sdiscount) and $order->sdiscount >0){
                      
                      //print_r($summary);  
                      $minusSumm = Sdiscount::getPercent($order->getTotalProductsWithTaxes(),$order->sdiscount); 
                      $statusUserDisc = Sdiscount::getSdicount($order->sdiscount);
                      echo '<tr style="font-size: 18px"><td>'.$this->l('Скидка').'<span style="font-size: 14px">('.$statusUserDisc['name_sdiscount'].' – '.$statusUserDisc['percent_sdiscount'].'%)</span> </td><td align="right">-'.Tools::displayPrice($minusSumm, $currency, false).'</td></tr>';
                      
                    }
                    
                    
                    
                    echo '<tr style="font-size: 18px"><td>'.$this->l('Markup').'</td><td align="right">'.Tools::displayPrice($order->total_products_markup, $currency, false).'</td></tr>
                    <tr><td>'.$this->l('% of markup').'</td><td align="right">'.(Tools::ps_round(($order->total_products_markup / ($order->total_products - $order->total_products_markup) * 100), 2)).'%</td></tr>
                </table>
			</div>
			<div style="float: left; margin-right: 10px; margin-left: 42px;">
				<span class="bold">'.$this->l('Recycled package:').'</span>
				'.($order->recyclable ? '<img src="../img/admin/enabled.gif" />' : '<img src="../img/admin/disabled.gif" />').'
			</div>
			<div style="float: left; margin-right: 10px;">
				<span class="bold">'.$this->l('Gift wrapping:').'</span>
				 '.($order->gift ? '<img src="../img/admin/enabled.gif" />
			</div>
			<div style="clear: left; margin: 0px 42px 0px 42px; padding-top: 2px;">
				'.(!empty($order->gift_message) ? '<div style="border: 1px dashed #999; padding: 5px; margin-top: 8px;"><b>'.$this->l('Message:').'</b><br />'.nl2br2($order->gift_message).'</div>' : '') : '<img src="../img/admin/disabled.gif" />').'
			</div>
		</fieldset>';
       
		echo '</div>
		<div class="clear">&nbsp;</div>';
         unset($addressDelivery->id_country);
		/* Display adresses : delivery & invoice */
		echo '<div class="clear">&nbsp;</div>
		<div style="float: left">
			<fieldset style="width: 400px;">
				<legend><img src="../img/admin/delivery.gif" alt="'.$this->l('Shipping address').'" />'.$this->l('Shipping address').'</legend>
				<div style="float: right">

					<a href="?tab=AdminAddresses&id_address='.$addressDelivery->id.'&addaddress&realedit=1&id_order='.$order->id.($addressDelivery->id == $addressInvoice->id ? '&address_type=1' : '').'&token='.Tools::getAdminToken('AdminAddresses'.(int)(Tab::getIdFromClassName('AdminAddresses')).(int)($cookie->id_employee)).'&back='.urlencode($_SERVER['REQUEST_URI']).'"><img src="../img/admin/edit.gif" /></a>
					<a href="http://maps.google.com/maps?f=q&hl='.$currentLanguage->iso_code.'&geocode=&q='.$addressDelivery->address1.' '.$addressDelivery->postcode.' '.$addressDelivery->city.($addressDelivery->id_state ? ' '.$deliveryState->name: '').'" target="_blank"><img src="../img/admin/google.gif" alt="" class="middle" /></a>

                                </div><div id="addressText">
				'.$this->displayAddressDetail($addressDelivery)
				.(!empty($addressDelivery->other) ? '<hr />'.$addressDelivery->other.'<br />' : '').'</div>'
			.'</fieldset>
		</div>';
        unset($addressInvoice->id_country);
	 echo '<div style="float: left; margin-left: 40px">
			<fieldset style="width: 400px;">
				<legend><img src="../img/admin/invoice.gif" alt="'.$this->l('Invoice address').'" />'.$this->l('Invoice address').'</legend>
				<div style="float: right"><a href="?tab=AdminAddresses&id_address='.$addressInvoice->id.'&addaddress&realedit=1&id_order='.$order->id.($addressDelivery->id == $addressInvoice->id ? '&address_type=2' : '').'&back='.urlencode($_SERVER['REQUEST_URI']).'&token='.Tools::getAdminToken('AdminAddresses'.(int)(Tab::getIdFromClassName('AdminAddresses')).(int)($cookie->id_employee)).'"><img src="../img/admin/edit.gif" /></a></div>
				'.$this->displayAddressDetail($addressInvoice)
				.(!empty($addressInvoice->other) ? '<hr />'.$addressInvoice->other.'<br />' : '')

			.'</fieldset>
		</div>
		<div class="clear">&nbsp;</div>';
        
        $sqlcom = 'SELECT note
                FROM `'._DB_PREFIX_.'customer`
                WHERE  id_customer ='.$order->id_customer;
                                  
        $commentData = Db::getInstance()->ExecuteS($sqlcom);
               
    
        if($commentData[0]['note'] != ''){
         echo '<div style="float: left;">
			<fieldset style="width: 400px;">
				<legend><img src="../img/admin/invoice.gif" alt="'.$this->l('').'" />'.$this->l('Комментарий о клиенте').'</legend>
				<p>'.
              $commentData[0]['note']
			.'</p></fieldset>
		</div>
		<div class="clear">&nbsp;</div>';
        }
        
        
       if(!empty($ordersData) and ($currentStateTab['id_order_state'] == 3 or $currentStateTab['id_order_state'] == 13)){
            
            echo '<br><span style="font-size: 15px;color:red;font-weight: bold;"">Есть еще заказы.</span><br><br>';
            
        }
        
		/* Products List */
		$has_been_delivered = $order->hasBeenDelivered();
		$has_been_paid = $order->hasBeenPaid();

		echo '<a name="products"><br /></a>

			<input type="hidden" name="id_order" value="'.$order->id.'" />
			<fieldset style="width: 868px; ">
				<legend><img src="../img/admin/cart.gif" alt="'.$this->l('Products').'" />'.$this->l('Products').'</legend>
				<div style="float:left;">
					<table style="width: 868px;" cellspacing="0" cellpadding="0" class="table" id="orderProducts">
						<tr>
							<th align="center" style="width: 60px">&nbsp;</th>
							<th>'.$this->l('Product').'</th>
							<th style="width: 50px; text-align: center">'.$this->l('Unit Price').'</th>
							<th style="width: 20px; text-align: center">'.$this->l('Quantity').'</th>
						
							<th style="width: 20px; text-align: center">'.$this->l('Stock').'</th>
                            <th style="width: 20px; text-align: center">'.$this->l('Заказ').'</th>
                            <th style="width: 20px; text-align: center">'.$this->l('Дозаказ').'</th>
                            <th style="width: 20px; text-align: center">'.$this->l('Average monthly sales').'</th>
                            <th style="width: 20px; text-align: center">'.$this->l('Продано').'</th>
							<th style="width: 50px; text-align: center">'.$this->l('Total').'</th>
							<th style="width: 10px;"><img src="../img/admin/delete.gif" alt="'.$this->l('Products').'" /></th>
						</tr>'
                        ;
                      
						$tokenCatalog = Tools::getAdminToken('AdminCatalog'.(int)(Tab::getIdFromClassName('AdminCatalog')).(int)$cookie->id_employee);
                        ?>
                                                         <script type="text/javascript" >
        $(document).ready(function() {
 $('.minus').click(function () {
       
        var $input = $(this).parent().find('.price_'+$(this).attr('title'));
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {
        
        var $input =  $(this).parent().find('.price_'+$(this).attr('title'));       
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

        });
    </script>
                        <?php
						foreach ($products as $k => $product)
						{
						
                          $productOrdered = Db::getInstance()->getValue('
                                                                		SELECT quantity_ordered
                                                                		FROM `'._DB_PREFIX_.'product`
                                                                		WHERE `id_product` = '.(int)$product['product_id'].'');
 			              
                           $productOrders = $productOrdered;
                          // echo "<pre>";
                          //print_r($product);
                        // echo "<pre>";				
                          $product_price = $order->getTaxCalculationMethod() == PS_TAX_EXC ? $product['product_price'] + $product['ecotax'] : $product['product_price_wt'];
							$image = array();
							if (isset($product['product_attribute_id']) && (int)$product['product_attribute_id'])
								$image = Db::getInstance()->getRow('
								SELECT id_image
								FROM '._DB_PREFIX_.'product_attribute_image
								WHERE id_product_attribute = '.(int)($product['product_attribute_id']));
						 	if (!isset($image['id_image']) || !$image['id_image'])
								$image = Db::getInstance()->getRow('
								SELECT id_image
								FROM '._DB_PREFIX_.'image
								WHERE id_product = '.(int)($product['product_id']).' AND cover = 1');

						 	$stock_quantity = Db::getInstance()->getValue('
							SELECT '.($product['product_attribute_id'] ? 'pa' : 'p').'.quantity
							FROM '._DB_PREFIX_.'product p
							'.($product['product_attribute_id'] ? 'LEFT JOIN '._DB_PREFIX_.'product_attribute pa ON (p.id_product = pa.id_product)' : '').'
							WHERE p.id_product = '.(int)($product['product_id']).'
							'.($product['product_attribute_id'] ? 'AND pa.id_product_attribute = '.(int)($product['product_attribute_id']) : ''));

							if (isset($image['id_image']))
							{
								$target = _PS_TMP_IMG_DIR_.'product_mini_'.(int)($product['product_id']).(isset($product['product_attribute_id']) ? '_'.(int)($product['product_attribute_id']) : '').'.jpg';
								if (file_exists($target))
									$products[$k]['image_size'] = getimagesize($target);
							}
							// Customization display
							$product['stock_quantity'] = (int)$stock_quantity;
							$this->displayCustomizedDatas($customizedDatas, $product, $currency, $image, $tokenCatalog, $k, $stock_quantity);
                            // print_r($product);
							// Normal display
							if ($product['product_quantity'] > $product['customizationQuantityTotal'])
							{
								$quantity = $product['product_quantity'] - $product['customizationQuantityTotal'];
                                $monthly_sales = Product::getAverageMonthlySales($product['product_id']);
                                $productPacked = Db::getInstance()->getValue('
                                                                		SELECT packed
                                                                		FROM `'._DB_PREFIX_.'product`
                                                                		WHERE `id_product` = '.(int)$product['product_id'].'');
 			              
                                
                                if((int)$productOrdered < 0){
                                    $qty_orderednum = 0; 
                                }else{
                                    $qty_orderednum = $productOrdered;
                                }
                                $kratnost = $productPacked;
                                
                                if(empty($kratnost) or $kratnost == 0){
                                    $kratnost = 1;
                                }
                                $qtynum = $product['stock_quantity'];//*$kratnost;
                                
                                $kreserve = Configuration::get('PS_SHOP_KRESERVE');
                                $reorder =  ($monthly_sales*$kreserve) - ($qty_orderednum + $qtynum);
                    
                                $allordereds =  Db::getInstance()->ExecuteS('
                            		SELECT quantity
                            		FROM `'._DB_PREFIX_.'stock_mvt`
                            		WHERE `id_product` = '.(int)$product['product_id'].' and id_stock_mvt_reason = 3 ');
								
                                //print_r($allordereds);
                                $allordered = 0;
                                foreach($allordereds as $item){
                                    $allordered = $allordered + abs($item['quantity']);
                                }
                                
                                $imageObj = new Image($image['id_image']);
                                $p_image = isset($image['id_image']) ? __PS_BASE_URI__._PS_PROD_IMG_.$imageObj->getExistingImgPath().'.jpg' : '#';
								
                        
                                echo '
								<tr'.((isset($image['id_image']) AND isset($products[$k]['image_size'])) ? ' height="'.($products[$k]['image_size'][1] + 7).'"' : '').'>
									<td align="center"><a href="'.$p_image.'" class="thickbox shown" target="_blank">'.(isset($image['id_image']) ? cacheImage(_PS_IMG_DIR_.'p/'.$imageObj->getExistingImgPath().'.jpg',
									'product_mini_'.(int)($product['product_id']).(isset($product['product_attribute_id']) ? '_'.(int)($product['product_attribute_id']) : '').'.jpg', 45, 'jpg') : '--').'</a></td>
									<td><a href="index.php?tab=AdminCatalog&id_product='.$product['product_id'].'&updateproduct&token='.$tokenCatalog.'">
										<span class="productName">'.$product['product_name'].'</span><br />
										'.($product['product_reference'] ? $this->l('Ref:').' '.$product['product_reference'].'<br />' : '')
										.($product['product_supplier_reference'] ? $this->l('Ref Supplier:').' '.$product['product_supplier_reference'] : '')
										.'</a></td>
									<td align="center">'.Tools::displayPrice($product_price, $currency, false).'</td>
									<td align="center" class="productQuantity" '.($quantity > 1 && $product['customizationQuantityTotal'] > 0 ? 'style="font-weight:700;font-size:1.1em;color:red"' : '').'>
                                   
                                    <form action="/adminka/index.php?tab=AdminOrders&id_order='.Tools::getValue('id_order').'&vieworder&token='.$this->token.'" method="POST">
                                    <span title="'.$product['product_id'].'" class="minus" style="font-size: 16px;cursor: pointer;">-</span>
                                    <input type="text" class="price_'.$product['product_id'].'" name="qty_product" style="width: 30px;"  value="'.(int)$quantity.'" />
                                    <span title="'.$product['product_id'].'" class="plus" style="font-size: 16px;cursor: pointer;">+</span>
                                    <input type="hidden" name="oldprice"  value="'.(int)$quantity.'"/>
                                    <input type="hidden" name="product_id"  value="'.$product['product_id'].'"/>
                                    <input type="hidden" name="detal_product"  value="'.$product['id_order_detail'].'"/>
                                    <input type="hidden" name="id_order"  value="'.Tools::getValue('id_order').'"/>
                                    
                                    <input type="submit" class="button" name="SubmintProductChange" value="изменить" />
                                    </form>
                                    
                                    </td>

									<td align="center" class="productQuantity">'.(int)$stock_quantity.'</td>
                                    <td align="center" class="productQuantity">'.$productOrders.'</td>
                                    <td align="center" class="productQuantity">'.$reorder.'</td>
                                    <td align="center" class="productQuantity">'.$monthly_sales.'</td>
                                    <td align="center" class="productQuantity">'.$allordered.'</td>
									<td align="center">'.Tools::displayPrice(Tools::ps_round($product_price, 2) * ((int)($product['product_quantity']) - $product['customizationQuantityTotal']), $currency, false).'</td>
									<td class="cancelCheck"  style="padding-left: 10px;">
                                    
										<input type="hidden" name="totalQtyReturn" id="totalQtyReturn" value="'.(int)($product['product_quantity_return']).'" />
										<input type="hidden" name="totalQty" id="totalQty" value="'.(int)($product['product_quantity']).'" />
										<input type="hidden" name="productName" id="productName" value="'.$product['product_name'].'" />';
								if ((!$has_been_delivered || Configuration::get('PS_ORDER_RETURN')) && (int)$product['product_quantity_return'] < (int)$product['product_quantity'])
									echo '<input type="checkbox" name="id_order_detail['.$k.']" id="id_order_detail['.$k.']" value="'.$product['id_order_detail'].'" onchange="setCancelQuantity(this, '.(int)($product['id_order_detail']).', '.(int)($product['product_quantity_in_stock'] - $product['customizationQuantityTotal'] - $product['product_quantity_reinjected']).')" '.(((int)($product['product_quantity_return'] + $product['product_quantity_refunded']) >= (int)($product['product_quantity'])) ? 'disabled="disabled" ' : '').'/>';

								if ((int)($product['product_quantity_return'] + $product['product_quantity_refunded']) >= (int)($product['product_quantity']))
									echo '<input type="hidden" name="cancelQuantity['.$k.']" value="0" />';
								elseif (!$has_been_delivered || Configuration::get('PS_ORDER_RETURN'))
									echo '
										<input type="text" id="cancelQuantity_'.(int)($product['id_order_detail']).'" name="cancelQuantity['.$k.']" size="2" onclick="selectCheckbox(this);" value="" /> ';
								echo //$this->getCancelledProductNumber($order, $product).
                                '
							 <a href="/adminka/index.php?tab=AdminOrders&id_order='.$order->id.'&deleteproduct&vieworder&product_id='.$product['product_id'].'&detal_product='.$product['id_order_detail'].'&token='.$this->token.'">
			<img src="../img/admin/delete.gif" alt="Удалить" title="Удалить" /></a>
                                    </td>
								</tr>';
							}
						}
					echo '</table>';
     
					/* echo ' <div style="float:left; width:370px; margin-top:15px;"><sup>*</sup> '.$this->l('According to this customer\'s group, prices are displayed:').' '.($order->getTaxCalculationMethod() == PS_TAX_EXC ? $this->l('tax excluded.') : $this->l('tax included.')).(!Configuration::get('PS_ORDER_RETURN') ? '<br /><br />'.$this->l('Merchandise returns are disabled') : '').'</div>'; */ 
					
                                        if (sizeof($discounts))
					{
						echo '<div style="float:right; width:370px; margin-top:15px;">
					<table cellspacing="0" cellpadding="0" class="table" style="width:100%;">
						<tr>
							<th><img src="../img/admin/coupon.gif" alt="'.$this->l('Discounts').'" />'.$this->l('Discount name').'</th>
							<th align="center" style="width: 100px">'.$this->l('Value').'</th>
						</tr>';
						foreach ($discounts as $discount)
							echo '
						<tr>
							<td>'.$discount['name'].'</td>
							<td align="center">'.($discount['value'] != 0.00 ? '- ' : '').Tools::displayPrice($discount['value'], $currency, false).'</td>
						</tr>';
						echo '</table></div>';
					}
 				echo '</div>'; 

				/* Cancel product */
				echo '<div style="clear:both; height:15px;">&nbsp;</div><div style="float: right; width: 160px;">';

				if ($has_been_delivered && Configuration::get('PS_ORDER_RETURN'))
					echo '<input type="checkbox" id="reinjectQuantities" name="reinjectQuantities" class="button" />
					<label for="reinjectQuantities" style="float:none; font-weight:normal;">'.$this->l('Re-stock products').'</label><br />';
				if ((!$has_been_delivered && $has_been_paid) || ($has_been_delivered && Configuration::get('PS_ORDER_RETURN')))
					echo '<input type="checkbox" id="generateCreditSlip" name="generateCreditSlip" class="button" onclick="toogleShippingCost(this)" />&nbsp;<label for="generateCreditSlip" style="float:none; font-weight:normal;">'.$this->l('Generate a credit slip').'</label><br />
					<input type="checkbox" id="generateDiscount" name="generateDiscount" class="button" onclick="toogleShippingCost(this);" />&nbsp;<label for="generateDiscount" style="float:none; font-weight:normal;">'.$this->l('Generate a voucher').'</label><br />
					<span id="spanShippingBack" style="display:none;"><input type="checkbox" id="shippingBack" name="shippingBack" class="button" />&nbsp;<label for="shippingBack" style="float:none; font-weight:normal;">'.$this->l('Repay shipping costs').'</label><br /></span>';
				if (!$has_been_delivered || ($has_been_delivered && Configuration::get('PS_ORDER_RETURN')))
					echo '
					<div style="text-align:center; margin-top:5px;"><input type="submit" name="cancelProduct" value="'.($has_been_delivered ? $this->l('Return products') : ($has_been_paid ? $this->l('Refund products') : $this->l('Cancel products'))).'" class="button" style="margin-top:8px;" /></div>';
				echo 
                '
				</div>
			</fieldset>
		</form>	<div class="clear" style="height:20px;">&nbsp;</div>';?>
        
        <script type="text/javascript" src="/js/clipboard.min.js"></script>
         <script>
                    if (!String.prototype.trim) {
                        (function() {
                    // Вырезаем BOM и неразрывный пробел
                        String.prototype.trim = function() {
                            return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
                            };
                        })();
                    }
                    $(document).ready(function(){
                    var elems = $('#addressText').contents();
                    elems.each(function (i,elem) {
                                        if (elem.nodeType === 3) {
                                            $(elem).wrap('<span class="copySpan" title="Скопировать в буфер обмена">');
                                    
                                    }
                                });
                    
                   // alert (addressText);
                    $('.rsuserinfo p').add('.copyToClipboard').add('.copySpan').mouseover(function() {
                        var elem = $(this);
                        elem.removeClass('tooltipped');
                        elem.removeClass('tooltipped-s');
                 });
                      $('.copySpan').click(function() {
                          var elem = $(this);
                          var copyText = elem.text().trim();
                          var clipboard = new Clipboard('.btn', {
                             text: function() {
                                return copyText;
                             }
                         });
                        clipboard.on('success', function(e) {
                        elem.addClass('tooltipped');
                        elem.addClass('tooltipped-s');       
                        }); 
                         
                        $('.btn').trigger('click');  
                      });
                      $('.rsuserinfo p').add('.copyToClipboard').click(function() {
                          var elem = $(this);
                          var idElem = elem.attr('id');
                          switch (idElem)
                          {
                            case 'name':
                                var copyText = $('#field1 a').text();
                                break;
                            case 'email':
                                var copyText= $('#field2 a').text();
                                break;
                            case 'phone':
                                        //var copyText = $('#field3 span').text();
                                var phone = $('#field3 span').text();
                                var filterStr = phone.replace(/[^0-9]/g,'');
                                var filterStr = filterStr.replace(/^\+?[78]?/,'');
                                if (filterStr.length === 10) {
                                    copyText = 7 + filterStr;
                                }
                                else {
                                    copyText = phone;
                                }
                                
                                break;
                            case 'total':
                                var copyText = $('#field4').text().replace(/[^\d,]/g,"");
                                break;

                          }
                        var clipboard = new Clipboard('.btn', {
                             text: function() {
                             return copyText;
                         }
                     });
                        clipboard.on('success', function(e) {
                             elem.addClass('tooltipped');
                            elem.addClass('tooltipped-s');       
                        });
                        $('.btn').trigger('click');
                     
                          
                      });
                      $('#newprod').click(function() {
                         $('#prodform').css("display", "block"); 
                
                      });
                      
                      $('#submitnewprod').submit(function(){
                        
                      var sku =  $("input[name='artprod']").val();
                       $.ajax({
                			type : "POST",
                			url: "newprod.php",
                			data:{
                				"sku":sku,      		
                			},
                			async : true,
                			success: function(msg) {
                			    $('#prodform').css("display", "block");
                				$("#prodform").html(msg);

                			}
                		 });
                         return false;
                        });
                        
                	
                    });
         </script>           
                    <?php 
                    
                    echo '<br><a style="float:right;margin: 0 30px 0 0;" id="newprod" href="javascript:void(0)" class="button">Добавить позицию.</a><br><br>
                    <div id="prodform" style="float: right;margin: 0 30px 15px 0; display: none;">
                    <form name="prod" id="submitnewprod">
                    <fieldset style="width: 400px;">
                    	<legend style="cursor: pointer;" ><img src="../img/admin/email_edit.gif" />Введите артикул</legend>
            
                    <input type="text" name="artprod" value="" />
                    
                    <input type="submit" class="button" name="subprod" value="Отправить" /> 
                    </fieldset>
                    </form>
                    </div>
                    <br>
';

		/* Display send a message to customer with tracking*/
		$returns = OrderReturn::getOrdersReturn($order->id_customer, $order->id);
		$slips = OrderSlip::getOrdersSlip($order->id_customer, $order->id);
        $orderMessages = OrderMessage::getOrderMessages((int)$order->id_lang);
        /* Display send a message to customer & returns/credit slip*/
		echo '<div style="float: left">
            <form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'&token='.$this->token.'" method="post" onsubmit="if (getE(\'visibility\').checked == true) return confirm(\''.$this->l('Do you want to send this message to the customer?', __CLASS__, true, false).'\');">
			<fieldset style="width: 400px;">
				<legend style="cursor: pointer;" ><img src="../img/admin/email_edit.gif" /> '.$this->l('New tracking message').'</legend>
                <div id="message_fields" style="">
                    <span class="message_fields">'.$this->l('Tracking').':</span> <input type="text" name="shipping_number" value="'.$order->shipping_number.'" /><br />
                    <span class="message_fields">'.$this->l('Tracking cash').':</span> <input type="text" name="cash_on_delivery" value="'.$order->cash_on_delivery.'" />
                </div>
                <input type="hidden" name="id_order" value="'.(int)($order->id).'" />
                <input type="hidden" name="id_customer" value="'.(int)($order->id_customer).'" />
                <input type="hidden" name="submitTracking" value="Y" />
                <input type="hidden" name="message" value="'.htmlentities($orderMessages[2]['message'], ENT_COMPAT, 'UTF-8').'" />
                <input type="hidden" name="id_order_state" value="'.$this->submitStateTrack.'" />
                <input type="submit" class="button" style="float:right;" name="submitMessage" value="'.$this->l('Send').'" />
			</fieldset>
			</form>
            <br />
			<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'&token='.$this->token.'" method="post" onsubmit="if (getE(\'visibility\').checked == true) return confirm(\''.$this->l('Do you want to send this message to the customer?', __CLASS__, true, false).'\');">
			<fieldset style="width: 400px;">
				<legend style="cursor: pointer;" onclick="$(\'#message\').slideToggle();$(\'#message_m\').slideToggle();return false"><img src="../img/admin/email_edit.gif" /> '.$this->l('New message').'</legend>
				<div id="message_m" style="display: '.(Tools::getValue('message') ? 'none' : 'block').'; overflow: auto; width: 400px;">
					<a href="#" onclick="$(\'#message\').slideToggle();$(\'#message_m\').slideToggle();return false"><b>'.$this->l('Click here').'</b> '.$this->l('to add a comment or send a message to the customer').'</a>
				</div>
				<div id="message" style="display: '.(Tools::getValue('message') ? 'block' : 'none').'">
					<select name="order_message" id="order_message" onchange="orderOverwriteMessage(this, \''.$this->l('Do you want to overwrite your existing message?').'\')">
						<option value="0" selected="selected">-- '.$this->l('Choose a standard message').' --</option>';
		foreach ($orderMessages as $orderMessage)
			echo '		<option value="'.htmlentities($orderMessage['message'], ENT_COMPAT, 'UTF-8').'">'.$orderMessage['name'].'</option>';
		echo '		</select><br /><br />
					<b>'.$this->l('Display to consumer?').'</b>
					<input type="radio" name="visibility" id="visibility" value="0" /> '.$this->l('Yes').'
					<input type="radio" name="visibility" value="1" checked="checked" /> '.$this->l('No').'
					<p id="nbchars" style="display:inline;font-size:10px;color:#666;"></p><br /><br />
					<textarea id="txt_msg" name="message" cols="50" rows="8" onKeyUp="var length = document.getElementById(\'txt_msg\').value.length; if (length > 600) length = \'600+\'; document.getElementById(\'nbchars\').innerHTML = \''.$this->l('600 chars max').' (\' + length + \')\';">'.htmlentities(Tools::getValue('message'), ENT_COMPAT, 'UTF-8').'</textarea><br /><br />
					<input type="hidden" name="id_order" value="'.(int)($order->id).'" />
					<input type="hidden" name="id_customer" value="'.(int)($order->id_customer).'" />
					<input type="submit" class="button" name="submitMessage" value="'.$this->l('Send').'" />
				</div>
			</fieldset>
			</form>';
		/* Display list of messages */
		if (sizeof($messages))
		{
			echo '<br />
			<fieldset style="width: 400px;">
			<legend><img src="../img/admin/email.gif" /> '.$this->l('Messages').'</legend>';
			foreach ($messages as $message)
			{
				echo '<div style="overflow:auto; width:400px;" '.($message['is_new_for_me'] ?'class="new_message"':'').'>';
				if ($message['is_new_for_me'])
					echo '<a class="new_message" title="'.$this->l('Mark this message as \'viewed\'').'" href="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'&token='.$this->token.'&messageReaded='.(int)($message['id_message']).'"><img src="../img/admin/enabled.gif" alt="" /></a>';
				echo $this->l('At').' <i>'.Tools::displayDate($message['date_add'], (int)($cookie->id_lang), true);
				echo '</i> '.$this->l('from').' <b>'.(($message['elastname']) ? ($message['efirstname'].' '.$message['elastname']) : ($message['cfirstname'].' '.$message['clastname'])).'</b>';
				echo ((int)($message['private']) == 1 ? '<span style="color:red; font-weight:bold;">'.$this->l('Private:').'</span>' : '');
				echo '<p>'.nl2br2($message['message']).'</p></div><br />';
			}
			echo '<p class="info">'.$this->l('When you read a message, please click on the green check.').'</p>
			</fieldset>';
		}
		echo '</div>';

		/* Display return product */
		echo '<div style="float: left; margin-left: 40px">
			<fieldset style="width: 400px;">
				<legend><img src="../img/admin/return.gif" alt="'.$this->l('Merchandise returns').'" />'.$this->l('Merchandise returns').'</legend>';
		if (!sizeof($returns))
			echo $this->l('No merchandise return for this order.');
		else
			foreach ($returns as $return)
			{
				$state = new OrderReturnState($return['state']);
				echo '('.Tools::displayDate($return['date_upd'], $cookie->id_lang).') :
				<b><a href="index.php?tab=AdminReturn&id_order_return='.$return['id_order_return'].'&updateorder_return&token='.Tools::getAdminToken('AdminReturn'.(int)(Tab::getIdFromClassName('AdminReturn')).(int)($cookie->id_employee)).'">'.$this->l('#').sprintf('%06d', $return['id_order_return']).'</a></b> -
				'.$state->name[$cookie->id_lang].'<br />';
			}
		echo '</fieldset>';

		/* Display credit slip */
		echo '<br />
				<fieldset style="width: 400px;">
					<legend><img src="../img/admin/slip.gif" alt="'.$this->l('Credit slip').'" />'.$this->l('Credit slip').'</legend>';
		if (!sizeof($slips))
			echo $this->l('No slip for this order.');
		else
			foreach ($slips as $slip)
				echo '('.Tools::displayDate($slip['date_upd'], $cookie->id_lang).') : <b><a href="pdf.php?id_order_slip='.$slip['id_order_slip'].'">'.$this->l('#').sprintf('%06d', $slip['id_order_slip']).'</a></b><br />';
		echo '</fieldset></div>
		<div class="clear">&nbsp;</div>
		<br /><br /><a href="'.$currentIndex.'&token='.$this->token.'"><img src="../img/admin/arrow2.gif" /> '.$this->l('Back to list').'</a><br />';
        echo '<script type="text/javascript" src="'._PS_JS_DIR_.'jquery/jquery.fancybox-1.3.4.js"></script>';
        echo '<link href="'._PS_CSS_DIR_.'jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" media="screen">';
        echo '<script type="text/javascript">$(\'.thickbox\').fancybox({
		\'hideOnContentClick\': true,
		\'transitionIn\'	: \'elastic\',
		\'transitionOut\'	: \'elastic\'
	});</script>';
	}

	public function displayAddressDetail($addressDelivery)
	{
		return AddressFormat::generateAddress($addressDelivery, array('avoid' => array()), '<br />');
	}

	public function display()
	{
		global $cookie;

		if (isset($_GET['view'.$this->table]))
			$this->viewDetails();
		else
		{
            if ((int)date('d') < 6) {
                $date_from = date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , 1-7, date("Y")));
                $date_to = date('Y-m-d H:i:s', mktime(23, 59, 59, date("m")  , 5, date("Y")));
            }
            else {
                $date_from = date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , 1, date("Y")));
                $date_to = date('Y-m-d H:i:s', mktime(23, 59, 59, date("m")  , date("d"), date("Y")));
            }
            $this->_where_default = ' AND a.`date_add` >= \''.$date_from.'\' AND a.`date_add` <= \''.$date_to.'\'';
            
			$this->getList((int)$cookie->id_lang, !Tools::getValue($this->table.'Orderby') ? 'date_add' : null, !Tools::getValue($this->table.'Orderway') ? 'DESC' : null);
			$currency = new Currency((int)_PS_CURRENCY_DEFAULT_);
            $total = $this->getTotal();
            $prognoz =$this->getTotalNS();
             if($cookie->profile != 1){ 
                   $permissions = Profile::getProfileAccesses((int)$cookie->profile,91);
             foreach($permissions as $perm){
                 if($perm['id_tab'] == 91){
                    $is_permissions = $perm['view'];
                 }
             }
             if($is_permissions == 1){            	   	
                    echo '<span class="orders-total">'.$this->l('Total order:').' <span class="bold">'.Tools::displayPrice($total['total'], $currency).'</span> / ';
                    echo $this->l('Markup order:').' <span class="bold">'.Tools::displayPrice($total['markup'], $currency).'</span>/ Прогноз: <span class="bold">'.Tools::displayPrice($prognoz['prognoz'], $currency).'</span></span>';
                
                }                               
                
             }             
             else{
    			echo '<span class="orders-total">'.$this->l('Total order:').' <span class="bold">'.Tools::displayPrice($total['total'], $currency).'</span> / ';
                echo $this->l('Markup order:').' <span class="bold">'.Tools::displayPrice($total['markup'], $currency).'</span>/ Прогноз: <span class="bold">'.Tools::displayPrice($prognoz['prognoz'], $currency).'</span></span>';
                
                }
            
            $this->displayList();
            ?>
            <script type="text/javascript">
                
                function setOrderCollection(id, order_collected) {
                    
                    var hasCollect = $('#collect'+id).hasClass('collect_active');
                    //console.log(hasCollect); 
                    $.ajax({
                            type: "GET",
                            url: "/adminka/ajax.php",
                            data: "setOrderCollection=true&token=<?php echo Tools::getValue('token') ?>&order_id="+id+"&order_collected="+hasCollect,
                            contentType: 'application/json; charset=utf-8',
                            dataType: 'json',
                            success: function(msg){
                                //
                                if (msg.params.collect === true) {
                                    $('#collect'+id).toggleClass('collect_active');
                                }
                                else {
                                    console.log(msg.params.error);
                                }
                                
                            }
                 });
                }
        
            </script>
    <?php
		}
	}
    
	private function getTotal()
	{
		$total = 0;
        $markup = 0;
        //print_r($this->_lists);
		foreach ($this->_lists as $item) {
			if ($item['id_currency'] == _PS_CURRENCY_DEFAULT_) {
				$total += (float)$item['total_paid'];
            }
			else
			{
				$currency = new Currency((int)$item['id_currency']);
				$total += Tools::ps_round((float)$item['total_paid'] / (float)$currency->conversion_rate, 2);
			}
            $markup += (float)$item['total_products_markup'];
        }
		return array('total' => $total, 'markup' => $markup);
	}
	private function getTotalNS()
	{
		$total = 0;
        $markup = 0;
        $prognoz = 0;
      
                $date_from = date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , 1, date("Y")));
                $date_to = date('Y-m-d H:i:s', mktime(23, 59, 59, date("m")  , date("d"), date("Y")));
            
           
         $where = ' WHERE `date_add` >= \''.$date_from.'\' AND `date_add` <= \''.$date_to.'\'';
            
        $sql ='SELECT `id_currency`,
                      `total_products_wt`,
                       `total_products_markup`
               FROM `ps_orders`'.$where.'';
    
    $ProductQuery = Db::getInstance()->ExecuteS($sql);
		
        foreach ($ProductQuery as $item) {
			if ($item['id_currency'] == _PS_CURRENCY_DEFAULT_) {
				$total += (float)$item['total_products_wt'];
            }
			else
			{
				$currency = new Currency((int)$item['id_currency']);
				$total += Tools::ps_round((float)$item['total_products_wt'] / (float)$currency->conversion_rate, 2);
			}
            
            $markup += (float)$item['total_products_markup'];
            
            
            
            
        }
          $today = date("d");
         $mounthDay =  cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); // 31
         //echo  $markup;
        $prognoz = ($markup/$today)*$mounthDay;
        
		return array('prognoz' => $prognoz);
	}
    
    private function changeOrderState($id_order, $newOrderStatusId) {
        global $cookie;
        
        $history = new OrderHistory();
        $history->id_order = (int)$id_order;
        $history->id_employee = (int)($cookie->id_employee);
        $history->changeIdOrderState((int)($newOrderStatusId), (int)($id_order));
        $order = new Order((int)$order->id);
        $carrier = new Carrier((int)($order->id_carrier), (int)($order->id_lang));
        $templateVars = array();
        if ($history->id_order_state == Configuration::get('PS_OS_SHIPPING') AND $order->shipping_number)
            $templateVars = array('{followup}' => str_replace('@', $order->shipping_number, $carrier->url));
        elseif ($history->id_order_state == Configuration::get('PS_OS_CHEQUE'))
            $templateVars = array(
                '{cheque_name}' => (Configuration::get('CHEQUE_NAME') ? Configuration::get('CHEQUE_NAME') : ''),
                '{cheque_address_html}' => (Configuration::get('CHEQUE_ADDRESS') ? nl2br(Configuration::get('CHEQUE_ADDRESS')) : ''));
        elseif ($history->id_order_state == Configuration::get('PS_OS_BANKWIRE'))
            $templateVars = array(
                '{bankwire_owner}' => (Configuration::get('BANK_WIRE_OWNER') ? Configuration::get('BANK_WIRE_OWNER') : ''),
                '{bankwire_details}' => (Configuration::get('BANK_WIRE_DETAILS') ? nl2br(Configuration::get('BANK_WIRE_DETAILS')) : ''),
                '{bankwire_address}' => (Configuration::get('BANK_WIRE_ADDRESS') ? nl2br(Configuration::get('BANK_WIRE_ADDRESS')) : ''));
        if ($history->addWithemail(true, $templateVars)) 
            return true;
        $this->_errors[] = Tools::displayError('An error occurred while changing the status or was unable to send e-mail to the customer.');
        return false;
    }
    
    private function mergeOrders($order,$currentIndex) 
    {
        $oldOrderId = (int)(Tools::getValue('id_order_more'));
        echo $oldOrderId;
        if ($this->tabAccess['edit'] !== '1') {
            $this->_errors[] = Tools::displayError('You do not have permission to edit here.');
            return;
        }
        $sqlTable = $this->table == 'order' ? 'orders' : $this->table;
        $sql = 'SELECT * FROM `ps_order_detail` WHERE  id_order = "' . $oldOrderId . '"';
        $oldOrder =   Db::getInstance()->ExecuteS($sql);
        if(empty($oldOrder)){
            $this->_errors[] = Tools::displayError('Invalid merges order ');
            return;
        }        
        foreach($oldOrder as $item){
            Db::getInstance()->Execute('INSERT INTO ps_order_detail (
                                            id_order,
                                            product_id,
                                            product_attribute_id,
                                            product_name,
                                            product_quantity,
                                            product_quantity_in_stock,
                                            product_quantity_refunded,
                                            product_quantity_return,
                                            product_quantity_reinjected,
                                            product_price,
                                            product_markup,
                                            reduction_percent,
                                            reduction_amount,
                                            group_reduction,
                                            product_quantity_discount,
                                            product_ean13,
                                            product_upc,
                                            product_reference,
                                            product_supplier_reference,
                                            product_weight,
                                            tax_name,
                                            tax_rate,
                                            ecotax,
                                            ecotax_tax_rate,
                                            discount_quantity_applied,
                                            download_hash,
                                            download_nb,
                                            download_deadline) 

                                           VALUES (

                                             "' . $order->id .'",
                                             "' . $item['product_id'] .'",
                                             "' . $item['product_attribute_id']  .'",
                                             "' . $item['product_name'].'",
                                             "' . $item['product_quantity'].'",
                                             "' . $item['product_quantity_in_stock'].'",
                                             "' . $item['product_quantity_refunded'].'",
                                             "' . $item['product_quantity_return'].'",
                                             "' . $item['product_quantity_reinjected'].'",
                                             "' . $item['product_price'].'",
                                             "' . $item['product_markup'].'",
                                             "' . $item['reduction_percent'].'",
                                             "' . $item['reduction_amount'].'",
                                             "' . $item['group_reduction'].'",
                                             "' . $item['product_quantity_discount'].'",
                                             "' . $item['product_ean13'].'",
                                             "' . $item['product_upc'].'",
                                             "' . $item['product_reference'].'",
                                             "' . $item['product_supplier_reference'].'",
                                             "' . $item['product_weight'].'",
                                             "' . $item['tax_name'].'",
                                             "' . $item['tax_rate'].'",
                                             "' . $item['ecotax'].'",
                                             "' . $item['ecotax_tax_rate'].'",
                                             "' . $item['discount_quantity_applied'].'",
                                             "' . $item['download_hash'].'",
                                             "' . $item['download_nb'].'",
                                             "' . $item['download_deadline'] .'")');                                                                                                                                       
        }
        $nums = 1;
        // Добавление флага merge для заказа, который объединяется
        Db::getInstance()->Execute('UPDATE `ps_orders` SET `merge` = "' . $nums . '"
                                    WHERE `id_order` = ' . (int)($oldOrderId));
        
        $orderNow = Db::getInstance()->ExecuteS('SELECT * FROM `ps_orders`
                                                WHERE  id_order = "' . $order->id . '"');
        $oldOrderNum = Db::getInstance()->ExecuteS('SELECT * FROM `ps_orders`
                                                    WHERE  id_order = "' . $oldOrderId . '"');
        // $shippings - стоимости доставки
        // $shippingsads - добавляемая стоимость доставки
        // $summOrders - общая стоимость заказов
        // $residue_discount - остаток скидки
        // $all_discount - полная скидка
        if ($orderNow[0]['total_shipping'] >0 and $oldOrderNum[0]['total_shipping'] >0){                               
            $shippings = $oldOrderNum[0]['total_shipping']; 
            $shippingsads = $orderNow[0]['total_shipping'];           
        } elseif ($orderNow[0]['total_shipping']  == 0 and $oldOrderNum[0]['total_shipping'] >0) {
            $shippingsads = $oldOrderNum[0]['total_shipping'];
            $shippings = 0;                                                                 
        } elseif ($orderNow[0]['total_shipping']  > 0 and $oldOrderNum[0]['total_shipping'] == 0) {
            $shippingsads = $orderNow[0]['total_shipping'];   
            $shippings = 0;                                                              
        }else {
            $shippings = 0;
        }
        print_r('<br>Стоимости доставки: '.$shippings);
        print_r('<br>Добавляемая стоимость доставки: '.$shippingsads);
        
        $summOrders = $orderNow[0]['total_products']+$oldOrderNum[0]['total_products'];
        if($summOrders >= 10000) {
            if($orderNow[0]['total_shipping']>0) {
                $orderNow[0]['total_paid'] = $orderNow[0]['total_paid'] - $orderNow[0]['total_shipping'];
                $orderNow[0]['total_paid_real'] = $orderNow[0]['total_paid_real'] - $orderNow[0]['total_shipping'];
            }
            if($oldOrderNum[0]['total_shipping']>0) {
                $oldOrderNum[0]['total_paid'] = $oldOrderNum[0]['total_paid']- $oldOrderNum[0]['total_shipping'];
                $oldOrderNum[0]['total_paid_real'] = $oldOrderNum[0]['total_paid_real']- $oldOrderNum[0]['total_shipping'];                     
            }
            $orderNow[0]['total_shipping'] = 0;
            $shippings = 0;
        }
        $residue_discount = (float) ( $orderNow[0]['residue_discount'] + $oldOrderNum[0]['residue_discount'] );
        $all_discount = (float) ( $orderNow[0]['total_discounts']+$oldOrderNum[0]['total_discounts']);
        $all_discount +=$residue_discount;
        $discountsOrd = $order->getDiscounts(); 
        if (!empty($discountsOrd)) {
            if(isset($discountsOrd[0]['id_order_discount']) and !empty($discountsOrd[0]['id_order_discount'])) {
                Db::getInstance()->Execute('UPDATE `ps_order_discount` SET  `value` = "' .  $all_discount . '"                                                                     
                                            WHERE  `id_order_discount` = '.$discountsOrd[0]['id_order_discount'].' ');
                }
        }
        $discountsOrdl = $order->getDiscountsIds($oldOrderNum[0]['id_order']); 
        if (!empty($discountsOrdl)) {
            Db::getInstance()->Execute('INSERT INTO ps_order_discount (
                                                    id_order,
                                                    id_discount,
                                                    name,
                                                    value
                                                )                                                                
                                                VALUES (                                                                 
                                                        "' . $order->id .'",
                                                        "' . $discountsOrdl[0]['id_discount'] .'",
                                                        "' . $discountsOrdl[0]['name'] .'",
                                                        "' . $all_discount .'")');
                                           
        }
        $orderNow[0]['total_products_wt'] = (float) $orderNow[0]['total_products_wt']+$oldOrderNum[0]['total_products_wt'];
        $orderNow[0]['total_products'] = (float) $orderNow[0]['total_products']+$oldOrderNum[0]['total_products'];
        $orderNow[0]['total_products_markup'] = (float) $orderNow[0]['total_products_markup']+$oldOrderNum[0]['total_products_markup'];                
        $orderNow[0]['total_paid'] = (float) $orderNow[0]['total_paid']+$oldOrderNum[0]['total_paid']-$shippings;
        $orderNow[0]['total_paid_real'] = (float) $orderNow[0]['total_paid_real']+$oldOrderNum[0]['total_paid_real']-$shippings;  
        $orderNow[0]['total_paid'] -= $residue_discount; 
        $orderNow[0]['total_paid_real'] -=$residue_discount;
        /*
        print_r('<br>Остаток скидки: '.$residue_discount);
        print_r('<br>Полная скидка: '.$all_discount);
        print_r('<br>Общая стоимость заказов: '.$summOrders);
        print_r('<br>Старый заказ: '.print_r($oldOrder,true));
        print_r('<br>Скидки: '.print_r($discountsOrd,true));
        print_r('<br>Скидки1: '.print_r($discountsOrdl,true));
        print_r('<br>Пересчитанныйй заказ: '. var_export($orderNow,true));
      //  print_r('<br>Запрос на обновление заказа: '. $updateQuery);
         foreach($oldOrder as $item) {
            $SmvtProduct =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_stock_mvt`
                                                          WHERE  id_product = "' . $item['product_id'] . '"  and id_order = "' . $order->id . '"');
            print_r('<br>Обновляемый продукт: '. var_export($SmvtProduct,true));
         }
     //   die();
        */
        $updateQuery = 'UPDATE `ps_orders` SET  `total_paid` = "' . $orderNow[0]['total_paid'] . '",
                                        `total_paid_real` = "' . $orderNow[0]['total_paid_real'] . '",
                                        `total_products` = "' .$orderNow[0]['total_products'] . '",
                                        `total_products_wt` = "' . $orderNow[0]['total_products_wt'] . '" ,
                                        `total_discounts` = "' . $all_discount . '" ,
                                        `total_products_markup` = "' . $orderNow[0]['total_products_markup'].'",
                                        `total_shipping` = "' . $shippingsads.'"    
                                  WHERE `id_order` = ' . (int)($orderNow[0]['id_order']);
        Db::getInstance()->Execute($updateQuery);
        
        Db::getInstance()->Execute('
        		DELETE FROM `ps_orders`
        		WHERE `id_order` = ' . (int)($oldOrderId));
        foreach($oldOrder as $item) {
            $SmvtProduct =   Db::getInstance()->ExecuteS('SELECT * FROM `ps_stock_mvt`
                                                          WHERE  id_product = "' . $item['product_id'] . '"  and id_order = "' . $order->id . '"');                
            if(!empty($SmvtProduct)){                            
                $productNew = Db::getInstance()->ExecuteS('SELECT `quantity` FROM `ps_product`
                                                                     WHERE  `id_product` = ' . $item['product_id']);
               $quantityAdds = abs($SmvtProduct[0]['quantity']) + $item['product_quantity'];
               $quantityMvt = -$quantityAdds; 
               $quanNew  = $productNew[0]['quantity']; 
               Db::getInstance()->Execute('UPDATE `ps_stock_mvt` 
                                           SET `quantity` =  "' . $quantityMvt . '" ,
                                               `in_stock` =  "' . $quanNew . '" 
                                            WHERE  `id_product` = "' . $item['product_id'].'" and `id_order` = "'.$id_order.'"');                
                } else
                {                    
                    Db::getInstance()->Execute('UPDATE `ps_stock_mvt` SET `id_order` = "' . $order->id . '"
                                                WHERE `id_order` = ' .$oldOrderId .' and id_product ='.$item['product_id']);
                }
                
                Db::getInstance()->Execute('
                           DELETE FROM `ps_order_detail`
                           WHERE `id_order` = "' . (int)($oldOrderId). '" and product_id = "' . $item['product_id'] .'"');
             }  

        Db::getInstance()->Execute('
            DELETE FROM `ps_stock_mvt`
            WHERE `id_order` = "' . (int)($oldOrderId). '"');
              //
        $order->clearCache();
        header("Location: $currentIndex&id_order=$order->id&conf=26&view$this->table&token=$this->token");
        

    }
}

