<?php
namespace app\api\validate;

use think\Validate;
class BaseValidate extends Validate{
    public static function CheckMobile($mobile){
        $rule = [
            ['mobile','mobile','手机号格式错误'],
        ];
        $data = ['mobile' => $mobile];
        $validate = new self($rule);
        if($validate->check($data)){
            return true;
        }
        error($validate->getError());
        return false;
    }
    
    protected  function mobile($value,$rule,$data){
        $mobilePattern = "/^1[345678]\\d{9}$/";
        
        if(preg_match($mobilePattern, $value)) return true;
        return false;
    }
}