<?php 
/**
 * @author fatory
 * @copyright 2014
 * @email 
 */

class AdminMovement extends AdminTab
{
	public function __construct()
	{
		global $cookie;
        $this->optionTitle = 'Движение.';
	 	$this->table = 'movement';
	 	$this->className = 'Movement';
	 	$this->view = true;
        parent::__construct();
        $productAdd = array();
        global $productAdd;
        

   }
   
   
   
  public function displayForm($isMainTab = true)
	{
		global $currentIndex, $cookie;


echo  '
		<h2>Движение</h2>
		<fieldset style="float:left;width:400px"><legend>'.$this->l('Движение товара').'</legend>
			<form action="'.$currentIndex.'&token='.$this->token.'" method="post">
                <div class="" style="float:left;margin-left:0px;">
					<input type="submit" value="Заказ товара" name="submitOrder" class="button" />
				</div>
                <div class="margin-form" style="margin-left:150px;">
					<input type="submit" value="Приход товара" name="submitComing" class="button" />
				</div>
				<div class="margin-form" style="padding-left:0px;">
					<textarea  name="data_prod"  style="width: 450px;height: 500px;" /> </textarea>
				</div>
			</form>
		</fieldset>
        <fieldset style="float:left;width: 400px;margin-left:10px"> <legend>'.$this->l('Результат').'</legend>
			<form action="'.$currentIndex.'&token='.$this->token.'" method="post">
				<label style="width:90px">'.$this->l('Statuses').' :</label>
				<div class="margin-form" style="padding-left:100px">
				<p class="clear">'.$this->l('Нет данных').'()</p>
				</div>
				<div class="margin-form">
				</div>
			</form>
		</fieldset>
		<div class="clear">&nbsp;</div>';
	

		return parent::displayForm();
	}
   
   
   	public function display()
	{
		
        
        
     if (Tools::isSubmit('submitOrder') or Tools::isSubmit('submitComing') ){
           
  
       
        }else{
            $this->displayForm();
        }
	
	}
    
