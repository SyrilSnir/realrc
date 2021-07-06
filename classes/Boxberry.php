<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pickup
 *
 * @author kotov
 */
class BoxberryCore extends ObjectModel
{
    public $company;
    public $company_name;
    public $address;
    public $schedule;
    public $geo_lon;
    public $geo_lat;
    public $code;
    public $options;
    public $tariff_zone;
    public $city_id;


    protected $table = 'boxberry';
    protected $identifier = 'id_boxberry';
    
    protected $fieldsRequired = array( 'company','address');
    protected $fieldsValidate = array( 'company' => 'isString',
                                       'company_name' => 'isString',
                                       'address' => 'isString',
                                       'schedule' => 'isString',
                                       'geo_lon' => 'isFloat',
                                       'geo_lat' => 'isFloat',
                                       'code' => 'isString',
                                       'options' => 'isString',
                                       'tariff_zone' => 'isString',
                                       'city_id' => 'isUnsignedId'                                       
        );
    

    public function __construct($id = null, $id_lang = null)
    {
        parent::__construct($id, $id_lang);
        
    }
    public function getFields()
    {
        parent::validateFields();
        $fields['company'] = pSQL($this->company);
        $fields['company_name'] = pSQL($this->company_name);
        $fields['address'] = pSQL($this->address);
        $fields['schedule'] = pSQL($this->schedule);
        $fields['geo_lon'] = (float) $this->geo_lon;
        $fields['geo_lat'] = (float) $this->geo_lat;
        $fields['code'] = pSQL($this->code);
        $fields['options'] = pSQL($this->options);
        $fields['tariff_zone'] = pSQL($this->tariff_zone); 
        $fields['city_id'] = (int) $this->city_id;
        return $fields;
    }
    public static function getPickupsList()
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT bx.`id_boxberry`,bx.`company_name`, bx.`address`, bx.`geo_lon`,bx.`geo_lat`,bx.`code` 
		FROM `'._DB_PREFIX_.'boxberry` bx ORDER BY bx.`company_name`');
    }


}
