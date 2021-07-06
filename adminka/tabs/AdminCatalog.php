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

include_once(PS_ADMIN_DIR.'/../classes/AdminTab.php');
include(PS_ADMIN_DIR.'/tabs/AdminCategories.php');
include(PS_ADMIN_DIR.'/tabs/AdminProducts.php');

class AdminCatalog extends AdminTab
{
	/** @var object AdminCategories() instance */
	private $adminCategories;

	/** @var object AdminProducts() instance */
	private $adminProducts;

	/** @var object AttributeGenerator() instance */
	private $attributeGenerator;

	/** @var object imageResize() instance */
	private $imageResize;

	/** @var object Category() instance for navigation*/
	private static $_category = NULL;

	public function __construct()
	{
		/* Get current category */
		$id_category = abs((int)(Tools::getValue('id_category')));
		if (!$id_category) $id_category = 1;
		self::$_category = new Category($id_category);
		if (!Validate::isLoadedObject(self::$_category))
			die('Category cannot be loaded');

		$this->table = array('category', 'product');
		$this->adminCategories = new AdminCategories();
		$this->adminProducts = new AdminProducts();

		parent::__construct();
	}

	/**
	 * Return current category
	 *
	 * @return object
	 */
	public static function getCurrentCategory()
	{
		return self::$_category;
	}

	public function viewAccess($disable = false)
	{
		$result = parent::viewAccess($disable);
		$this->adminCategories->tabAccess = $this->tabAccess;
		$this->adminProducts->tabAccess = $this->tabAccess;
		return $result;
	}

	public function postProcess()
	{
		if (!Tools::getValue('id_product'))
			$this->adminCategories->postProcess();
		elseif (isset($_GET['attributegenerator']))
		{
			if (!isset($this->attributeGenerator))
			{
				include_once(PS_ADMIN_DIR.'/tabs/AdminAttributeGenerator.php');
				$this->attributeGenerator = new AdminAttributeGenerator();
			}
			$this->attributeGenerator->postProcess();
		}
		$this->adminProducts->postProcess($this->token);
	}

	public function displayErrors()
	{
		parent::displayErrors();
		$this->adminProducts->displayErrors();
		$this->adminCategories->displayErrors();
		if (Validate::isLoadedObject($this->attributeGenerator))
			$this->attributeGenerator->displayErrors();
		if (Validate::isLoadedObject($this->imageResize))
			$this->imageResize->displayErrors();
	}

