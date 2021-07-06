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
class PickupCore extends ObjectModel
{
    public $id_carrier;
    public $geo_data;
    public $description;
    public $image_dir;


    protected $table = 'pickup';
    protected $identifier = 'id_pickup';
    
    protected $fieldsRequired = array('id_carrier','geo_data');
    protected $fieldsSize = array('geo_data' => 20,'picture_file' => 32);
    protected $fieldsValidate = array('id_carrier' => 'isUnsignedInt',
                                       'geo_data' => 'isString',
                                        'description' => 'isString');
    

    public function __construct($id = null, $id_lang = null)
    {
        parent::__construct($id, $id_lang);
        $this->image_dir = _PS_IMG_DIR_. 'pk/';
        
    }
    public function getFields()
    {
        parent::validateFields();
        $fields['id_carrier'] = (int)$this->id_carrier;
        $fields['geo_data'] = pSQL($this->geo_data);
        $fields['description'] = pSQL($this->description);
        return $fields;
    }
    public static function getPickups()
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT pk.`id_pickup`, c.`name`, c.`id_carrier`, pk.`geo_data`,pk.`description` 
		FROM `'._DB_PREFIX_.'pickup` pk, `'._DB_PREFIX_.'carrier` c 
                WHERE pk.`id_carrier`=c.`id_carrier`');
    }
    public function delete()
    {
        if (!Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table)) {
                die(Tools::displayError());
        }
        $result = Db::getInstance()->Execute('DELETE FROM `'.pSQL(_DB_PREFIX_.$this->table).'` WHERE `'.pSQL($this->identifier).'` = '.(int)$this->id);
        if (!$result) {
            return false;
        }
        return $result;
    }

}
