<?php



session_start();
class AdminSdiscount extends AdminTab
{
    
   	public function __construct()
	{
		global $cookie;
        $this->optionTitle = 'Статус';
 	    $this->table = 'sdiscount';
	 	$this->view = true;
        parent::__construct();
   
        

   }
   	
   	
   
    
   	public function postProcess()
	{
	   
       
        global $currentIndex, $cookie;
        
      $imgDer = $_SERVER["DOCUMENT_ROOT"].'/img/';
        
      if($_POST){
            
      //print_r($_POST);
      //print_r($_FILES);
        
        if(!empty($_FILES["image_sdiscount"]["name"])){
            $imgName = time().$_FILES["image_sdiscount"]["name"] ;
            move_uploaded_file($_FILES["image_sdiscount"]["tmp_name"], 
                $imgDer . $imgName); 
          if($_FILES["image_sdiscount"]["type"] == 'application/x-shockwave-flash'){
            $ftype = 1;            
          }else{
            $ftype = 2;
          }
            Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'sdiscount` 
                                         SET     `image_sdiscount` = "' .$imgName . '",
                                                 `file_sdiscount` = "' .$ftype . '"
                                         WHERE `id_sdiscount` = "' . $_POST['id_sdiscount'].'"');    
            
            
        }
        
        Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'sdiscount` 
                                         SET     `percent_sdiscount` = "' .$_POST["percent_sdiscount"]. '",`sum_sdiscount` = "' .$_POST["sum_sdiscount"]. '"
                                         WHERE `id_sdiscount` = "' . $_POST['id_sdiscount'].'"');    
            
        echo '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="Confirmation" />Настройки сохранены</div>';
    }
            
        
        
        $sDiscount = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'sdiscount` ORDER BY `id_sdiscount`  desc');     
       
       
	  ?>
       
      	<table id="product" class="table tableDnD" cellpadding="0" cellspacing="0">
			<thead>
				<tr class="nodrag nodrop">							
    	              <th >Фото	<br /></th>   
                      <th>Название статуса  <br /></th>
                      <th>Процент скидки <br /></th>	
             	      <th> Сумма<br /></th>	 
                      <th> Действияе<br /></th>	               	
                </tr>		
			</thead>  
            <?php foreach($sDiscount as $items) {
	
                                             ?>              
            <tr>   <form  enctype="multipart/form-data" action="<?=$currentIndex?>&token=<?=Tools::getValue('token')?>" name="sdiscount" method="POST">
                    <input type="hidden" name="id_sdiscount" value="<?=$items['id_sdiscount']?>" />
					<td  class=" center" style="height: 185px; width:160px ;">
                    <?php if($items['file_sdiscount'] == 1){ ?>
                    <object width="150" height="100">
                    <param name="movie" value="/img/<?=$items['image_sdiscount']?>">
                    <embed src="/img/<?=$items['image_sdiscount']?>" width="150" height="150"></embed>
                    </object>
                    <?}else {?>
                    <img src="/img/<?=$items['image_sdiscount']?>"/>
                    <?php } ?>
                    <br />
                     <input type="file" value="изменить" name="image_sdiscount" />
                    
                    </td>
					<td  class="center"><?=$items['name_sdiscount']?></td>
					<td  class="center"><input style="width: 60px;" type="text" name="percent_sdiscount" value="<?=$items['percent_sdiscount']?>" /></td>
   		            <td  class="center"><input style="width: 60px;" type="text" name="sum_sdiscount" value="<?=$items['sum_sdiscount']?>" /></td>
                    <td  class="center"><input type="submit" value="Сохранить" class="button" /></td>
				</form>	
			</tr> 
            <?php }?>   
   </table>
				
	
      
      <?php
      
	}
       
    
    public function displayForm()
	{
	  
    }
    
    
    public function display()
	{
	   
       
	
	}
   
    
}	