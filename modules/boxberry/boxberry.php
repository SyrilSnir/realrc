<?php

/**
 * Description of boxberry
 *
 * @author kotov
 */
 if (!defined('_PS_VERSION_'))
	exit;
class Boxberry  extends Module {
    public function __construct()
    {
        $this->name = 'boxberry';
        $this->tab = 'shipping_logistics';
        $this->version = 1.0;
        $this->author = 'Konstantin Kortov';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = 'ПВЗ Boxberry';
        $this->description = 'Модуль добавления стоимости досавки для ПВЗ Boxberry';
    }
    public function getOrderShippingCostExternal($cart = null) {
        
        if (isset($_GET['step']) && $_GET['step']  == 1) {
            return 0;
        }
        Sessions::sessionInit();
        $selected_pvz = Sessions::getVarSession('SELECTED_PVZ');
        if ($selected_pvz) {
            return (int) $selected_pvz['price'];
        } else {
            return 0;
        }
    }
    public function saveShippingData( $obj = array(),$order_id) {
        if (empty($obj)) {
            return false;
        }
        $obObj = new OrderBoxberry();
        $obObj->code = $obj['code'];
        $obObj->address = $obj['address'];
        $obObj->shipping_price = $obj['price'];
        $obObj->id_order = $order_id;
        $obObj->save();
    }
    public function displayInfoByOrder ( OrderCore $order) {  
        $res= '<p>Выбранный ПВЗ Boxberry</p>';
        if (isset($_POST['boxberry_pvz'])) {
            $code = $_POST['boxberry_pvz'];            
        }
        $bx = OrderBoxberry::getIdFromOrder($order->id);
        $pvz_list = BoxberryCore::getPickupsList();
        if (count($pvz_list) == 0) {
            return '';
        }
        if ($bx ) {
        SessionsCore::sessionInit();
        $boxberry = new OrderBoxberryCore($bx);
            $pickupChanged = SessionsCore::getVarSession('BOXBERRY_PICKUP_CHANGED');
            if ($pickupChanged || !Tools::isSubmit('submitCarrierCh')) {
            if ($pickupChanged) {
                $boxberry->shipping_price = $pickupChanged['price']; 
                $boxberry->address = $pickupChanged['address'];
                $order->total_shipping = $pickupChanged['price'];
            } else {
                $order->total_shipping  = $boxberry->shipping_price;
            }
                $order->total_paid = $order->total_paid_real = $order->total_shipping + $order->total_products;
                $order->update();
                SessionsCore::unsetVarSession('BOXBERRY_PICKUP_CHANGED');
            }        
            if (isset($code)) {
                $boxberry->code = $code;
                $boxberry->update();
            }
        } else {
            $boxberry = new OrderBoxberryCore();
            $boxberry->id_order = $order->id;
            $boxberry->code = '0000';
            $boxberry->shipping_price = 0;
            $boxberry->add();

        } 
        if ($boxberry->code == '0000') {
            array_push($pvz_list, [
                    'code' => '0000' ,
                    'address' => 'Выберите пункт самовывоза'
                    ]);
        }
        $res = '';
        if ($boxberry->address) {
            $res.= "<p><span>Адрес доставки:</span> {$boxberry->address}</p>";
        }
        $orderData = htmlentities('"price":'.$order->getTotalProductsWithTaxes());
        
        $res.= '<form method="post"><select id="boxberry_pvz" data-order="{'.$orderData.'}" style="width:100%;" name="boxberry_pvz">';
        foreach ($pvz_list as $pvz) {
        $res.= '<option value="'.$pvz['code'].'"'.($pvz['code'] == $boxberry->code ? ' selected' : '').'>'.$pvz['address'].'</option>';
        }
        $res.='</select><input id="boxberry_change" value="Изменить" class="button noDisplay" type="submit"></form>';
        $res.='<p id="newCarrierPrice"></p>'; 
        return $res;
    }    
    
}
