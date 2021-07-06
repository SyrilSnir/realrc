<?php

class AdminBoxberry extends AdminTab
{
    protected $maxImageSize = 1000000;
    public function __construct()
    {
        $this->optionTitle = 'Boxberry';
        $this->table = 'boxberry';
        $this->className = 'Boxberry';
        $this->edit = true;
        $this->delete = true;
        $this->fieldsDisplay = array(
           'id_boxberry' => array('title' => '№', 'align' => 'center', 'width' => 25),
            'company' => array('title' => 'Тип', 'width' => 30),
            'company_name' => array('title' => 'Название', 'width' => 100),
            'address' => array('title' => 'Адрес', 'width' => 100),
            'schedule' => array('title' => 'Время работы', 'width' => 100),
            
            );
                
        parent::__construct();
    }
    
    public function displayForm ($isMainTab = true)
    {
        parent::displayForm();
        if (!($obj = $this->loadObject(true))) {
            return;
        }
         echo '
            <form action="'.$currentIndex.'&submitAdd'.$this->table.'=1&token='.$this->token.'" method="post"  enctype="multipart/form-data">'.
            ($obj->id ? '<input type="hidden" name="id_'.$this->table.'" value="'.$obj->id.'" />' : '').
        '<fieldset><legend><img src="../img/admin/world.gif" />Пункт самовывоза Boxberry</legend>';
        echo ' 
             <label>Компания:</label><div class="margin-form">
            <input type="text" size="30" maxlength="16" name="company" value="'.htmlentities($this->getFieldValue($obj, 'company'), ENT_COMPAT, 'UTF-8').'" /> <sup>*</sup></div>
             <label>Широта:</label><div class="margin-form">
            <input type="text" size="30" maxlength="16" name="company_name" value="'.htmlentities($this->getFieldValue($obj, 'company_name'), ENT_COMPAT, 'UTF-8').'" /> <sup>*</sup></div>
                 <label>Широта:</label><div class="margin-form">
            <input type="text" size="30" maxlength="16" name="geo_lat" value="'.htmlentities($this->getFieldValue($obj, 'geo_lat'), ENT_COMPAT, 'UTF-8').'" /> <sup>*</sup></div>
                
            <label>Широта:</label><div class="margin-form">
            <input type="text" size="30" maxlength="16" name="geo_lat" value="'.htmlentities($this->getFieldValue($obj, 'geo_lat'), ENT_COMPAT, 'UTF-8').'" /> <sup>*</sup></div>
            <label>Долгота:</label><div class="margin-form">
            <input type="text" size="30" maxlength="16" name="geo_lon" value="'.htmlentities($this->getFieldValue($obj, 'geo_lon'), ENT_COMPAT, 'UTF-8').'" /> <sup>*</sup></div>';
        
        echo '<div class="margin-form">
            <input type="submit" value="'.$this->l('   Save   ').'" name="submitAdd'.$this->table.'" class="button" />
            </div><div class="small"><sup>*</sup> '.$this->l('Required field').'</div>
            </fieldset></form>'; 
    }
     public function displayTop() {
    ?>
        <button id="update-boxberry">Обноить список пункто самовывоза</button>		 
    <?php
    }
    public function display() {
        parent::display();
        ?>
<script>
    $(document).ready( function() {
        $('#update-boxberry').click( function() {
            $.ajax({
                type : "POST",
                url: "boxberry-ajax.php",
                data:{
                    boxberry_reg: 1,      		
                },
                async : true,
                success: function(msg) {
                    alert(msg);
                    location.reload(); 
                }
                		 });             
        });
    });

</script>
        <?php
    }
    
    
    
}