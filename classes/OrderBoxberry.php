<?php

class OrderBoxberryCore extends ObjectModel {
    
/** @var integer Order id */
public $id_order;

/** @var string */
public $code;

/** @var float Стоимость доставки */
public $shipping_price;

public $address;

protected $tables = array ('order_boxberry');

protected $table = 'order_boxberry';
protected $identifier = 'id_order_boxberry';

protected $fieldsRequired = array ('id_order', 'code','shipping_price');

protected $fieldsValidate = array (
    'id_order' => 'isUnsignedId',
    'code' => 'isString',
    'address' => 'isString',
    'shipping_price' => 'isPrice'
    );

public function __construct($id = null, $id_lang = null)
{
    parent::__construct($id, $id_lang);        
}
public function getFields()
{
    parent::validateFields();
    $fields['code'] = pSQL($this->code);
    $fields['address'] = pSQL($this->address);
    $fields['shipping_price'] = (float)($this->shipping_price);
    $fields['id_order'] = (float)($this->id_order);
    return $fields;
    }

public static function getIdFromOrder( $order_id) {
    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT bx.`id_order_boxberry` FROM `'._DB_PREFIX_.'order_boxberry` bx
            WHERE bx.`id_order` = '.(int) $order_id             
            );
    if (count ($res) != 1) {
        return false;
    }
    return (int) $res[0]['id_order_boxberry'];
}

}
