<?php 
/**
 * @author fatory
 * @copyright 2014
 * @email 
 */


define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
/* Getting cookie or logout */
require_once(dirname(__FILE__).'/init.php');


if (isset($_POST['sku']) and !empty($_POST['sku']))
{
   $sku = Tools::getValue('sku');
   $result = Db::getInstance()->ExecuteS('SELECT `quantity`,`id_product` FROM `ps_product` WHERE  reference = "' . $sku. '"');
  if(!empty($result)){
  echo  '<form name="prod" method="POST" id="submitnewprod" action="#">
                    <fieldset style="width: 400px;">
                   	<legend style="cursor: pointer;" ><img src="../img/admin/email_edit.gif" />Введите артикул</legend>
                    <p>Остаток товара - '.$result[0]['quantity'].'</p>
                    <input type="text" name="prodquan" value="" />
                    <input type="hidden" name="prod_id" value="'.$result[0]['id_product'].'" />
                    
                    <input type="submit" class="button" name="addbprod" value="Добавить позицию" /> 
                    </fieldset>
            </form>';

   }else{
     echo  '<form name="prod" method="POST" id="submitnewprod" action="#">
                    <fieldset style="width: 400px;">
                   	<legend style="cursor: pointer;" ><img src="../img/admin/email_edit.gif" />Введите артикул</legend>
                    <p>Товар не найден.</p>
                   
                    </fieldset>
            </form>';
   }

}

?>