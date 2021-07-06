<?php 
/**
 * @author fatory
 * @copyright 2014
 * @email 
 */

 //ini_set("display_errors",1);
 //error_reporting(E_ALL);
class AdminSelections extends AdminTab
{
	public function __construct()
	{
		global $cookie;
        $this->optionTitle = 'Выборки.';
	 	$this->table = 'Selections';
	 	$this->className = 'Selections';
	 	$this->view = true;
        parent::__construct();
        $productAdd = array();
        global $productAdd;
        

   }
   
   
   
  public function displayForm($isMainTab = true)
	{
		global $currentIndex, $cookie;

	?>
    <script>
     $(document).ready(function() {
        var type_s = $('#type_s').val();
        //if($('type_s').value()=='')
        if(type_s == 'reorder'){
            $('#reordes_block').show();
            $("#ftable").attr("class", "width7");
        }
$("#type_s").change(function(){ 
if($("#type_s").val() == 'reorder' ){ 
  $('#reordes_block').show();
  $("#ftable").attr("class", "width7");
}else{
    $('#reordes_block').hide();
    $("#ftable").attr("class", "width3");
}
}); 
      
      
      
    });
    </script>
    
    
    
    <?php
    
    $manufacturer = Manufacturer::getManufacturers();
    $supplier = Supplier::getSuppliers();
    //print_r($manufacturer);
    if($cookie->prodActive == 1){
                        $pActive = 'checked="checked"';
                    }else{
                        $pActive = 'checked="checked"';
                    }
             
 echo '
       <fieldset class="width3" id="ftable"><legend><img src="../img/admin/translation.gif" />Выберите действие</legend>
			<form method="POST" action="" >
				<select name="type" id="type_s" style="float:left; margin-right:5px;">
                <option value="reorder">Дозаказ&nbsp;</option>
                <option value="not_issued">Не выданные&nbsp;</option>
                <option value="shipped">Отправленные&nbsp;</option>
                <option value="products_individually">Товары с индивидуально наценкой&nbsp;</option>
                <option value="products_subscribed">Товары, на которые подписаны покупатели&nbsp;</option>
                </select>
                <span id="reordes_block" style="margin-left: 5px;margin-top: -5px;display: none;">  
                           
                <select name="prodman" id="prodpost" style="margin-left: 5px;" >
                <option value="0">Выберите Производителя</option>';
                 
                 foreach($manufacturer as $items){
                    
                    if($cookie->manufact == $items['id_manufacturer']){
                        $check = 'selected';
                    }else{
                        $check = ' ';
                    }
                    
                    echo '<option '.$check.' value="'.$items['id_manufacturer'].'">'.$items['name'].'</option>';
                    
                 }
                
                echo '</select>
                
                <select name="prodsupp" style="margin-left: 5px;">
                <option value="0">Выберите Поставщика</option>';
                 foreach($supplier as $items){
                      if($cookie->supp == $items['id_supplier']){
                        $checks = 'selected';
                    }else{
                        $checks = ' ';
                    }
                    echo '<option '.$checks.' value="'.$items['id_supplier'].'">'.$items['name'].'</option>';
                    
                 }
                echo '</select>
                <span style="margin-left: 5px;">
                <input name="prod_active" '.$pActive.' type="checkbox" value="1" /> Убрать не активные
                </span>
                </span>
					<input type="submit" name="tablegenerate" class="button" value="Генерировать" />
                    
               </form>
     </fieldset>
     <br>
     <br>
       
       ';

		return parent::displayForm();
	}
   
   
   	public function display()
	{
		
      
        
   
	}
    
