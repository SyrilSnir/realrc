<?php




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
   	
    public function getProductsDetail($id)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'order_detail` od
		WHERE od.`id_order` = '.(int)$id);
	}
    
   	public function postProcess()
	{
	  
      
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
        
        
        //print_r($listProd);
        
      foreach($listProd as $prod){
        $ProductCategory = Product::getProductCategories($prod['product_id']);
        //$newProd = 
        print_r( $ProductCategory);
          
      }  
       
       
       
	}
       
    
    public function displayForm($isMainTab = true)
	{
	   
       
	}
    
    
    public function display()
	{
		
	
	}
   
    
}	