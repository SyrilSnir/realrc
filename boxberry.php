<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require(dirname(__FILE__).'/config/config.inc.php');
require(dirname(__FILE__).'/adminka/classes/Axiomus.php');

if (isset($_GET['carrier'])) {
    $carrier = (int)$_GET['carrier'];
    $carrier_type = new Carrier($carrier);
    if ($carrier_type->external_module_name == 'boxberry' && $carrier_type->deleted == 0) {
            
    $pickup_list = Boxberry::getPickupsList();
    array_unshift($pickup_list, array(
        'id_boxberry' => '-',
        'address' => 'Выберите пункт самовывоза'
    ));
//print_r($pickup_list);
    echo (json_encode($pickup_list));
    } else {
        echo '{}';     
    }
} elseif ((int) $_GET['set_pvz'] === 1) {
   if (is_array($_GET['pvz_params'])) {
       $cookie = new Cookie('ps', '', time() + (((int)Configuration::get('PS_COOKIE_LIFETIME_FO') > 0 ? (int)Configuration::get('PS_COOKIE_LIFETIME_FO') : 1) * 3600));
        if ((int)$cookie->id_cart)
        {
            Sessions::sessionInit();
            $saved_sum = SessionsCore::getVarSession('CARD_TOTAL_SUM');
            $cart = new Cart((int)$cookie->id_cart);
            $sum = $cart->getOrderTotal(true,Cart::BOTH_WITHOUT_SHIPPING); 
            if ($sum !== $saved_sum) {
                echo 0;
                die();
            }
            Sessions::setValueToVar('SELECTED_PVZ',$_GET['pvz_params']);
            $_SESSION['SELECTED_PVZ']['sum'] = $sum;
            echo 1;
            die();            
        }

       
       
   }
}
elseif ((int) $_GET['set_sum'] === 1){
    $cookie = new Cookie('ps', '', time() + (((int)Configuration::get('PS_COOKIE_LIFETIME_FO') > 0 ? (int)Configuration::get('PS_COOKIE_LIFETIME_FO') : 1) * 3600));
    if ((int)$cookie->id_cart)
    {
        Sessions::sessionInit();
        $cart = new Cart((int)$cookie->id_cart);
        $price = $cart->getOrderTotal(true,Cart::BOTH_WITHOUT_SHIPPING); 
        Sessions::setValueToVar('CARD_TOTAL_SUM',$price);
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}
elseif (isset( $_GET['boxberry_calc'])) {
    $params =  $_GET['boxberry_calc'];
    $token = "c060c4b8e4d27263";
    $code = $params['code'];
    $company = $params['company'];
    $address = $params['address'];
    $price = $params['price'];
    $lon = $params['geo_lon'];
    $lat = $params['geo_lat'];
    $axiomus = new Axiomus($token);
    $url = "https://axiomus.ru/calc/calc.php";
    $data = array (
           'method' => 'carry',
           'company' => 'BoxBerry',
           'token' => $token,
           'weight' => 0.5,
           'code' => $code,
           'x' => 15,
           'y' => 15,
           'z' => 10,
           'type_company' => 51,
           'city_from' => 'moscow',
           'cod_type' => 'cash',
           'cod_allow' => 1,
           'val' =>  $price
    );
    $result = $axiomus->SendData($url, $data);
    if (is_array($result)) {
        $resPrice = round($result['BoxBerry']['carry'][0]['price']);
        $cookie = new Cookie('ps', '', time() + (((int)Configuration::get('PS_COOKIE_LIFETIME_FO') > 0 ? (int)Configuration::get('PS_COOKIE_LIFETIME_FO') : 1) * 3600));
        if ((int)$cookie->id_cart)
        {
            Sessions::sessionInit();
            $saved_sum = SessionsCore::getVarSession('CARD_TOTAL_SUM',0);
            $cart = new Cart((int)$cookie->id_cart);
            $sum = $cart->getOrderTotal(true,Cart::BOTH_WITHOUT_SHIPPING); 
            if ($saved_sum === 0) {
                $saved_sum = $sum;
                SessionsCore::setVarSession('CARD_TOTAL_SUM');
            }            
            if ($sum !== $saved_sum) {
                SessionsCore::setVarSession('CARD_TOTAL_SUM');
                echo json_encode(array('error' => 1));;
                die();
            }
            Sessions::setValueToVar('SELECTED_PVZ',array(
                "company" => $company,
                "address" => $address,
                "price" => $resPrice,
                "code" => $code,
                "geo_lat" => $lat,
                "geo_lon" => $lon
            ));
            $_SESSION['SELECTED_PVZ']['sum'] = $sum;
        }
    }
    $jsonRes = array('price' => $resPrice);
    
    
    echo json_encode($jsonRes);
} else {
    
    echo '{}';
}