   	public function postProcess()
	{
	
    	global $currentIndex ,$cookie;
          
       $this->displayForm();
       
       if(Tools::isSubmit('tablegenerate')){
          print_r($_POST);
          
          $type = $_POST['type'];
          if($type == 'reorder'){
            if(isset($_POST['prod_active']) and $_POST['prod_active'] == 1){
                
                $cookie->prodActive = 1;
            }else{
                $cookie->prodActive = 0;
            }
        
            $cookie->manufact =   $_POST['prodman'];
            $cookie->supp =   $_POST['prodsupp'];
            
            ///print_r($cookie);
          }
          
          //exit();
          switch ($type) {
            case 'reorder':
                header("Location: $currentIndex&type=reorder&order_by=reorderdesc&token=$this->token");
                break;
            case 'not_issued':
               header("Location: $currentIndex&type=not_issued&token=$this->token");
                break;
            case 'shipped':
               header("Location: $currentIndex&type=shipped&token=$this->token");
                break;
            case 'products_individually':
               header("Location: $currentIndex&type=products_individually&token=$this->token");
                break;
           case 'products_subscribed':
               header("Location: $currentIndex&type=products_subscribed&token=$this->token");
                break;
            }
         
        }
        if(Tools::isSubmit('submitFilterSelected')){
            
           
           $cookie->paginationSelected = Tools::getValue('pagination');
        }
        
        
        if(Tools::getValue('type') == 'products_subscribed'){
            
            $orderByQuery = '';
    $orderBy = Tools::getValue('order_by');
          switch ($orderBy) {
            case 'artdesc':
                $orderByQuery = 'ORDER BY p.`reference`  DESC';
                break;
            case 'atrasc':
               $orderByQuery = 'ORDER BY  p.`reference`  ASC';
                break;
            case 'namedesc':
                $orderByQuery = 'ORDER BY pl.`name`  DESC';
                break;
            case 'nameasc':
                $orderByQuery = 'ORDER BY pl.`name`  ASC';
                break;
            case 'quantity_ordereddesc':
                $orderByQuery = 'ORDER BY p.`quantity_ordered`  DESC';
                break;
            case 'quantity_orderedasc':
                $orderByQuery = 'ORDER BY p.`quantity_ordered`  ASC';
                break;
            case 'marcupdesc':
                $orderByQuery = 'ORDER BY p.`markup`  DESC';
                break; 
            case 'marcupasc':
                $orderByQuery = 'ORDER BY p.`markup`  ASC';
                break;  
             case 'quantitydesc':
                $orderByQuery = 'ORDER BY p.`quantity`  DESC';
                break; 
            case 'quantityasc':
                $orderByQuery = 'ORDER BY p.`quantity`  ASC';
                break;
            case 'quantityordereddesc':
                $orderByQuery = 'ORDER BY p.`wholesale_price`  DESC';
                break; 
            case 'quantityorderedasc':
                $orderByQuery = 'ORDER BY p.`wholesale_price`  ASC';
                break;       
            }
    
      
    function pagination($total, $per_page, $num_links, $start_row, $url=''){
        
      echo '
      <style>
      div.wrapPaging {padding: 6px 0px 6px 16px; font-family: Arial, sans-serif; font-size: 14px; clear: both;}
        div.wrapPaging a, div.wrapPaging span {margin: 0 1px; padding: 2px 5px; line-height: 26px; text-decoration: none;}
        div.wrapPaging a {background: none; color: #025A9C !important; text-decoration: underline; font-size: 14px;}
        div.wrapPaging span {background: #E8E9EC; color: #000;}
        div.wrapPaging span.ways {background: none; font-size: 15px; color: #999;}
        div.wrapPaging span.ways span {background: none; color: #999;}
        div.wrapPaging span.ways a {font-size: 15px;}
        div.wrapPaging span.divider {color: #999;}
        div.wrapPaging i {font-family: Times, sans-serif; margin: 0 5px 0 0;}
        div.wrapPaging a:hover {color: #ff0000;}
        div.wrapPaging strong {margin: 0 15px 0 0; font-size: 16px; font-weight: bold; color: #000;}
      </style>
      
      ';  
    //Получаем общее число страниц
    $num_pages = ceil($total/$per_page);

    if ($num_pages == 1) return '';

    //Получаем количество элементов на страницы
    $cur_page = $start_row;

    //Если количество элементов на страницы больше чем общее число элементов
    // то текущая страница будет равна последней
    if ($cur_page > $total){
        $cur_page = ($num_pages - 1) * $per_page;
    }

    //Получаем номер текущей страницы
    $cur_page = floor(($cur_page/$per_page) + 1);

    //Получаем номер стартовой страницы выводимой в пейджинге
    $start = (($cur_page - $num_links) > 0) ? $cur_page - $num_links : 0;
    //Получаем номер последней страницы выводимой в пейджинге
    $end   = (($cur_page + $num_links) < $num_pages) ? $cur_page + $num_links : $num_pages;

    $output = '<span class="ways">';

    //Формируем ссылку на предыдущую страницу
    if  ($cur_page != 1){
        $i = $start_row - $per_page;
        if ($i <= 0) $i = 0;
        $output .= '<i>←</i><a href="'.$url.'&page='.$i.'">Предыдущая</a>';
    }
    else{
        $output .='<span><i>←</i>Предыдущая</span>';
    }
    
    $output .= '<span class="divider">|</span>';

    //Формируем ссылку на следующую страницу
    if ($cur_page < $num_pages){
        $output .= '<a href="'.$url.'&page='.($cur_page * $per_page).'">Следующая</a><i>→</i>';
    }
    else{
        $output .='<span>Следующая<i>→</i></span>';
    }

    $output .= '</span><br/>';

    //Формируем ссылку на первую страницу
    if  ($cur_page > ($num_links + 1)){
        $output .= '<a href="'.$url.'" title="Первая"><img src="images/left_active.png"></a>';
    }

    // Формируем список страниц с учетом стартовой и последней страницы   >
        for ($loop = $start; $loop <= $end; $loop++){
        $i = ($loop * $per_page) - $per_page;

        if ($i >= 0)
        {
            if ($cur_page == $loop)
            {
               //Текущая страница
               $output .= '<span>'.$loop.'</span>'; 
            }
            else
            {

               $n = ($i == 0) ? '' : $i;

               $output .= '<a href="'.$url.'&page='.$n.'">'.$loop.'</a>';
            }
        }
    }

    //Формируем ссылку на последнюю страницу
    if (($cur_page + $num_links) < $num_pages){
        $i = (($num_pages * $per_page) - $per_page);
        $output .= '<a href="'.$url.'&page='.$i.'" title="Последняя"><img src="images/right_active.png"></a>';
    }

    return '<div class="wrapPaging"><strong>Страницы:</strong>'.$output.'</div>';
}
        
    
 
      $sqlcount ='SELECT COUNT(*) AS `count`
                  FROM `'._DB_PREFIX_.'mailalert_customer_oos`';
 
       
      $ProductCount = Db::getInstance()->ExecuteS($sqlcount);              
      $ProductCount = $ProductCount[0]['count'];                                          
      $sortBy = Tools::getValue('sort_by');
        $total = $ProductCount;
        if(isset($cookie->paginationSelected) and !empty($cookie->paginationSelected)){
          $per_page = $cookie->paginationSelected;  
        }else{
          $per_page = 20;
        }
        
        $num_page = 5;
        $start_row = (!empty($_GET['page']))? intval($_GET['page']): 0;
        if(isset($orderBy) and !empty($orderBy)){
           $url = $currentIndex.'&type=products_subscribed&order_by='.$orderBy.'&token='.$this->token; 
        }elseif(isset($sortBy) and !empty($sortBy)){
           $url = $currentIndex.'&type=products_subscribed&sort_by='.$sortBy.'&token='.$this->token; 
        }else{
          $url = $currentIndex.'&type=products_subscribed&token='.$this->token; 
        }
        
        
        if($start_row < 0) $start_row = 0;
        if($start_row > $total) $start_row = $total;
      
      
     
      
                                          $sql ='SELECT DISTINCT 
                                                        p.`markup`,
                                                        p.`id_product`,
                                                        p.`reference`,
                                                        p.`id_product`,
                                                        p.`price`,
                                                        p.`wholesale_price`,
                                                        p.`quantity_ordered`,
                                                        p.`quantity`,
                                                        pl.`name`     
                                                 FROM `ps_product` p
                                                 LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = "'.$cookie->id_lang.'"  )
                                                 LEFT JOIN `'._DB_PREFIX_.'mailalert_customer_oos` al ON (p.`id_product` = al.`id_product` )
                                                 WHERE p.`id_product` = al.`id_product`
                                                 '.$orderByQuery.'
                                                 LIMIT '.$start_row.','.$per_page;
    
    $ProductQuery = Db::getInstance()->ExecuteS($sql);
    
     

    //echo "<pre>";
    //print_r($ProductQuery);
    //echo "<pre>";
    

    foreach($ProductQuery as $item){
        
    
    $productAllData = new Product($item['id_product'], true,$cookie->id_lang);
        
            $image = array();
	        $image = Db::getInstance()->getRow('
                								SELECT  id_image
                								FROM ps_image
                								WHERE id_product = '.(int)($item['id_product']).' AND cover = 1');

          	$imageObj = new Image($image['id_image']);
            $p_image_temp = isset($image['id_image']) ? __PS_BASE_URI__._PS_PROD_IMG_.$imageObj->getExistingImgPath().'-small.jpg' : '#';
           //echo   $productAllData->link_rewrite;       
            $p_image = $p_image_temp; 
    
      
      
    
    $podsubsc =  Db::getInstance()->getValue('
		SELECT COUNT(id_product)
		FROM `'._DB_PREFIX_.'mailalert_customer_oos`
		WHERE `id_product` = '.(int)$item['id_product'].'');

        
    
    $productMarkup[] = array(     'img' =>$p_image,
                                  'articul' =>$item['reference'],
                                  'name' =>$item['name'],
                                  'id_product' =>$item['id_product'],
                                  'id_category' =>$productAllData->id_category_default,
                                  'marcup' =>$marcup_percent['markup'],
                                  'price' => $item['price'],
                                  'price_w' => $item['wholesale_price'],
                                  'marcup_percent' =>$item['markup'],
                                  'quantity_ordered' =>$item['quantity_ordered'],
                                  'quantity' =>$item['quantity'],
                                  'numsubscribe' =>$podsubsc,
                                  
                                  
                                  
                                  );
                                
       }

       $tokenCatalog = Tools::getAdminToken('AdminCatalog'.(int)(Tab::getIdFromClassName('AdminCatalog')).(int)$cookie->id_employee);
       ?>
       
    <h1>Товары. На которые подписаны покупатели</h1>
           <table>
			<tbody><tr>
				<td style="vertical-align: bottom;">
                <?php 
    
                echo pagination($total,$per_page,$num_page,$start_row,$url);?>
				<form action="" method="POST">
                <span style="float: left;"> Показывать по
				
                    	<select name="pagination">
                        <option <?php if($cookie->paginationSelected==20){echo 'selected="selected"';} ?>  value="20">20</option>
                        <option <?php if($cookie->paginationSelected==50){echo 'selected="selected"';} ?>  value="50">50</option>
                        <option <?php if($cookie->paginationSelected==100){echo 'selected="selected"';} ?>  value="100">100</option>
                        <option <?php if($cookie->paginationSelected==300){echo 'selected="selected"';} ?>  value="300">300</option>
						</select>
					</span>
					<span style="float: right;">
						<input type="submit" name="submitResetcategory" value="Сбросить" class="button" />
						<input type="submit" name="submitFilterSelected" value="Фильтр" class="button" />
					</span>
                   	
					<span class="clear"></span> 
                    </form>
				</td>
			</tr>
			<tr>
				<td>
                <table class="table" cellpadding="0" cellspacing="0">
			<thead>
		        	<tr class="nodrag nodrop">
	
                        <th style="width: 90px" >Картинка<br />
                        </th>		
                        <th style="width: 150px">Артикул<br />
                         <a href="<?=$currentIndex?>&type=products_subscribed&order_by=artdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_subscribed&order_by=artasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 340px">Название<br />
                         <a href="<?=$currentIndex?>&type=products_subscribed&order_by=namedesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_subscribed&order_by=nameasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Цена закупки<br />
                         <a href="<?=$currentIndex?>&type=products_subscribed&order_by=quantityordereddesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_subscribed&order_by=quantityorderedasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Кол-во товара в заказе<br />
                         <a href="<?=$currentIndex?>&type=products_subscribed&order_by=quantity_ordereddesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_subscribed&order_by=quantity_orderedasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                  	   <th style="width: 150px">Кол-во на складе<br />
                         <a href="<?=$currentIndex?>&type=products_subscribed&order_by=quantitydesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_subscribed&order_by=quantityasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>
                        <th style="width: 150px">Кол-во подписок на товар<br />
                         <a href="<?=$currentIndex?>&type=products_subscribed&sort_by=subdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_subscribed&sort_by=subasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th> 	
                    </tr>
			
			
			</thead>
            <tbody>
      <script type="text/javascript" src="/js/clipboard.min.js"></script>
            
      <?php   
      
         if(!empty($sortBy)){
            switch ($sortBy) {
            case 'subdesc':
                 usort($productMarkup, function($a, $b){
                    return ($a['numsubscribe'] - $b['numsubscribe']);
                 });
                break;
            case 'subasc':
                usort($productMarkup, function($a, $b){
                    return -($a['numsubscribe'] - $b['numsubscribe']);
                 });
                break;
      
        }
      }
      foreach($productMarkup as $key=>$value){
           
        ?>           
   <tr class="alt_row" style="background-color: #FFDD99">
					<td class=" center"><img src="<?=$value['img']?>" /> </td>
					<td class="pointer"><div style="position:relative"><a class="copy-description" title="<?php echo $value['articul'];?>"><?php echo $value['articul'];?></a></div></td>
					<td class="pointer "><b><a target="_blank" href="/adminka/index.php?tab=AdminCatalog&id_category=<?=$value['id_category']?>&id_product=<?=$value['id_product']?>&updateproduct&token=<?=$tokenCatalog?>"><?php echo $value['name'];?></a></b></td>
					<td class=""><?=$value['price_w']?></td>
					<td class=""><?=$value['quantity_ordered']?></td>
                    <td class=""><?=$value['quantity']?></td>
					<td class=""><?=$value['numsubscribe']?></td>
</tr>
           <?php } ?> 
            </tbody>
            
            </table>
            
            
				</td>
			</tr>
		</tbody>
        </table>
		
		</form>
                <button class="btn">Copy</button>
         <script>
                $('.copy-description').mouseover(function() {
                    var elem = $(this);
                    elem.removeClass('tooltipped');
                    elem.removeClass('tooltipped-s');
                    
                 });
                 $('.copy-description').click(function(){
                   //  $('.btn').attr('data-clipboard-target','d');
                          var elem = $(this);
                          var copyText = elem.attr('title');
                                  // var copyText = 'tg';
                     var clipboard = new Clipboard('.btn', {
                         text: function() {
                             return copyText;
                         }
                     });
                         clipboard.on('success', function(e) {
                         elem.addClass('tooltipped');
                         elem.addClass('tooltipped-s');
                         console.log(e);
                        });

                         clipboard.on('error', function(e) {
                        console.log(e);
                        });
                     $('.btn').trigger('click');
                     
                 
                 });
</script>  
        <?php
            
            
            
            
        }
        
   if(Tools::getValue('type') == 'reorder'){
    
   
     function pagination($total, $per_page, $num_links, $start_row, $url=''){
        
      echo '
      <style>
      div.wrapPaging {padding: 6px 0px 6px 16px; font-family: Arial, sans-serif; font-size: 14px; clear: both;}
        div.wrapPaging a, div.wrapPaging span {margin: 0 1px; padding: 2px 5px; line-height: 26px; text-decoration: none;}
        div.wrapPaging a {background: none; color: #025A9C !important; text-decoration: underline; font-size: 14px;}
        div.wrapPaging span {background: #E8E9EC; color: #000;}
        div.wrapPaging span.ways {background: none; font-size: 15px; color: #999;}
        div.wrapPaging span.ways span {background: none; color: #999;}
        div.wrapPaging span.ways a {font-size: 15px;}
        div.wrapPaging span.divider {color: #999;}
        div.wrapPaging i {font-family: Times, sans-serif; margin: 0 5px 0 0;}
        div.wrapPaging a:hover {color: #ff0000;}
        div.wrapPaging strong {margin: 0 15px 0 0; font-size: 16px; font-weight: bold; color: #000;}
      </style>
      
      ';  
    //Получаем общее число страниц
    $num_pages = ceil($total/$per_page);

    if ($num_pages == 1) return '';

    //Получаем количество элементов на страницы
    $cur_page = $start_row;

    //Если количество элементов на страницы больше чем общее число элементов
    // то текущая страница будет равна последней
    if ($cur_page > $total){
        $cur_page = ($num_pages - 1) * $per_page;
    }

    //Получаем номер текущей страницы
    $cur_page = floor(($cur_page/$per_page) + 1);

    //Получаем номер стартовой страницы выводимой в пейджинге
    $start = (($cur_page - $num_links) > 0) ? $cur_page - $num_links : 0;
    //Получаем номер последней страницы выводимой в пейджинге
    $end   = (($cur_page + $num_links) < $num_pages) ? $cur_page + $num_links : $num_pages;

    $output = '<span class="ways">';

    //Формируем ссылку на предыдущую страницу
    if  ($cur_page != 1){
        $i = $start_row - $per_page;
        if ($i <= 0) $i = 0;
        $output .= '<i>←</i><a href="'.$url.'&page='.$i.'">Предыдущая</a>';
    }
    else{
        $output .='<span><i>←</i>Предыдущая</span>';
    }
    
    $output .= '<span class="divider">|</span>';

    //Формируем ссылку на следующую страницу
    if ($cur_page < $num_pages){
        $output .= '<a href="'.$url.'&page='.($cur_page * $per_page).'">Следующая</a><i>→</i>';
    }
    else{
        $output .='<span>Следующая<i>→</i></span>';
    }

    $output .= '</span><br/>';

    //Формируем ссылку на первую страницу
    if  ($cur_page > ($num_links + 1)){
        $output .= '<a href="'.$url.'" title="Первая"><img src="images/left_active.png"></a>';
    }

    // Формируем список страниц с учетом стартовой и последней страницы   >
        for ($loop = $start; $loop <= $end; $loop++){
        $i = ($loop * $per_page) - $per_page;

        if ($i >= 0)
        {
            if ($cur_page == $loop)
            {
               //Текущая страница
               $output .= '<span>'.$loop.'</span>'; 
            }
            else
            {

               $n = ($i == 0) ? '' : $i;

               $output .= '<a href="'.$url.'&page='.$n.'">'.$loop.'</a>';
            }
        }
    }

    //Формируем ссылку на последнюю страницу
    if (($cur_page + $num_links) < $num_pages){
        $i = (($num_pages * $per_page) - $per_page);
        $output .= '<a href="'.$url.'&page='.$i.'" title="Последняя"><img src="images/right_active.png"></a>';
    }

    return '<div class="wrapPaging"><strong>Страницы:</strong>'.$output.'</div>';
}

     
      
         $orderByQuery = '';
    $orderBy = Tools::getValue('order_by');
          switch ($orderBy) {
            case 'artdesc':
                $orderByQuery = 'ORDER BY p.`reference`  DESC';
                break;
            case 'atrsc':
               $orderByQuery = 'ORDER BY  p.`reference`  ASC';
                break;
            case 'namedesc':
                $orderByQuery = 'ORDER BY pl.`name`  DESC';
                break;
            case 'nameasc':
                $orderByQuery = 'ORDER BY pl.`name`  ASC';
                break;
            case 'ordereddesc':
                $orderByQuery = 'ORDER BY p.`quantity_ordered` DESC';
                break;
            case 'orderedasc':
                $orderByQuery = 'ORDER BY p.`quantity_ordered`  ASC';
                break;
            case 'qtydesc':
                $orderByQuery = 'ORDER BY p.`quantity`  DESC';
                break; 
            case 'qtyasc':
                $orderByQuery = 'ORDER BY p.`quantity`  ASC';
                break;
             case 'reorderdesc':
                $orderByQuery = 'ORDER BY p.`reorder`  DESC';
                break; 
            case 'reorderasc':
                $orderByQuery = 'ORDER BY p.`reorder`  ASC';
                break;        
            default:
                $orderByQuery = 'ORDER BY p.`reorder`  DESC';
            }
    
      
      $and1 = '';
      $and2 = '';
      $manufacture = '';
      $manufactureC = '';
      if($cookie->manufact != 0){   
      $manufacture = 'p.id_manufacturer ='.$cookie->manufact;
      $manufactureC = 'id_manufacturer ='.$cookie->manufact;
      $and1 = "AND";
      }
      $supplie = '';
      $supplieC = '';
      if($cookie->supp != 0){
        $and2 = "AND";
        if(!empty($and1)){            
            $supplie = $and1.' p.id_supplier ='.$cookie->supp;
            $supplieC = $and1.' id_supplier ='.$cookie->supp;
        }else{
            $supplie = 'p.id_supplier ='.$cookie->supp;
            $supplieC = 'id_supplier ='.$cookie->supp;
        }
      
      }
      $prodActives = '';
      $prodActivesC = '';
      if($cookie->prodActive == 1){
        if(!empty($and1) or !empty($and2)){
           $prodActives = 'AND p.active = 1'; 
           $prodActivesC = 'AND active = 1'; 
        }else{
           $prodActives = 'p.active = 1'; 
           $prodActivesC = 'active = 1'; 
        }
       
      }
      $where = '';
      if(!empty($manufacture) or !empty($supplie) or !empty($prodActives)){
         $where = 'WHERE';
      }
      
      
      $sqlcount ='SELECT COUNT(*) AS `count`
                  FROM `ps_product`
                   '.$where.'
                   '.$manufactureC.'
                   '.$supplieC.'
                   '.$prodActivesC.'
                  
                  ';  
       
      $ProductCount = Db::getInstance()->ExecuteS($sqlcount);              
      $ProductCount = $ProductCount[0]['count'];                                          
      $sortBy = Tools::getValue('sort_by');
        $total = $ProductCount;
        if(isset($cookie->paginationSelected) and !empty($cookie->paginationSelected)){
          $per_page = $cookie->paginationSelected;  
        }else{
          $per_page = 20;
        }
        $num_page = 5;
        $start_row = (!empty($_GET['page']))? intval($_GET['page']): 0;
        if(isset($orderBy) and !empty($orderBy)){
           $url = $currentIndex.'&type=reorder&order_by='.$orderBy.'&token='.$this->token; 
        }elseif(isset($sortBy) and !empty($sortBy)){
           $url = $currentIndex.'&type=reorder&sort_by='.$sortBy.'&token='.$this->token; 
        }else{
          $url = $currentIndex.'&type=reorder&token='.$this->token; 
        }
        
        
        if($start_row < 0) $start_row = 0;
        if($start_row > $total) $start_row = $total;
      
       $sqlForUp ='SELECT p.*,pl.`name`
                   FROM `ps_product` p
                   LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = "'.$cookie->id_lang.'")';
    
       $ProductQueryForUp = Db::getInstance()->ExecuteS($sqlForUp);
    
        foreach($ProductQueryForUp as $item){
         
         
         $monthly_sales = Product::getAverageMonthlySales($item['id_product']);
                    if((int)$item['quantity_ordered'] < 0){
                        $qty_orderednum = 0; 
                    }else{
                        $qty_orderednum = $item['quantity_ordered'];
                    }
                    $kratnost = $item['packed'];
                    
                    if(empty($kratnost) or $kratnost == 0){
                        $kratnost = 1;
                    }
                    
                    $qtynum = $item['quantity'];//*$kratnost;
                    
                    $kreserve = Configuration::get('PS_SHOP_KRESERVE');
                    $reorder =  ($monthly_sales*$kreserve) - ($qty_orderednum + $qtynum);
                    
                    
             Db::getInstance()->Execute('UPDATE `ps_product` 
                                         SET     `reorder` = "' .$reorder . '"
                                         WHERE `id_product` = "' . $item['id_product'].'"');        
                                        
        }
 
      
      
      
                                          $sql ='SELECT p.*,pl.`name`
                                                 FROM `ps_product` p
                                                 LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = "'.$cookie->id_lang.'"  )
                                                 '.$where.'
                                                 '.$manufacture.'
                                                 '.$supplie.'
                                                 '.$prodActives.'
                                                 '.$orderByQuery.'
                                                 LIMIT '.$start_row.','.$per_page;
    
    $ProductQuery = Db::getInstance()->ExecuteS($sql);
   
    foreach($ProductQuery as $item){
        
    
    $productAllData = new Product($item['id_product'], true,$cookie->id_lang);
        
            $image = array();
	        $image = Db::getInstance()->getRow('
                								SELECT  id_image
                								FROM ps_image
                								WHERE id_product = '.(int)($item['id_product']).' AND cover = 1');

          	$imageObj = new Image($image['id_image']);
            $p_image_temp = isset($image['id_image']) ? __PS_BASE_URI__._PS_PROD_IMG_.$imageObj->getExistingImgPath().'-small.jpg' : '#';
           //echo   $productAllData->link_rewrite;       
            $p_image = $p_image_temp; 
    
      
      
   // $marcup_percent =  Product::calculatePriceParams($item['wholesale_price'], $item['markup'], true);
            $monthly_sales = Product::getAverageMonthlySales($item['id_product']);
                    if((int)$item['quantity_ordered'] < 0){
                        $qty_orderednum = 0; 
                    }else{
                        $qty_orderednum = $item['quantity_ordered'];
                    }
                    $kratnost = $item['packed'];
                    
                    if(empty($kratnost) or $kratnost == 0){
                        $kratnost = 1;
                    }
                    
                    $qtynum = $item['quantity'];//*$kratnost;
                    
                    $kreserve = Configuration::get('PS_SHOP_KRESERVE');
                    $reorder =  ($monthly_sales*$kreserve) - ($qty_orderednum + $qtynum);
                    
                    
   
        
    $allordereds =  Db::getInstance()->ExecuteS('
                            		SELECT quantity
                            		FROM `'._DB_PREFIX_.'stock_mvt`
                            		WHERE `id_product` = '.(int)$item['id_product'].' and id_stock_mvt_reason = 3 ');
								
                                //print_r($allordereds);
                                $allordered = 0;
                                foreach($allordereds as $items){
                                    $allordered = $allordered + abs($items['quantity']);
                                }
                                
                                
                
  $podsubsc =  Db::getInstance()->getValue('
		SELECT COUNT(id_product)
		FROM `'._DB_PREFIX_.'mailalert_customer_oos`
		WHERE `id_product` = '.(int)$item['id_product'].'');
        

       $productMarkup[] = array(   'img' =>$p_image,
                                  'articul' =>$item['reference'],
                                  'name' =>$item['name'],
                                  'id_product' =>$item['id_product'],
                                  'id_category' =>$productAllData->id_category_default,
                                  'qty' =>$item['quantity'],
                                  'price' => $item['price'],
                                  'qty_ordered' =>$item['quantity_ordered'],
                                  'ordered' =>(int)$item['reorder'],
                                  'monthly_sales' =>$monthly_sales,
                                  'allordered' =>$allordered,
                                  'prodsubsc' =>$podsubsc
                                  
                                  
                                  ); 
   
    
                                
    }

       $tokenCatalog = Tools::getAdminToken('AdminCatalog'.(int)(Tab::getIdFromClassName('AdminCatalog')).(int)$cookie->id_employee);
       
//echo"<pre>";
 //  print_r($productMarkup);
  // echo"</pre>";
       ?>
      
    <h1>До заказ.</h1>
           <table>
			<tbody><tr>
				<td style="vertical-align: bottom;">
                <?php 
    
                echo pagination($total,$per_page,$num_page,$start_row,$url);?>
				<form action="" method="POST">
                <span style="float: left;"> Показывать по
				
                    	<select name="pagination">
                        <option <?php if($cookie->paginationSelected==20){echo 'selected="selected"';} ?>  value="20">20</option>
                        <option <?php if($cookie->paginationSelected==50){echo 'selected="selected"';} ?>  value="50">50</option>
                        <option <?php if($cookie->paginationSelected==100){echo 'selected="selected"';} ?>  value="100">100</option>
                        <option <?php if($cookie->paginationSelected==300){echo 'selected="selected"';} ?>  value="300">300</option>
						</select>
					</span>
					<span style="float: right;">
						<input type="submit" name="submitResetcategory" value="Сбросить" class="button" />
						<input type="submit" name="submitFilterSelected" value="Фильтр" class="button" />
					</span>
                   	
					<span class="clear"></span> 
                    </form>
				</td>
			</tr>
			<tr>
				<td>
                <table class="table" cellpadding="0" cellspacing="0">
			<thead>
		        	<tr class="nodrag nodrop">
	
                        <th style="width: 90px" >Картинка<br />
                        </th>		
                        <th style="width: 150px">Артикул<br />
                         <a href="<?=$currentIndex?>&type=reorder&order_by=artdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=reorder&order_by=artasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 340px">Название<br />
                         <a href="<?=$currentIndex?>&type=reorder&order_by=namedesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=reorder&order_by=nameasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Продано всего<br />
                         <a href="<?=$currentIndex?>&type=reorder&sort_by=soldonlydesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=reorder&sort_by=soldonlyasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Среднемесячные<br />
                         <a href="<?=$currentIndex?>&type=reorder&sort_by=monthly_salesdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=reorder&sort_by=monthly_salesasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>
                        <th style="width: 50px">Заказано<br />
                         <a href="<?=$currentIndex?>&type=reorder&order_by=ordereddesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=reorder&order_by=orderedasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 50px">Остаток<br />
                         <a href="<?=$currentIndex?>&type=reorder&order_by=qtydesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=reorder&order_by=qtyasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>
                        <th style="width: 50px">Дозаказ<br />
                         <a href="<?=$currentIndex?>&type=reorder&order_by=reorderdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=reorder&order_by=reorderasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>
                        <th style="width: 50px">Всего подписок<br />
                         <a href="<?=$currentIndex?>&type=reorder&sort_by=subdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=reorder&sort_by=subasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>			
                  	
                    </tr>
			
			
			</thead>
            <tbody>
            
           
                <script type="text/javascript" src="/js/clipboard.min.js"></script>
            
      <?php
         if(!empty($sortBy)){
            switch ($sortBy) {
            case 'soldonlydesc':
                 usort($productMarkup, function($a, $b){
                    return ($a['allordered'] - $b['allordered']);
                 });
                break;
            case 'soldonlyasc':
                usort($productMarkup, function($a, $b){
                    return -($a['allordered'] - $b['allordered']);
                 });
                break;
            case 'monthly_salesdesc':
                usort($productMarkup, function($a, $b){
                    return ($a['monthly_sales'] -$b['monthly_sales']);
                 });
                break;
            case 'monthly_salesasc':
                usort($productMarkup, function($a,$b){
                    return -($a['monthly_sales'] - $b['monthly_sales']);
                 });
                break;
            case 'subdesc':
                 usort($productMarkup, function($a, $b){
                    return ($a['prodsubsc'] -$b['prodsubsc']);
                 });
                break; 
            case 'subasc':
                 usort($productMarkup, function($a, $b){
                    return -($a['prodsubsc'] -$b['prodsubsc']);
                 });
                break;  
            
            }
            
            
         }
         
        
         foreach($productMarkup as $value){ ?>           
   <tr class="alt_row" style="background-color: #FFDD99">
					<td class="center"><img src="<?=$value['img']?>" /> </td>
					<td><div style="position:relative"><a class="pointer copy-description" title="<?php echo $value['articul'];?>"><?php echo $value['articul'];?></a></div></td>
					<td class="pointer "><b><a target="_blank" href="/adminka/index.php?tab=AdminCatalog&id_category=<?=$value['id_category']?>&id_product=<?=$value['id_product']?>&updateproduct&token=<?=$tokenCatalog?>"><?php echo $value['name'];?></a></b></td>
					<td class=""><?=$value['allordered']?></td>
					<td class=""><?=$value['monthly_sales']?> </td>
                    <td class=""><?=$value['qty_ordered']?> </td>
                    <td class=""><?=$value['qty']?> </td>
                    <td class=""><?=$value['ordered']?></td>
                    <td class=""><?=$value['prodsubsc']?></td>
</tr>
           <?php } ?> 
            </tbody>
            
            </table>
            
            
				</td>
			</tr>
		</tbody>
        </table>
		
		</form>
                <button style="display: none" class="btn">Copy</button>
             <script>
                 
                 
                 $('.copy-description').mouseover(function() {
                    var elem = $(this);
                    elem.removeClass('tooltipped');
                    elem.removeClass('tooltipped-s');
                    
                 });
                 $('.copy-description').click(function(){
                   //  $('.btn').attr('data-clipboard-target','d');
                          var elem = $(this);
                          var copyText = elem.attr('title');
                                  // var copyText = 'tg';
                     var clipboard = new Clipboard('.btn', {
                         text: function() {
                             return copyText;
                         }
                     });
                         clipboard.on('success', function(e) {
                         elem.addClass('tooltipped');
                         elem.addClass('tooltipped-s');
                         console.log(e);
                        });

                         clipboard.on('error', function(e) {
                        console.log(e);
                        });
                     $('.btn').trigger('click');
                     
                 
                 });

</script>  
        <?php
    
    
   
   
   }         
   if(Tools::getValue('type') == 'products_individually'){
    
    $orderByQuery = '';
    $orderBy = Tools::getValue('order_by');
          switch ($orderBy) {
            case 'artesc':
                $orderByQuery = 'ORDER BY p.`reference`  DESC';
                break;
            case 'atrsc':
               $orderByQuery = 'ORDER BY  p.`reference`  ASC';
                break;
            case 'namedesc':
                $orderByQuery = 'ORDER BY pl.`name`  DESC';
                break;
            case 'nameasc':
                $orderByQuery = 'ORDER BY pl.`name`  ASC';
                break;
            case 'percentdesc':
                $orderByQuery = 'ORDER BY markup  DESC';
                break;
            case 'percentasc':
                $orderByQuery = 'ORDER BY markup  ASC';
                break;
            case 'marcupdesc':
                $orderByQuery = 'ORDER BY p.`ruble_markup`  DESC';
                break; 
            case 'marcupasc':
                $orderByQuery = 'ORDER BY p.`ruble_markup`  ASC';
                break;  
            
            }
    
      
    function pagination($total, $per_page, $num_links, $start_row, $url=''){
        
      echo '
      <style>
      div.wrapPaging {padding: 6px 0px 6px 16px; font-family: Arial, sans-serif; font-size: 14px; clear: both;}
        div.wrapPaging a, div.wrapPaging span {margin: 0 1px; padding: 2px 5px; line-height: 26px; text-decoration: none;}
        div.wrapPaging a {background: none; color: #025A9C !important; text-decoration: underline; font-size: 14px;}
        div.wrapPaging span {background: #E8E9EC; color: #000;}
        div.wrapPaging span.ways {background: none; font-size: 15px; color: #999;}
        div.wrapPaging span.ways span {background: none; color: #999;}
        div.wrapPaging span.ways a {font-size: 15px;}
        div.wrapPaging span.divider {color: #999;}
        div.wrapPaging i {font-family: Times, sans-serif; margin: 0 5px 0 0;}
        div.wrapPaging a:hover {color: #ff0000;}
        div.wrapPaging strong {margin: 0 15px 0 0; font-size: 16px; font-weight: bold; color: #000;}
      </style>
      
      ';  
    //Получаем общее число страниц
    $num_pages = ceil($total/$per_page);

    if ($num_pages == 1) return '';

    //Получаем количество элементов на страницы
    $cur_page = $start_row;

    //Если количество элементов на страницы больше чем общее число элементов
    // то текущая страница будет равна последней
    if ($cur_page > $total){
        $cur_page = ($num_pages - 1) * $per_page;
    }

    //Получаем номер текущей страницы
    $cur_page = floor(($cur_page/$per_page) + 1);

    //Получаем номер стартовой страницы выводимой в пейджинге
    $start = (($cur_page - $num_links) > 0) ? $cur_page - $num_links : 0;
    //Получаем номер последней страницы выводимой в пейджинге
    $end   = (($cur_page + $num_links) < $num_pages) ? $cur_page + $num_links : $num_pages;

    $output = '<span class="ways">';

    //Формируем ссылку на предыдущую страницу
    if  ($cur_page != 1){
        $i = $start_row - $per_page;
        if ($i <= 0) $i = 0;
        $output .= '<i>←</i><a href="'.$url.'&page='.$i.'">Предыдущая</a>';
    }
    else{
        $output .='<span><i>←</i>Предыдущая</span>';
    }
    
    $output .= '<span class="divider">|</span>';

    //Формируем ссылку на следующую страницу
    if ($cur_page < $num_pages){
        $output .= '<a href="'.$url.'&page='.($cur_page * $per_page).'">Следующая</a><i>→</i>';
    }
    else{
        $output .='<span>Следующая<i>→</i></span>';
    }

    $output .= '</span><br/>';

    //Формируем ссылку на первую страницу
    if  ($cur_page > ($num_links + 1)){
        $output .= '<a href="'.$url.'" title="Первая"><img src="images/left_active.png"></a>';
    }

    // Формируем список страниц с учетом стартовой и последней страницы   >
        for ($loop = $start; $loop <= $end; $loop++){
        $i = ($loop * $per_page) - $per_page;

        if ($i >= 0)
        {
            if ($cur_page == $loop)
            {
               //Текущая страница
               $output .= '<span>'.$loop.'</span>'; 
            }
            else
            {

               $n = ($i == 0) ? '' : $i;

               $output .= '<a href="'.$url.'&page='.$n.'">'.$loop.'</a>';
            }
        }
    }

    //Формируем ссылку на последнюю страницу
    if (($cur_page + $num_links) < $num_pages){
        $i = (($num_pages * $per_page) - $per_page);
        $output .= '<a href="'.$url.'&page='.$i.'" title="Последняя"><img src="images/right_active.png"></a>';
    }

    return '<div class="wrapPaging"><strong>Страницы:</strong>'.$output.'</div>';
}
        
    
      
      $sqlcount ='SELECT COUNT(*) AS `count`
                  FROM `ps_product`
                  WHERE  ind_markup = 1';  
       
      $ProductCount = Db::getInstance()->ExecuteS($sqlcount);              
      $ProductCount = $ProductCount[0]['count'];                                          
    
        $total = $ProductCount;
        if(isset($cookie->paginationSelected) and !empty($cookie->paginationSelected)){
          $per_page = $cookie->paginationSelected;  
        }else{
          $per_page = 20;
        }
        $num_page = 5;
        $start_row = (!empty($_GET['page']))? intval($_GET['page']): 0;
         if(isset($orderBy) and !empty($orderBy)){
           $url = $currentIndex.'&type=products_individually&order_by='.$orderBy.'&token='.$this->token; 
        }else{
          $url = $currentIndex.'&type=products_individually&token='.$this->token; 
        }
        
        if($start_row < 0) $start_row = 0;
        if($start_row > $total) $start_row = $total;
      
                                   $sqlforQuery ='SELECT p.`markup`,
                                                        p.`id_product`,
                                                        p.`reference`,
                                                        p.`id_product`,
                                                        p.`price`,
                                                        p.`wholesale_price`,
                                                        pl.`name`
                                                        
                                                 FROM `ps_product` p
                                                 LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = "'.$cookie->id_lang.'"  )
                                                 WHERE  p.`ind_markup` = 1';
      $ProductForQuery = Db::getInstance()->ExecuteS($sqlforQuery); 
      foreach($ProductForQuery as $item){
         
         
      $marcup_percent =  Product::calculatePriceParams($item['wholesale_price'], $item['markup'], true);
                  
                    
             Db::getInstance()->Execute('UPDATE `ps_product` 
                                         SET     `ruble_markup` = "' .$marcup_percent['markup'] . '"
                                         WHERE `id_product` = "' . $item['id_product'].'"');        
                                        
        }
        
                                        
      
      
                                          $sql ='SELECT p.`markup`,
                                                        p.`id_product`,
                                                        p.`reference`,
                                                        p.`id_product`,
                                                        p.`price`,
                                                        p.`wholesale_price`,
                                                        pl.`name` ,
                                                        p.`ruble_markup`
                                                 FROM `ps_product` p
                                                 LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = "'.$cookie->id_lang.'"  )
                                                 WHERE  p.`ind_markup` = 1
                                                 '.$orderByQuery.'
                                                 LIMIT '.$start_row.','.$per_page;
    
    $ProductQuery = Db::getInstance()->ExecuteS($sql);
    
     

    
    

    foreach($ProductQuery as $item){
        
    
    $productAllData = new Product($item['id_product'], true,$cookie->id_lang);
        
            $image = array();
	        $image = Db::getInstance()->getRow('
                								SELECT  id_image
                								FROM ps_image
                								WHERE id_product = '.(int)($item['id_product']).' AND cover = 1');

          	$imageObj = new Image($image['id_image']);
            $p_image_temp = isset($image['id_image']) ? __PS_BASE_URI__._PS_PROD_IMG_.$imageObj->getExistingImgPath().'-small.jpg' : '#';
           //echo   $productAllData->link_rewrite;       
            $p_image = $p_image_temp; 
    
      
      
    $marcup_percent =  Product::calculatePriceParams($item['wholesale_price'], $item['markup'], true);
    
    
    $productMarkup[] = array(     'img' =>$p_image,
                                  'articul' =>$item['reference'],
                                  'name' =>$item['name'],
                                  'id_product' =>$item['id_product'],
                                  'id_category' =>$productAllData->id_category_default,
                                  'marcup' =>$item['ruble_markup'],
                                  'price' => $item['price'],
                                  'marcup_percent' =>$item['markup'],
                                  
                                  
                                  );
                                
       }

       $tokenCatalog = Tools::getAdminToken('AdminCatalog'.(int)(Tab::getIdFromClassName('AdminCatalog')).(int)$cookie->id_employee);
       ?>
       
    <h1>Товары с индивидуально наценкой</h1>
           <table>
			<tbody><tr>
				<td style="vertical-align: bottom;">
                <?php 
    
                echo pagination($total,$per_page,$num_page,$start_row,$url);?>
					<form action="" method="POST">
                <span style="float: left;"> Показывать по
				
                    	<select name="pagination">
                        <option <?php if($cookie->paginationSelected==20){echo 'selected="selected"';} ?>  value="20">20</option>
                        <option <?php if($cookie->paginationSelected==50){echo 'selected="selected"';} ?>  value="50">50</option>
                        <option <?php if($cookie->paginationSelected==100){echo 'selected="selected"';} ?>  value="100">100</option>
                        <option <?php if($cookie->paginationSelected==300){echo 'selected="selected"';} ?>  value="300">300</option>
						</select>
					</span>
					<span style="float: right;">
						<input type="submit" name="submitResetcategory" value="Сбросить" class="button" />
						<input type="submit" name="submitFilterSelected" value="Фильтр" class="button" />
					</span>
                   	
					<span class="clear"></span> 
                    </form>
				</td>
			</tr>
			<tr>
				<td>
                <table class="table" cellpadding="0" cellspacing="0">
			<thead>
		        	<tr class="nodrag nodrop">
	
                        <th style="width: 90px" >Картинка<br />
                        </th>		
                        <th style="width: 150px">Артикул<br />
                         <a href="<?=$currentIndex?>&type=products_individually&order_by=artdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_individually&order_by=artasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 340px">Название<br />
                         <a href="<?=$currentIndex?>&type=products_individually&order_by=namedesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_individually&order_by=nameasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Процент наценки<br />
                         <a href="<?=$currentIndex?>&type=products_individually&order_by=percentdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_individually&order_by=percentasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Наценка в рублях<br />
                         <a href="<?=$currentIndex?>&type=products_individually&order_by=marcupdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=products_individually&order_by=marcupasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                  	
                    </tr>
			
			
			</thead>
            <tbody>
           <script src="/js/clipboard.min.js"></script>
      <?php   foreach($productMarkup as $key=>$value){ ?>           
   <tr class="alt_row" style="background-color: #FFDD99">
					<td class=" center"><img src="<?=$value['img']?>" /> </td>
					<td class="pointer"><div style="position:relative"><a class="copy-description" title="<?php echo $value['articul'];?>"><?php echo $value['articul'];?></a></div></td>
					<td class="pointer "><b><a target="_blank" href="/adminka/index.php?tab=AdminCatalog&id_category=<?=$value['id_category']?>&id_product=<?=$value['id_product']?>&updateproduct&token=<?=$tokenCatalog?>"><?php echo $value['name'];?></a></b></td>
					<td class=""><?=$value['marcup_percent']?>%</td>
					<td class=""><?=$value['marcup']?> руб.</td>
</tr>
           <?php } ?> 
            </tbody>
            
            </table>
            
            
				</td>
			</tr>
		</tbody>
        </table>
		
		</form>         
        <script>
                $('.copy-description').mouseover(function() {
                    var elem = $(this);
                    elem.removeClass('tooltipped');
                    elem.removeClass('tooltipped-s');
                    
                 });
                 $('.copy-description').click(function(){
                   //  $('.btn').attr('data-clipboard-target','d');
                          var elem = $(this);
                          var copyText = elem.attr('title');
                                  // var copyText = 'tg';
                     var clipboard = new Clipboard('.btn', {
                         text: function() {
                             return copyText;
                         }
                     });
                         clipboard.on('success', function(e) {
                         elem.addClass('tooltipped');
                         elem.addClass('tooltipped-s');
                         console.log(e);
                        });

                         clipboard.on('error', function(e) {
                        console.log(e);
                        });
                     $('.btn').trigger('click');
                     
                 
                 });
        </script>
        <?php
    
    //echo "<pre>";
    //print_r($productMarkup);
    //echo "</pre>";
    
    }
    
 if(Tools::getValue('type') == 'not_issued'){
    
    $orderHistory = Db::getInstance()->ExecuteS('
		SELECT DISTINCT `id_order_history`,`id_order`,`date_add`
		FROM `'._DB_PREFIX_.'order_history`
		WHERE `id_order_state` = 13
		ORDER BY `id_order_history` ASC');
    
   $tempOrderId = array();
   foreach($orderHistory as $key=>$value){
    
          if(!key_exists($tempOrderId[$value['id_order']])){
            $tempOrderId[$value['id_order']] = $value['id_order_history'];
           }
   }
   foreach($tempOrderId as $key=>$item) {
    $id_order_state = Db::getInstance()->getValue('
		SELECT `id_order_state`
		FROM `'._DB_PREFIX_.'order_history`
		WHERE `id_order` = '.(int)$key.'
		ORDER BY `date_add` DESC');
    if($id_order_state == 13){
        $stateOrders[] = $item;
    }    
        
   }
    
    $strinOrders = implode(",",$stateOrders);
    

    $orderByQuery = '';
    $orderBy = Tools::getValue('order_by');
          switch ($orderBy) {
            case 'numdesc':
                $orderByQuery = 'ORDER BY o.`id_order`  DESC';
                break;
            case 'numasc':
               $orderByQuery = 'ORDER BY o.`id_order`  ASC';
                break;
            case 'customerdesc':
                $orderByQuery = 'ORDER BY c.`lastname`  DESC';
                break;
            case 'customerasc':
                $orderByQuery = 'ORDER BY c.`lastname`  ASC';
                break;
            case 'paiddesc':
                $orderByQuery = 'ORDER BY o.`total_paid`  DESC';
                break;
            case 'paidasc':
                $orderByQuery = 'ORDER BY o.`total_paid`  ASC';
                break;
            case 'marcupdesc':
                $orderByQuery = 'ORDER BY  o.`total_products_markup`  DESC';
                break; 
            case 'marcupasc':
                $orderByQuery = 'ORDER BY o.`total_products_markup`  ASC';
                break;  
             case 'carrierdesc':
                $orderByQuery = 'ORDER BY sh.`name`  DESC';
                break;
             case 'carrierasc':
                $orderByQuery = 'ORDER BY sh.`name`  ASC';
                break;             
             case 'datedesc':
                $orderByQuery = 'ORDER BY sh.`name` DESC';
                break;    
             case 'dateasc':
                $orderByQuery = 'ORDER BY sh.`name`  ASC';
                break;          
            }


    $dataIssued = Db::getInstance()->ExecuteS('
               SELECT 
                      o.`id_order`,
                      o.`id_carrier`,
                      o.`id_customer`,
                      o.`total_paid`, 
                      o.`total_products_markup`,
                      oh.`id_order_history`,
                      oh.`id_employee`, 
                      oh.`id_order`,
                      oh.`id_order_state`,
                      oh.`date_add` ,
                      c.`firstname`,
                      c.`lastname`,
                      sh.`name`             
               FROM `'._DB_PREFIX_.'orders` o
               LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (o.`id_order` = oh.`id_order`)
               LEFT JOIN `'._DB_PREFIX_.'customer` c ON (o.`id_customer` = c.`id_customer`)
               LEFT JOIN `'._DB_PREFIX_.'carrier` sh ON (o.`id_carrier` = sh.`id_carrier`)
               WHERE oh.`id_order_history` IN ('.$strinOrders.')
               '.$orderByQuery.'
               
               
                LIMIT 0,30');
                                                                                                                                   
  

  
  // echo "<pre>";  
  // print_r($dataIssued);
  // echo "</pre>";
    /* $result = Db::getInstance()->ExecuteS('
			SELECT oh.*, e.`firstname` employee_firstname, e.`lastname` employee_lastname, osl.`name` ostate_name
			FROM `'._DB_PREFIX_.'orders` o
			LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (o.`id_order` = oh.`id_order`)
			LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
			LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$id_lang.')
			LEFT JOIN `'._DB_PREFIX_.'employee` e ON e.`id_employee` = oh.`id_employee`
			WHERE oh.id_order = '.(int)$this->id.'
			'.($no_hidden ? ' AND os.hidden = 0' : '').'
			'.($logable ? ' AND os.logable = 1' : '').'
			'.($delivery ? ' AND os.delivery = 1' : '').'
			'.((int)$id_order_state ? ' AND oh.`id_order_state` = '.(int)$id_order_state : '').'
			ORDER BY oh.date_add DESC, oh.id_order_history DESC');
            */
    
    
    
    
     if(empty($dataIssued)){
        
        echo "Нет данных";
        
     }else{
        
     
    ?>
           <h1>Не выданые</h1>
           <table>
			<tbody><tr>
				<td style="vertical-align: bottom;">
				
				</td>
			</tr>
			<tr>
				<td>
                <table class="table" cellpadding="0" cellspacing="0">
			<thead>
		        	<tr class="nodrag nodrop">
	
                        <th style="width: 90px" >№ заказа<br />
                        <a href="<?=$currentIndex?>&type=not_issued&order_by=numdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=not_issued&order_by=numasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>		
                        <th style="width: 150px">Покупатель<br />
                         <a href="<?=$currentIndex?>&type=not_issued&order_by=customerdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=not_issued&order_by=customerasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Итого<br />
                         <a href="<?=$currentIndex?>&type=not_issued&order_by=paiddesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=not_issued&order_by=paidasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Наценка<br />
                         <a href="<?=$currentIndex?>&type=not_issued&order_by=marcupdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=not_issued&order_by=marcupasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 180px">Способ доставки<br />
                         <a href="<?=$currentIndex?>&type=not_issued&order_by=carrierdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=not_issued&order_by=carrierasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Дата<br />
                         <a href="<?=$currentIndex?>&type=not_issued&order_by=datedesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=not_issued&order_by=dateasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                    </tr>
			
			
			</thead>
            <tbody>
      <?php   foreach($dataIssued as $key=>$value){ 
        
            $date = new DateTime($value['date_add']);
            $date->modify('+'.Configuration::get('PS_SHOP_EXPECTATION').' day');
            $datEnd = $date->format('Y-m-d');
            $dateToday = date('Y-m-d');
            if(strtotime($dateToday) >= strtotime($datEnd)){
               
           
           
            
        ?>           
   <tr class="alt_row" style="background-color: #FFDD99">
					<td class="pointer center"><?=$value['id_order']?></td>
					<td class="pointer"><?php $strName = $value['firstname'];echo mb_substr($strName,0,1).".".$value['lastname'];?></td>
					<td class="pointer "><b><?=$value['total_paid']?> руб</b></td>
					<td class="pointer "><?=$value['total_products_markup']?> руб</td>
					<td class="pointer" ><?=$value['name']?></td>
					<td class="pointer "><?=$value['date_add']?></td>

                    
                    
            </tr>
           <?php }
            } ?> 
            </tbody>
            
            </table>
            
            
				</td>
			</tr>
		</tbody>
        </table>
		<input name="token" value="04adc0ef728ed90db3f24db18b062b40" type="hidden">
		</form>
  
         
         <?php 
             }
           }
                  	
//shippedd
if(Tools::getValue('type') == 'shipped'){
    
    $orderHistory = Db::getInstance()->ExecuteS('
		SELECT DISTINCT `id_order_history`,`id_order`,`date_add`
		FROM `'._DB_PREFIX_.'order_history`
		WHERE `id_order_state` = 4
		ORDER BY `id_order_history` ASC');
    
   $tempOrderId = array();
   foreach($orderHistory as $key=>$value){
    
          if(!key_exists($tempOrderId[$value['id_order']])){
            $tempOrderId[$value['id_order']] = $value['id_order_history'];
           }
   }
   foreach($tempOrderId as $key=>$item) {
    $id_order_state = Db::getInstance()->getValue('
		SELECT `id_order_state`
		FROM `'._DB_PREFIX_.'order_history`
		WHERE `id_order` = '.(int)$key.'
		ORDER BY `date_add` DESC');        
    if($id_order_state == 4){
        $stateOrders[] = $item;
    }    
        
   }
    
    $strinOrders = implode(",",$stateOrders);
    

    $orderByQuery = '';
    $orderBy = Tools::getValue('order_by');
          switch ($orderBy) {
            case 'numdesc':
                $orderByQuery = 'ORDER BY o.`id_order`  DESC';
                break;
            case 'numasc':
               $orderByQuery = 'ORDER BY o.`id_order`  ASC';
                break;
            case 'customerdesc':
                $orderByQuery = 'ORDER BY c.`lastname`  DESC';
                break;
            case 'customerasc':
                $orderByQuery = 'ORDER BY c.`lastname`  ASC';
                break;
            case 'paiddesc':
                $orderByQuery = 'ORDER BY o.`total_paid`  DESC';
                break;
            case 'paidasc':
                $orderByQuery = 'ORDER BY o.`total_paid`  ASC';
                break;
            case 'marcupdesc':
                $orderByQuery = 'ORDER BY  o.`total_products_markup`  DESC';
                break; 
            case 'marcupasc':
                $orderByQuery = 'ORDER BY o.`total_products_markup`  ASC';
                break;  
             case 'carrierdesc':
                $orderByQuery = 'ORDER BY sh.`name`  DESC';
                break;
             case 'carrierasc':
                $orderByQuery = 'ORDER BY sh.`name`  ASC';
                break;             
             case 'datedesc':
                $orderByQuery = 'ORDER BY sh.`name` DESC';
                break;    
             case 'dateasc':
                $orderByQuery = 'ORDER BY sh.`name`  ASC';
                break;
             case 'trakedesc':
                $orderByQuery = 'ORDER BY o.`shipping_number` DESC';
                break;    
             case 'trakeasc':
                $orderByQuery = 'ORDER BY o.`shipping_number`  ASC';
                break;                 
            }


    $dataIssued = Db::getInstance()->ExecuteS('
               SELECT 
                      o.`id_order`,
                      o.`id_carrier`,
                      o.`id_customer`,
                      o.`total_paid`,
                      o.`shipping_number`,
                      o.`total_products_markup`,
                      oh.`id_order_history`,
                      oh.`id_employee`, 
                      oh.`id_order`,
                      oh.`id_order_state`,
                      oh.`date_add` ,
                      c.`firstname`,
                      c.`lastname`,
                      sh.`name`             
               FROM `'._DB_PREFIX_.'orders` o
               LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (o.`id_order` = oh.`id_order`)
               LEFT JOIN `'._DB_PREFIX_.'customer` c ON (o.`id_customer` = c.`id_customer`)
               LEFT JOIN `'._DB_PREFIX_.'carrier` sh ON (o.`id_carrier` = sh.`id_carrier`)
               WHERE oh.`id_order_history` IN ('.$strinOrders.')
               '.$orderByQuery);
                                                                                                                                   
  

  
  //echo "<pre>";  
  // print_r($dataIssued);
  // echo "</pre>";
    /* $result = Db::getInstance()->ExecuteS('
			SELECT oh.*, e.`firstname` employee_firstname, e.`lastname` employee_lastname, osl.`name` ostate_name
			FROM `'._DB_PREFIX_.'orders` o
			LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (o.`id_order` = oh.`id_order`)
			LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
			LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$id_lang.')
			LEFT JOIN `'._DB_PREFIX_.'employee` e ON e.`id_employee` = oh.`id_employee`
			WHERE oh.id_order = '.(int)$this->id.'
			'.($no_hidden ? ' AND os.hidden = 0' : '').'
			'.($logable ? ' AND os.logable = 1' : '').'
			'.($delivery ? ' AND os.delivery = 1' : '').'
			'.((int)$id_order_state ? ' AND oh.`id_order_state` = '.(int)$id_order_state : '').'
			ORDER BY oh.date_add DESC, oh.id_order_history DESC');
            */
    
    
    
    
     if(empty($dataIssued)){
        
        echo "Нет данных";
        
     }else{
        
     
    ?>
           <h1>Отправленые</h1>
           <table>
			<tbody><tr>
				<td style="vertical-align: bottom;">
				
				</td>
			</tr>
			<tr>
				<td>
                <table class="table" cellpadding="0" cellspacing="0">
			<thead>
            		<tr class="nodrag nodrop">
	
                        <th style="width: 90px" >№ заказа<br />
                        <a href="<?=$currentIndex?>&type=shipped&order_by=numdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=shipped&order_by=numasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>		
                        <th style="width: 150px">Покупатель<br />
                         <a href="<?=$currentIndex?>&type=shipped&order_by=customerdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=shipped&order_by=customerasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Итого<br />
                         <a href="<?=$currentIndex?>&type=shipped&order_by=paiddesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=shipped&order_by=paidasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Наценка<br />
                         <a href="<?=$currentIndex?>&type=shipped&order_by=marcupdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=shipped&order_by=marcupasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 150px">Способ доставки<br />
                         <a href="<?=$currentIndex?>&type=shipped&order_by=carrierdesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=shipped&order_by=carrierasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                        <th style="width: 120px">Дата<br />
                         <a href="<?=$currentIndex?>&type=shipped&order_by=datedesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=shipped&order_by=dateasc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>
                        <th style="width: 120px">Трек<br />
                         <a href="<?=$currentIndex?>&type=shipped&order_by=trakedesc&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/down.gif" /></a>
						<a href="<?=$currentIndex?>&type=shipped&order_by=trakec&token=<?=Tools::getValue('token')?>"><img border="0" src="../img/admin/up.gif" /></a>
                        </th>	
                    </tr>
			
			</thead>
            <tbody>
            <script type="text/javascript" src="/js/clipboard.min.js"></script>
            
      <?php 
      
      $tokenOrders = Tools::getAdminToken('AdminOrders'.(int)(Tab::getIdFromClassName('AdminOrders')).(int)$cookie->id_employee);
      $tokenUser  = Tools::getAdminToken('AdminCustomers'.(int)(Tab::getIdFromClassName('AdminCustomers')).(int)$cookie->id_employee);
      
        foreach($dataIssued as $key=>$value){ 
               
            $date = new DateTime($value['date_add']);
            $date->modify('+'.Configuration::get('PS_SHOP_WAITINGDELIVERY').' day');
            $datEnd = $date->format('Y-m-d');
            
            $dateToday = date('Y-m-d');
            if(strtotime($dateToday) >= strtotime($datEnd)){
               
        
        ?>           
   <tr class="alt_row" style="background-color: #FFDD99">
					<td class="pointer center"><a href="index.php?tab=AdminOrders&id_order=<?=$value['id_order']?>&vieworder&token=<?=$tokenOrders?>" target="_blank"><?=$value['id_order']?></a></td>
					<td class="pointer"><a href="index.php?tab=AdminCustomers&id_customer=<?=$value['id_customer']?>&viewcustomer&token=<?=$tokenUser?>" target="_blank"><?php $strName = $value['firstname'];echo mb_substr($strName,0,1).".".$value['lastname'];?></a></td>
					<td class="pointer "><b><?=$value['total_paid']?> руб</b></td>
					<td class="pointer "><?=$value['total_products_markup']?> руб</td>
					<td class="pointer" ><?=$value['name']?></td>
					<td class="pointer "><?=$value['date_add']?></td>
                    <td class="pointer "><div style="position:relative"><a class="copy-description" title="<?php echo $value['shipping_number']?>"> <?=$value['shipping_number']?></a></div></td>

                    
                    
            </tr>
           <?php }
           } ?> 
            </tbody>
            
            </table>
            
            
				</td>
			</tr>
		</tbody>
        </table>
		</form>
                <button class="btn">Copy</button>
            <script>
                $('.copy-description').mouseover(function() {
                    var elem = $(this);
                    elem.removeClass('tooltipped');
                    elem.removeClass('tooltipped-s');
                    
                 });
                 $('.copy-description').click(function(){
                   //  $('.btn').attr('data-clipboard-target','d');
                          var elem = $(this);
                          var copyText = elem.attr('title');
                                  // var copyText = 'tg';
                     var clipboard = new Clipboard('.btn', {
                         text: function() {
                             return copyText;
                         }
                     });
                         clipboard.on('success', function(e) {
                         elem.addClass('tooltipped');
                         elem.addClass('tooltipped-s');
                         console.log(e);
                        });

                         clipboard.on('error', function(e) {
                        console.log(e);
                        });
                     $('.btn').trigger('click');
                     
                 
                 });

</script>  
         <?php 
             }
           }   
        
       
  
   
	  parent::postProcess();
     
	
    }
    
   
   
 }  
?>