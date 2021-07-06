<?php


/**
 * Description of Sessions
 *
 * @author kotov
 */
class SessionsCore {
    
    protected static $init = false; // Флаг
    /**
 * устанавливает переменную сессии пользователя
 * @param array $data
*/
    public static function setVarSession($data) 
    {
        if (!self::$init)  {
            return ;
        }
        while(true)
        {
            
            list( $key, $val ) = each($data);
            if (!isset($key)) {
                break;
            }
            $_SESSION[$key] = $val;
        }
    }
    /**
     * Установить значение для переменной сессии
     * @param type $var имя переменной
     * @param type $value значение
     */
    public static function setValueToVar($var,$value)
    {  
        self::sessionInit();
        $_SESSION[$var] = $value;
    }
    
    /**
 * получает данные из переменной сессии
 * @param type $name
 * @return string
 */
    public static function getVarSession($name,$def_value = false) 
    {
        if (isset($_SESSION[$name])) {            
            return $_SESSION[$name];
        }
        else {
            return $def_value;
        }
    }
    public static function unsetVarSession($name) {
        if (key_exists($name, $_SESSION)) {
            unset ($_SESSION[$name]);
        }
    }
    /**
     * Инициализация сессии
     */
    public static function sessionInit() 
    {
        if (self::$init)  {
            return null;
        }
        session_start();
        self::$init = true;
    }
 
    public static function destroySession() 
    {
        self::sessionInit();
        session_unset();
        $_SESSION = array();
        self::$init = false;
    }
    public static function isSessionInit()
    {
        return self::$init;
    }
    
}
