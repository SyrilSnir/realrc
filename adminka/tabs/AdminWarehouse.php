<?php 
/**
 * @author fatory
 * @copyright 2014
 * @email 
 */
 
class AdminWarehouse extends AdminTab
{
	public function __construct()
	{
		global $cookie;

	 	$this->table = 'Warehouse';
	 	$this->className = 'Warehouse';
	 	$this->view = true;
        parent::__construct();

   }
   
 }  
?>