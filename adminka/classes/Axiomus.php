<?php

/**
 * Description of Axiomus
 *
 * @author kotov
 */
class Axiomus {
 
    
    // Ссылки на API
    public $url_geo = "https://axiomus.ru/calc/api_geo.php"; // API Geo (география)
    public $url_calc = "https://axiomus.ru/calc/calc.php"; // API Calc (калькулятор)
    
    /**
     * токен
     * @var string
     */
    public $token;
    
    public function __construct($token)
    {
	$this->token = $token;
    }   
     /**
      * Функция отправки запроса на API (возвращает ответ от API)
      * @param type $url
      * @param array $data
      * @return mixed
      */       
    public function SendData($url, $data)
    { 
        $data['token'] = $this->token;
        $opts = array (
                'http' => 
                    array (                        
                        'method' => 'POST',
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => http_build_query($data)
                    )
                );
        $context = stream_context_create($opts);
        if ($response = file_get_contents($url,false,$context)) {
            return json_decode($response,true);
        } else {
            return false; // Ошибка запроса
        }                    
    }
    /**
     * Функция для определения по адресу информации о регионе и определения координат через Яндекс.Геокодер. Возвращает массив с координатами и информацией о городе, регионе и области
     * @param type $address
     * @return boolean
     */
    public function YaGeocoder($address) {
        $url = 'https://geocode-maps.yandex.ru/1.x/?geocode='.urlencode($this->mb_trim($address)).'&amp;format=json&amp;results=1';
	//+ '&key=' + urlencode('API-ключ если у Вас он есть, без него разрешено делать 25000 запросов в день');
        //
        // Получаем ответ от Яндекс.Геокодера и преобразуем в ассоциативный массив
	$response = file_get_contents($url);
	$resp = json_decode($response, true);
	$ya_data = $resp['response']['GeoObjectCollection'];
        
        // Если удалось определить координаты, составляем выходной массив $g, иначе возвращаем false (Ошибка геокодирования)
        if($ya_data['metaDataProperty']['GeocoderResponseMetaData']['results'] == 1) {
            if(isset($ya_data['featureMember'][0]['GeoObject']['Point']['pos']) AND $this->mb_trim($ya_data['featureMember'][0]['GeoObject']['Point']['pos'])!='') {
                $tmp = explode(' ', $ya_data['featureMember'][0]['GeoObject']['Point']['pos']);
                $g['lon'] = $tmp[0]; // Долгота
                $g['lat'] = $tmp[1]; // Широта
                if(isset($ya_data['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']['Country']['AdministrativeArea']['AdministrativeAreaName'])) {
                    $g['area'] = $ya_data['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']['Country']['AdministrativeArea']['AdministrativeAreaName']; // Область
		} else {
			$g['area'] = '';
		}
		if (isset($ya_data['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']['Country']['AdministrativeArea']['SubAdministrativeArea']['SubAdministrativeAreaName'])) {	
                    $g['region'] = $ya_data['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']['Country']['AdministrativeArea']['SubAdministrativeArea']['SubAdministrativeAreaName']; // Регион
		} else {
                    $g['region'] = '';
		}
		if( isset($g['region']) AND $g['region']!=='' AND isset($ya_data['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']['Country']['AdministrativeArea']['SubAdministrativeArea']['Locality']['LocalityName'])) {
                    $g['city'] = $ya_data['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']['Country']['AdministrativeArea']['SubAdministrativeArea']['Locality']['LocalityName']; // Город
                } else {
                    if(isset($ya_data['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']['Country']['AdministrativeArea']['Locality']['LocalityName'])) {
                        $g['city'] = $ya_data['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['AddressDetails']['Country']['AdministrativeArea']['Locality']['LocalityName']; // Город
                    }
                }
                if(!isset($g['city']) OR $g['city'] === '') {
                    $g['city'] = NULL; // Если город неопределен возвращаем city = NULL
                }	
                unset($tmp);
                return $g;
            } else {
                    return false;
            }
        } else {
                    return false;
                }
    }
    protected function mb_trim($str) 
    {	
        return preg_replace("/(^\s+)|(\s+$)/us", "", $str); 
    }
    
}
