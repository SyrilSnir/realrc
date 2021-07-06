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


if (isset($_POST['boxberry_reg']) )
{
    $token = "8f18b1873612108d6c2e00d939d87a87"; 
 //   require_once (PS_ADMIN_DIR.'/classes/Axiomus.php');
 //   $axiomus = new Axiomus($_POST['token']);
    $url = "http://api.boxberry.ru/json.php?token={$token}&method=ListPoints";
  //  $result = $axiomus->SendData($url, $data);
    $opts = array (
                'http' => 
                    array (                        
                        'method' => 'GET',
                        'header' => 'Content-type: application/json; charset=UTF-8',
                     //   'content' => http_build_query($data)
                    )
                );
    $context = stream_context_create($opts);
    if ($response = file_get_contents($url,false,$context)) {        
        $response = json_decode($response,true);
   //     var_dump($response);
      //  die();
    } else {
        die('Error');
    } 
    $res = Db::getInstance()->Execute('TRUNCATE table `'._DB_PREFIX_.'boxberry`');
    if ($res) {
            foreach ($response as $pvz) {
                list($lon,$lat) = explode(',', $pvz['GPS']);
                $boxberryObject = new Boxberry();
                $boxberryObject->company = 'BoxBerry';
                $boxberryObject->company_name = $pvz['Name'];
                $boxberryObject->address = $pvz['Address'];
                $boxberryObject->schedule = $pvz['WorkShedule'];
                $boxberryObject->geo_lon = (float) $lon;
                $boxberryObject->geo_lat = (float) $lat;
                $boxberryObject->code = (string) $pvz['Code'];
                $boxberryObject->options = $pvz['TripDescription'];
                $boxberryObject->tariff_zone = $pvz['TariffZone'] ? $pvz['TariffZone'] : 0;
                $boxberryObject->city_id = $pvz['CityCode'] ? (int) $pvz['CityCode'] : 0;


                $boxberryObject->add();
                unset ($boxberryObject);
            }
            print_r(count($response));         
    }
    else {
            print_r('Ошибка обновленичя');
        }
}

if (isset($_POST['boxberry_calc']) ) {
    $token = "UKTMogKloK3aMIunfToTQO6mdyLDi_qP";
    $weight = 500;
    $height = 15;
    $width = 20;
    $depth = 10;                        
    $code = $_POST['code'];
    $price = $_POST['price'];
    $address = $_POST['address'];
    $url = "http://api.boxberry.ru/json.php?token={$token}&method=DeliveryCosts&weight={$weight}&target={$code}&ordersum={$price}&deliverysum={$price}&height={$height}&width={$width}&depth={$depth}&sucrh=1";

    $opts = array (
                'http' => 
                    array (                        
                        'method' => 'GET',
                        'header' => 'Content-type: application/json; charset=UTF-8',
                     //   'content' => http_build_query($data)
                    )
                );
    $context = stream_context_create($opts);
    if ($response = file_get_contents($url,false,$context)) {        
        $result = json_decode($response,true);        
    } else {
        die('Error');
    }    
    if (is_array($result)) {
        $resPrice = round($result['price']);
    }
    $resJson = [
        'price' => 'Новая стоимость доставки: '.$resPrice.' руб.'
    ];
    SessionsCore::sessionInit();
    SessionsCore::setValueToVar('BOXBERRY_PICKUP_CHANGED', array(
       'price'  => $resPrice,
       'code' => $code,
       'address' => $address
    ));
    echo(json_encode($resJson));
    
 //   print_r($result);
    die();
    
    
}
?>