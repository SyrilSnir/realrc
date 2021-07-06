<?php

class AdminPickup extends AdminTab
{
    protected $maxImageSize = 1000000;
    public function __construct()
    {
        $this->optionTitle = 'Пункты самовывоза';
        $this->table = 'pickup';
        $this->className = 'Pickup';
        $this->edit = true;
        $this->delete = true;
        $this->fieldImageSettings = array('name' => 'pickup_image', 'dir' => 'pk');
        $this->fieldsDisplay = array(
           'id_pickup' => array('title' => '№', 'align' => 'center', 'width' => 25),
            'name' => array('title' => 'Имя', 'width' => 100,'filter_key' => 'z!name'),
            'pickup_image' => array('title' => 'Изображение', 'align' => 'center', 'image' => 'pk', 'orderby' => false, 'search' => false),
            'geo_data' => array('title' => 'Координаты', 'width' => 100),
            );
        $this->_select = 'z.`name` AS name';
        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'carrier` z ON (z.`id_carrier` = a.`id_carrier`)';
                
        parent::__construct();
    }
    
    public function displayForm ($isMainTab = true)
    {
        global $currentIndex,$cookie;
        parent::displayForm();
        if (!($obj = $this->loadObject(true)))
            return;
        echo '
            <form action="'.$currentIndex.'&submitAdd'.$this->table.'=1&token='.$this->token.'" method="post"  enctype="multipart/form-data">'.
            ($obj->id ? '<input type="hidden" name="id_'.$this->table.'" value="'.$obj->id.'" />' : '').
        '<fieldset><legend><img src="../img/admin/world.gif" />Пункт самовывоза</legend>
        <label>Название</label><div class="margin-form"><select name="id_carrier">';
        foreach (Carrier::getCarriers((int)$cookie->id_lang) as $carrier) {
            echo '<option value="'.(int)($carrier['id_carrier']).'"'.(($this->getFieldValue($obj, 'id_carrier') == $carrier['id_carrier']) ? ' selected="selected"' : '').'>'.$carrier['name'].'</option>';
        }
        echo '</select><sup>*</sup><p>Выберите из существующих перевозчиков</p></div>
        <label>Изображение</label><div class="margin-form">';
        $this->displayImage($obj->id, _PS_IMG_DIR_.'pk/'.$obj->id.'.jpg', 350, null, null, true);
        echo '<br /><input type="file" name="pickup_image"/>
            <p>Добавьте изображение с коипьютера (в формате .gif, .jpg, .jpeg или .png)</p>
				</div>
        <label>GPS координаты объекта</label><div class="margin-form">
        <input type="text" size="30" maxlength="32" name="geo_data" value="'.htmlentities($this->getFieldValue($obj, 'geo_data'), ENT_COMPAT, 'UTF-8').'" /> <sup>*</sup>
        <img id="addAddress" src="../img/admin/flats16.png" alt="" title="Ввести адрес" class="pointer" /><span id="addressOnMap"><input type="text" size="45">
        <a href="http://maps.google.com/maps?f=q&hl=ru&geocode=&q=" target="_blank"><img src="../img/admin/google.gif" alt="" title="Показать на карте" class="middle" /></a></span>
        <p class="clear">Используйте формат яндекс карт вида 55.751128, 37.615555 </p></div>
        <label>Описание</label><div class="margin-form">
        <textarea name="description" cols="50" rows="10">'.htmlentities($this->getFieldValue($obj, 'description'), ENT_COMPAT, 'UTF-8').'</textarea>
        <p class="clear">Доп. информация, например как пройти</p></div>';
        echo '<div class="margin-form">
            <input type="submit" value="'.$this->l('   Save   ').'" name="submitAdd'.$this->table.'" class="button" />
            </div><div class="small"><sup>*</sup> '.$this->l('Required field').'</div>
			</fieldset></form>'; ?>
<script type="text/javascript">
   var blockMap = $('#addressOnMap');
   var addrImage = $('#addAddress');
   var mapLink = $('#addressOnMap a');
   var link = mapLink.attr('href');
   var adrInput = $('#addressOnMap input');
   if (blockMap.hasClass('noDisplay') == false) {
       blockMap.addClass('noDisplay');
   }
   addrImage.click(function(){
       if (blockMap.hasClass('noDisplay') == true) {
           blockMap.removeClass('noDisplay');
       }
       else {
            blockMap.addClass('noDisplay');
       }
   });
   adrInput.keyup(function(){
       var newLink = link + $(this).val();
       mapLink.attr('href',newLink);
   });
   
</script>
    <?php
    }
    
    
}