	public function display()
	{
		global $currentIndex;

		if (((Tools::isSubmit('submitAddcategory') OR Tools::isSubmit('submitAddcategoryAndStay')) AND sizeof($this->adminCategories->_errors)) OR isset($_GET['updatecategory']) OR isset($_GET['addcategory']))
		{
			$this->adminCategories->displayForm($this->token);
			echo '<br /><br /><a href="'.$currentIndex.'&token='.$this->token.'"><img src="../img/admin/arrow2.gif" /> '.$this->l('Back to list').'</a><br />';
		}
		elseif (((Tools::isSubmit('submitAddproduct') OR Tools::isSubmit('submitAddproductAndPreview') OR Tools::isSubmit('submitAddproductAndStay') OR Tools::isSubmit('submitSpecificPricePriorities') OR Tools::isSubmit('submitPriceAddition') OR Tools::isSubmit('submitPricesModification')) AND sizeof($this->adminProducts->_errors)) OR Tools::isSubmit('updateproduct') OR Tools::isSubmit('addproduct'))
		{
			$this->adminProducts->displayForm($this->token);
			if (Tools::getValue('id_category') > 1)
				echo '<br /><br /><a href="index.php?tab='.Tools::getValue('tab').'&token='.$this->token.'"><img src="../img/admin/arrow2.gif" /> '.$this->l('Back to home').'</a><br />';
			else
				echo '<br /><br /><a href="index.php?tab='.Tools::getValue('tab').'&token='.$this->token.'"><img src="../img/admin/arrow2.gif" /> '.$this->l('Back to catalog').'</a><br />';
		}
		elseif (isset($_GET['attributegenerator']))
		{
			if (!isset($this->attributeGenerator))
			{
				include_once(PS_ADMIN_DIR.'/tabs/AdminAttributeGenerator.php');
				$this->attributeGenerator = new AdminAttributeGenerator();
			}
			$this->attributeGenerator->displayForm();
		}
		elseif (!isset($_GET['editImage']))
		{
			$id_category = (int)(Tools::getValue('id_category'));
			if (!$id_category)
				$id_category = 1;
			$catalog_tabs = array('category', 'product');
			// Cleaning links
			$catBarIndex = $currentIndex;
			foreach ($catalog_tabs AS $tab)
				if (Tools::getValue($tab.'Orderby') && Tools::getValue($tab.'Orderway')) 
					$catBarIndex = preg_replace('/&'.$tab.'Orderby=([a-z _]*)&'.$tab.'Orderway=([a-z]*)/i', '', $currentIndex);
			
            $product_count = Product::getProducts(6,1,5000000,'price','asc');
            (int)$ordered_num = 0;
            (int)$prod_qyatity = 0;
            (int) $sum_price_stock = 0;
            (int) $sum_price_ordered = 0;
            (int) $allSumm = 0;
            foreach($product_count as $prod){
                 if(0>$prod['quantity_ordered']){
                    $ordered_num = 0;
                 }else{
                     $ordered_num = $prod['quantity_ordered'];
                 }
                
                 if(0>$prod['quantity']){
                    $prod_qyatity = 0;
                 }else{
                     $prod_qyatity = $prod['quantity'];
                 }
                
                 //$prod_qyatity =  $prod['quantity'];
                 
                 $formula = ($prod_qyatity+$ordered_num)*$prod['price'];
                 $allSumm +=$formula;
                //$sum_price_stock += $prod['price'] * abs($prod['quantity']);
                //$sum_price_ordered += $prod['price'] * abs($prod['quantity_ordered']);
                
                
                
            }
            
            //echo $prod_qyatity."- в наличии<br>";
            //echo $ordered_num."- в заказе<br>";
            //echo $sum_price_stock."- сумма наличия<br>";
            //echo $sum_price_ordered."- сумма заказаного<br>";
          
            //$all_goods = ($prod_qyatity+$ordered_num)*($sum_price_stock+$sum_price_ordered);
            $currency = new Currency((int)_PS_CURRENCY_DEFAULT_);
			echo '<div class="cat_bar"><span style="color: #3C8534;">'.$this->l('Current category').' :</span>&nbsp;&nbsp;&nbsp;'.getPath($catBarIndex, $id_category).'</div>';
			echo '<h2>'.$this->l('Categories').'</h2>';
          
            //$profiles = Profile::getProfiles((int)$cookie->id_lang);
            global $cookie;
            if($cookie->profile != 1){                           
             $permissions = Profile::getProfileAccesses((int)$cookie->profile,91);
             foreach($permissions as $perm){
                 if($perm['id_tab'] == 91){
                    $is_permissions = $perm['view'];
                 }
             }
             if($is_permissions == 1){
                 
                 echo '<span style="font-size:15px ;">Товаров в обороте на сумму: <strong> '.Tools::displayPrice($allSumm, $currency).'</strong></span><br/><br/>';
			  }
             
             
            }else{
               echo '<span style="font-size:15px ;">Товаров в обороте на сумму: <strong> '.Tools::displayPrice($allSumm, $currency).'</strong></span><br/><br/>';
			  
            }
             //print_r($permissions);
            
            $this->adminCategories->display($this->token);
			echo '<div style="margin:10px">&nbsp;</div>';
			echo '<h2>'.$this->l('Products in this category').'</h2>';
			$this->adminProducts->display($this->token);
		}
	}
}


