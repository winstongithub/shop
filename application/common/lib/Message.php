<?php
namespace app\common\lib;

use think\Session;
/**
 * 系统信息记录方法
 * 
 * @author Jesse
 */
class Message{
	const MESSAGE_INDEX = 1;
	const MESSAGE_ADMIN = 2;	
	const MESSAGE_SYS 	= 3; //系统消息 一般不给前端显示
	
	const LEVEL_NOTICE = 1;
    const LEVEL_ERROR = 2;
    public static $messageKey = "System_message";

    public static function GenKey($level = self::LEVEL_NOTICE,$type = self::MESSAGE_INDEX){
	    $key = self::$messageKey . "_{$level}_{$type}";
	    return $key;
    }
    
    	/**
	 * 获取对应信息
	 */
	public static function GetMessage($level = self::LEVEL_NOTICE,$type = self::MESSAGE_INDEX,$once = false){
	    $type = $type ? $type : self::MESSAGE_INDEX;
	    $key = self::GenKey($level,$type);
	    $message = Session::Get($key);
	    if($once){
	        Session::delete($key);
	    }
	    $message = trim($message,',');
	    return $message;
	}

    public static function SetMessage($message,$level = self::LEVEL_NOTICE,$type = self::MESSAGE_INDEX){
	    $type = $type ? $type : self::MESSAGE_INDEX;
	    $key = self::GenKey($level,$type);
	    $message = strval($message);
	    Session::Set($key, $message);
	    return true;
    }
    
    public static function SetError($message,$type = self::MESSAGE_INDEX){
	    return self::SetMessage($message,self::LEVEL_ERROR,$type);
	}
	
}