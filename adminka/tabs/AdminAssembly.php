<?php


//ini_set("display_errors",1);
// error_reporting(E_ALL);
session_start();
class AdminAssembly extends AdminTab
{
    
   	public function __construct()
	{
		global $cookie;
        $this->optionTitle = 'Сборка';
 	    $this->table = 'movement';
	 	$this->view = true;
        parent::__construct();
   
        

   }
   	public static function getPath($id_category, $path = '', $linkOntheLastItem = false, $categoryType = 'products')
	{
		global $link, $cookie;

		if ($id_category == 1)
			return '<span class="navigation_end">'.$path.'</span>';

		$pipe = htmlentities(Configuration::get('PS_NAVIGATION_PIPE'), ENT_QUOTES, 'UTF-8');
		if (empty($pipe))
			$pipe = '>';

		$fullPath = '';
		if ($categoryType == 'products')
		{
			$category = Db::getInstance()->getRow('
			SELECT nleft, nright
			FROM '._DB_PREFIX_.'category
			WHERE id_category = '.(int)$id_category);

			if (isset($category['nleft']))
			{
				$categories = Db::getInstance()->ExecuteS('
				SELECT c.id_category, cl.name, cl.link_rewrite
				FROM '._DB_PREFIX_.'category c
				LEFT JOIN '._DB_PREFIX_.'category_lang cl ON (cl.id_category = c.id_category)
				WHERE c.nleft <= '.(int)$category['nleft'].' AND c.nright >= '.(int)$category['nright'].' AND cl.id_lang = '.(int)$cookie->id_lang.' AND c.id_category != 1
				ORDER BY c.nleft ASC');

				$n = 1;
				$nCategories = count($categories);
				foreach ($categories as $category)
					$fullPath .=''.
						//$n < $nCategories || $linkOntheLastItem) ? '<a href="/adminka/index.php?tab=AdminCatalog&id_category='.$category['id_category'].'&viewcategory&token=" title="'.htmlentities($category['name'], ENT_QUOTES, 'UTF-8').'">' : '').
						htmlentities($category['name'], ENT_NOQUOTES, 'UTF-8').
						//(($n < $nCategories || $linkOntheLastItem) ? '</a>' : '').
						(($n++ != $nCategories || !empty($path)) ? '<span class="navigation-pipe">'.$pipe.'</span>' : '');

				return $fullPath.$path;
			}
		}
		
	}
   	
    public function getProductsDetail($id)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'order_detail` od
		WHERE od.`id_order` = '.(int)$id);
	}
   
    
   	public function postProcess()
	{
	  
      
       global $link, $cookie;
       if(isset($_POST['orderBox'])){
       $orderProd = array();
       $listProd  = array();
       
       $orderBox = Tools::getValue('orderBox');
        
        
        
        foreach($orderBox as $order){
            
            $orderProd[] = $this->getProductsDetail($order);
        
        }
        foreach($orderProd as $orders){
          foreach($orders as $items){
             $listProd[] = $items;
          }
        }
        

       
      

      foreach($listProd as $prod){                          
        
        $ProductCategory = Product::getProductCategories($prod['product_id']);
                                    
        $image      = Image::getImages(6,$prod['product_id']);
        $imageObj   = new Image($image[0]['id_image']);
        
        $imageSmall = isset($image[0]['id_image']) ? __PS_BASE_URI__._PS_PROD_IMG_.$imageObj->getExistingImgPath().'-small.jpg' : '#';
        $imageBig   = isset($image[0]['id_image']) ? __PS_BASE_URI__._PS_PROD_IMG_.$imageObj->getExistingImgPath().'-thickbox.jpg' : '#';

        $reference       = $prod['product_reference'];
        $reference_supp  = $prod['product_supplier_reference'];
        //$newProd = 
        $nameProduct     = $prod['product_name'];
        $quantityOrder   = $prod['product_quantity'];
        $stokProduct = Product::getQuantity($prod['product_id']);
        
        
        if(key_exists($prod['product_id'],$productData[$ProductCategory[0]])){
            $productData[$ProductCategory[0]][$prod['product_id']]['quantity_order'] += $quantityOrder;
        }else{
              $productData[$ProductCategory[0]][$prod['product_id']] = array('img_small' => $imageSmall,
                                                  'img_big'   =>$imageBig,
                                                  'reference' =>$reference,
                                                  'reference_supp'=>$reference_supp,
                                                  'name_product' =>$nameProduct,
                                                  'quantity_order' =>$quantityOrder,
                                                  'stok_product' =>$stokProduct,
                                                  );
        
        }
      
      }
        
        
      
        
        
        $categoryInfo  = Category::getHomeCategories(6); 
        $categoryInfoChilden = $categoryInfo;
        foreach($categoryInfoChilden as $newCat){
            
            $nCat[][] =  $newCat;
            
            
        }
        foreach($nCat as $kes=>$values){
            foreach($values as $nKey=>$nItem){
                $cCat =   Category::getChildren($nItem['id_category'],6); 
                if(!empty($cCat)){
                  foreach($cCat as $ukey=>$items){  
                   $sCat =   Category::getChildren($items['id_category'],6); 
                   if(!empty($sCat)){
                   foreach($sCat as $itCat){
                    $cCat[] = $itCat;
                    }
                   }
                 }               
                    
                foreach($cCat as $inCat)    
                $nCat[$kes][] = $inCat;
                }
            }
         
        }
        
        
        //print_r($nCat);
        //exit();     
        $prodAllData = $nCat;
        foreach($prodAllData as $keys => $prodCat){
          foreach($prodCat as $key => $values){ 
          
          $prodAllData[$keys][$key]['product'] = $productData[$values['id_category']];
          $prodAllData[$keys][$key]['br'] = $this->getPath((int)$values['id_category']);
                
                 //if(key_exists($key,$productData)){
                    //$br =  $this->getPath((int)$key);
                    //$prodAllData[$keys][$key]['infos']['br'] = $br;
                    //$prodAllData[$keys][$key]['product'] = $productData[$key];
                    
                    
                 //}
             }
        }
        
        //print_r($prodAllData);
        //exit();
         $_SESSION['dateProd'] = $prodAllData;
    
          $this->displayForm($prodAllData);
       }
       if(isset($_SESSION['dateProd']) and is_array($_SESSION['dateProd']) and !isset($_POST['orderBox'])){
           
           $this->displayForm($_SESSION['dateProd']);
       
       }
       //echo 111111;
	}
       
    
    public function displayForm($data)
	{
	   global $link, $cookie;
       
       foreach($data as $cat){
         foreach($cat as $key=>$catProd){
           if(is_array($catProd['product'])){
       ?>
	   <style>
        .min{
            width: 430px;
            
        }
        .cat_bar{
            margin-bottom: -5px;
            border-bottom: none;
        }
       
       </style>
       <link href="/css/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" media="screen" />
                        <script type="text/javascript" src="/js/jquery/jquery.fancybox-1.3.4.js"></script>
                        <script type="text/javascript">
                        
            $(document).ready(function() {
                $(".img_at").fancybox();
            });
            </script>
      
		<table style="margin-bottom: 30px;margin-top: 0;border-top:none ;">
			<tr>
				<td>
				   <div class="cat_bar">Главная > <?=$catProd['br']?> </div>
				</td>
			</tr>
			<tr>
				<td>
			<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
			<script type="text/javascript">
				var token = '060b8115e7fa7a44faaa831d8dc32027';
				var come_from = 'product';
				var alternate = '0';
			</script>
			<script type="text/javascript" src="../js/admin-dnd.js"></script>
			<table id="product" class="table tableDnD" cellpadding="0" cellspacing="0">
			<thead>
				<tr class="nodrag nodrop">
							
    	              <th >Фото	<br /></th>   
                      <th>Артикул товара <br /></th>
                      <th>Артикул поставщика<br /></th>	
             	      <th>Название товара<br /></th>	
                      <th>Количество<br />
                      <a href="/adminka/index.php?tab=AdminAssembly&cat=<?=$key?>&Orderway=desc&token=<?=Tools::getValue('token');?>"><img border="0" src="../img/admin/down.gif" /></a>
                      <a href="/adminka/index.php?tab=AdminAssembly&cat=<?=$key?>&Orderway=asc&token=<?=Tools::getValue('token');?>"><img border="0" src="../img/admin/up.gif" /></a></th>
                      </th>
                  	  <th >Склад<br /></th>		
                     </tr>
		
			</thead>
            
            
            <?php  
            
            if(!empty($_GET['cat']) and $_GET['cat'] == $key){
                
            switch ($_GET['Orderway']) {
            case 'desc':
                 usort($catProd['product'], function($a, $b){
                    return ($a['quantity_order'] - $b['quantity_order']);
                 });
                break;
            case 'asc':
                usort($catProd['product'], function($a, $b){
                    return -($a['quantity_order'] - $b['quantity_order']);
                 });
                break;
      
        }
      }else{
        usort($catProd['product'], function($a, $b){
                    return -($a['quantity_order'] - $b['quantity_order']);
                 });
      }
            
              foreach($catProd['product'] as $product){    ?>
                <tr>
					<td  class=" center"><a href="<?=$product['img_big']?>" class="img_at"><img src="<?=$product['img_small']?>" alt="" class="imgm" /></a></td>
					<td  class="center"><?=$product['reference']?></td>
					<td  class="center"><?=$product['reference_supp']?></td>
   		            <td  class="min "><?=$product['name_product']?></td>
					<td  class="center"><?=$product['quantity_order']?></td>
					<td  class="center"><?=$product['stok_product']?></td>
			</tr>
            <?php  }?>
           </table>
				</td>
			</tr>
		</table>
	
	
       
	   
    <?php
        }   
	   }
      }
    
    }
    
    
    public function display()
	{
	   
       
	
	}
   
    
}	