   	public function postProcess()
	{
		global $currentIndex;
         
    
            
		if (Tools::isSubmit('submitOrder')){
		  
          if(!empty($_POST['data_prod'])){
		      
           $dataProduct = trim(Tools::getValue('data_prod'));
           
           $dataProduct = explode("\n",$dataProduct);
 

           foreach($dataProduct as $item){
                trim($item);
                $dataTemp = explode(";",$item);
               
               
           $ProductQuery = Db::getInstance()->ExecuteS('SELECT quantity,quantity_ordered,packed,id_product FROM `ps_product`
                                                                    WHERE  reference = "' . trim($dataTemp[0]) . '"');
        
           if(!empty($ProductQuery[0]['packed'])){
                    $dataTemp[1] = trim($dataTemp[1])*$ProductQuery[0]['packed'];
                    
                }    
         
           if(empty($ProductQuery)){
             $noOrder[] = array('articul' =>$dataTemp[0],'num' =>$dataTemp[1]);
           }else{
           if($ProductQuery[0]['quantity_ordered']<0){
            Db::getInstance()->Execute('UPDATE `ps_product` SET  
                                                                     `quantity_ordered` = 0
                                  
                                                                   WHERE  id_product = "' . $ProductQuery[0]['id_product'] . '"');
                                                                    
            
 }
                Db::getInstance()->Execute('UPDATE `ps_product` SET  
                                                                     `quantity_ordered` = quantity_ordered + "' .$dataTemp[1] . '"
                                  
                                                                   WHERE  id_product = "' . $ProductQuery[0]['id_product'] . '"');
                                                                    
              
            
            
            $productAllData = Db::getInstance()->ExecuteS('SELECT quantity,quantity_ordered,packed,id_product FROM `ps_product`
                                                                    WHERE  id_product = "' . $ProductQuery[0]['id_product'] . '"');
        
            $image = array();
	        $image = Db::getInstance()->getRow('
                								SELECT id_image
                								FROM ps_image
                								WHERE id_product = '.(int)($ProductQuery[0]['id_product']).' AND cover = 1');

          	$imageObj = new Image($image['id_image']);
            $p_image_temp = isset($image['id_image']) ? __PS_BASE_URI__._PS_PROD_IMG_.$imageObj->getExistingImgPath().'-small.jpg' : '#';
           //echo   $productAllData->link_rewrite;       
            $p_image = $p_image_temp; 
                          
        // echo "<pre>";
          //print_r($image);
          // echo "</pre>";
           $quantityMvt = '-'.$dataTemp[1];
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
                                                                         
                                                                         "' . $ProductQuery[0]['id_product'].'",
                                                                         "0",
                                                                         "' . $productNew->product_attribute_id .'",
                                                                         "8",
                                                                         "0",
                                                                         "0",
                                                                         "' .$dataTemp[1] .'",
                                                                         "' . $productAllData[0]['quantity'].'",
                                                                         "' . date("Y-m-d H:i:s").'",
                                                                         "' . date("Y-m-d H:i:s").'")');
                                                                        
            
            $productAdd[] = array('img' =>$p_image,
                                  'articul' =>$dataTemp[0],
                                  'num_old' =>$ProductQuery[0]['quantity_ordered'],
                                  'num_add' =>$dataTemp[1],
                                  'num_new' =>$productAllData[0]['quantity_ordered']);
           }     
                
                
           
              //unset($productAllData);  
                
            }
            
       echo  '
		<h2>Движение</h2>
		<fieldset style="float:left;width:400px"><legend>'.$this->l('Движение товара').'</legend>
			<form action="'.$currentIndex.'&token='.$this->token.'" method="post">
                <div class="" style="float:left;margin-left:0px;">
					<input type="submit" value="Заказ товара" name="submitOrder" class="button" />
				</div>
                <div class="margin-form" style="margin-left:150px;">
					<input type="submit" value="Приход товара" name="submitComing" class="button" />
				</div>
				<div class="margin-form" style="padding-left:0px;">
					<textarea  name="data_prod"  style="width: 450px;height: 500px;" /> </textarea>
				</div>
			</form>
		</fieldset>
        <fieldset style="float:left;width: 400px;margin-left:10px"> <legend>'.$this->l('Результат').'</legend>
			<form action="'.$currentIndex.'&token='.$this->token.'" method="post">
				<label style="width:90px">'.$this->l('Занесенные').' :</label>
                <br>
                <br>
				<div class="" style="">
                <table>
                <tr>
                	<td>Картинка</td>
                	<td>Артикул</td>
                	<td>Было</td>
                	<td>Добавлено</td>
                	<td>Стало</td>
                </tr>';
                
                foreach($productAdd as $item){
                                  echo '<tr>
                	<td><img src="'.$item['img'].'" /></td>
                	<td>'.$item['articul'].'</td>
                	<td>'.$item['num_old'].'</td>
                	<td>'.$item['num_add'].'</td>
                	<td>'.$item['num_new'].'</td>
                </tr>';
                    
                    
                }
              
			   echo'  </table></div>';
               if(!empty($noOrder)){
			echo'<label style="width:130px">'.$this->l('Не занесенные').' :</label>
                <br>
                <br>
				<div class="" style="">
                <table>
                <tr>
                	<td>Артикул</td>
                	<td>Количество</td>
                </tr>';
                
                foreach($noOrder as $item){
                                  echo '<tr>

                	<td>'.$item['articul'].'</td>
                	<td>'.$item['num'].'</td>
                </tr>';
                    
                    
                }
               
			   echo'  </table></div>';
              }
		echo '</form>
		</fieldset>
		<div class="clear">&nbsp;</div>';
          
              
		  }else{
		    
            //Вывести ошибку.
		  
          }
		  
		
		
		}
		elseif (Tools::isSubmit('submitComing'))
		{
			 if(!empty($_POST['data_prod'])){
	
    function deleteAlert($id_customer, $customer_email, $id_product, $id_product_attribute)
	{
		return Db::getInstance()->Execute('
		DELETE FROM `'._DB_PREFIX_.'mailalert_customer_oos` 
		WHERE '.(($id_customer > 0) ? '(`customer_email` = \''.pSQL($customer_email).'\'
		OR `id_customer` = '.(int)$id_customer.')' : 
		'`customer_email` = \''.pSQL($customer_email).'\'').
		' AND `id_product` = '.(int)$id_product.'
		AND `id_product_attribute` = '.(int)$id_product_attribute);
	}		     
    function sendCustomerAlert($id_product, $id_product_attribute)
	{
		$link = new Link();

		$customers = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT id_customer, id_lang, customer_email
		FROM `'._DB_PREFIX_.'mailalert_customer_oos`
		WHERE `id_product` = '.(int)$id_product.' AND `id_product_attribute` = '.(int)$id_product_attribute);

		if (count($customers) && $product = new Product((int)$id_product, false))
			foreach ($customers as $cust)
			{
				if ($cust['id_customer'])
				{
					$customer = new Customer((int)$cust['id_customer']);
					$customer_email = $customer->email;
					$customer_id = (int)$customer->id;
				}
				else
				{
					$customer_email = $cust['customer_email'];
					$customer_id = 0;
				}
			
                
				$product_name = (!isset($product->name[(int)$cust['id_lang']]) || empty($product->name[(int)$cust['id_lang']])) ? 
				$product->name[(int)Configuration::get('PS_LANG_DEFAULT')] : $product->name[(int)$cust['id_lang']];				

				$templateVars = array('{product}' => $product_name, '{product_link}' => $link->getProductLink($product, null, null, null, (int)$cust['id_lang']));		
				$iso = Language::getIsoById((int)$cust['id_lang']);
				//echo Configuration::get('PS_SHOP_EMAIL');
                //exit();
                     $htmlmail = $_SERVER["DOCUMENT_ROOT"].'/modules/mailalerts/mails/'.$iso.'/customer_qty.html';
				     $txtmail = $_SERVER["DOCUMENT_ROOT"].'/modules/mailalerts/mails/'.$iso.'/customer_qty.txt';
                if (file_exists($txtmail) && file_exists($htmlmail)){
				  
                     
                   Mail::Send((int)$cust['id_lang'], 'customer_qty', Mail::l('Product available', (int)$cust['id_lang']), $templateVars, strval($customer_email), null, strval(Configuration::get('PS_SHOP_EMAIL')), strval(Configuration::get('PS_SHOP_NAME')), null, null, $_SERVER["DOCUMENT_ROOT"].'/modules/mailalerts/mails/');
             
				}
                //exit();
				 
				
				deleteAlert((int)$customer_id, strval($customer_email), (int)$id_product, (int)$id_product_attribute);
			}
	}   
    
                 
		      
           $dataProduct = trim(Tools::getValue('data_prod'));
           
           $dataProduct = explode("\n",$dataProduct);
 

           foreach($dataProduct as $item){
                trim($item);
                $dataTemp = explode(";",$item);
              
                
           $ProductQuery = Db::getInstance()->ExecuteS('SELECT quantity,quantity_ordered,packed,id_product FROM `ps_product`
                                                                    WHERE  reference = "' . trim($dataTemp[0]) . '"');
                                                                    
              if(!empty($ProductQuery[0]['packed'])){
                    $dataTemp[1] = trim($dataTemp[1])*$ProductQuery[0]['packed'];
                    
                }    
           if(empty($ProductQuery)){
             $noOrder[] = array('articul' =>$dataTemp[0],'num' =>$dataTemp[1]);
           }else{
            
            
                
                
                Db::getInstance()->Execute('UPDATE `ps_product` SET  `quantity` = quantity + "' .trim($dataTemp[1]) . '",
                                                                     `quantity_ordered` = quantity_ordered - "' .$dataTemp[1] . '"
                                  
                                                                    WHERE  id_product = "' . $ProductQuery[0]['id_product'] . '"');
                                                                    
              
              if($ProductQuery[0]['quantity'] > $ProductQuery[0]['quantity_ordered']){
                 
                 Db::getInstance()->Execute('UPDATE `ps_product` SET  
                                                                     `quantity_ordered` = 0
                                  
                                                                    WHERE `id_product` = "' . $ProductQuery[0]['id_product'].'"');
                
            }
            
            sendCustomerAlert($ProductQuery[0]['id_product'],0);
            
            
            $productAllData = Db::getInstance()->ExecuteS('SELECT quantity,quantity_ordered,packed,id_product FROM `ps_product`
                                                                    WHERE  id_product = "' . $ProductQuery[0]['id_product'] . '"');
        
        
            $image = array();
	        $image = Db::getInstance()->getRow('
                								SELECT id_image
                								FROM ps_image
                								WHERE id_product = '.(int)($ProductQuery[0]['id_product']).' AND cover = 1');

          	$imageObj = new Image($image['id_image']);
            $p_image_temp = isset($image['id_image']) ? __PS_BASE_URI__._PS_PROD_IMG_.$imageObj->getExistingImgPath().'-small.jpg' : '#';
           //echo   $productAllData->link_rewrite;       
            $p_image = $p_image_temp; 
                          
        // echo "<pre>";
          //print_r($image);
          // echo "</pre>";
           $quantityMvt = '-'.$dataTemp[1];
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
                                                                         
                                                                         "' . $ProductQuery[0]['id_product'].'",
                                                                         "0",
                                                                         "' . $productNew->product_attribute_id .'",
                                                                         "1",
                                                                         "0",
                                                                         "' .$dataTemp[1].'",
                                                                         "' .$quantityMvt .'",
                                                                         "' . $productAllData[0]['quantity'].'",
                                                                         "' . date("Y-m-d H:i:s").'",
                                                                         "' . date("Y-m-d H:i:s").'")');
                                                                        
            
          
            
            $productAdd[] = array('img' =>$p_image,
                                  'articul' =>$dataTemp[0],
                                  'num_old' =>$ProductQuery[0]['quantity'],
                                  'num_add' =>$dataTemp[1],
                                  'num_new' =>$productAllData[0]['quantity'],
                                  'order' => $productAllData[0]['quantity_ordered']);
           }     
                
                
           
                
                
            }
            
       echo  '
		<h2>Движение</h2>
		<fieldset style="float:left;width:400px"><legend>'.$this->l('Движение товара').'</legend>
			<form action="'.$currentIndex.'&token='.$this->token.'" method="post">
                <div class="" style="float:left;margin-left:0px;">
					<input type="submit" value="Заказ товара" name="submitOrder" class="button" />
				</div>
                <div class="margin-form" style="margin-left:150px;">
					<input type="submit" value="Приход товара" name="submitComing" class="button" />
				</div>
				<div class="margin-form" style="padding-left:0px;">
					<textarea  name="data_prod"  style="width: 450px;height: 500px;" /> </textarea>
				</div>
			</form>
		</fieldset>
        <fieldset style="float:left;width: 400px;margin-left:10px"> <legend>'.$this->l('Результат').'</legend>
			<form action="'.$currentIndex.'&token='.$this->token.'" method="post">
				<label style="width:90px">'.$this->l('Занесенные').' :</label>
                <br>
                <br>
				<div class="" style="">
                <table>
                <tr>
                	<td>Картинка</td>
                	<td>Артикул</td>
                	<td>Было</td>
                	<td>Добавлено</td>
                	<td>Стало</td>
                   
                </tr>';
                
                foreach($productAdd as $item){
                                  echo '<tr>
                	<td><img src="'.$item['img'].'" /></td>
                	<td>'.$item['articul'].'</td>
                	<td>'.$item['num_old'].'</td>
                	<td>'.$item['num_add'].'</td>
                	<td>'.$item['num_new'].'</td>
                  
                </tr>';
                    
                    
                }
              
			   echo'  </table></div>';
               if(!empty($noOrder)){
			echo'<label style="width:130px">'.$this->l('Не занесенные').' :</label>
                <br>
                <br>
				<div class="" style="">
                <table>
                <tr>
                	<td>Артикул</td>
                	<td>Количество</td>
                </tr>';
                
                foreach($noOrder as $item){
                                  echo '<tr>

                	<td>'.$item['articul'].'</td>
                	<td>'.$item['num'].'</td>
                </tr>';
                    
                    
                }
               
			   echo'  </table></div>';
              }
		echo '</form>
		</fieldset>
		<div class="clear">&nbsp;</div>';
          
              
		  }else{
		    
            //Вывести ошибку.
		  
          }
		}
		
	parent::postProcess();
     
     return $rrr;
	
    }
    
   
   
 }  
?>