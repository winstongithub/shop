<?php
namespace app\api\validate;
use app\api\validate\BaseValidate;

class MerchantValidate extends BaseValidate{
     //对申请做验证
     public static function CheckApply($data){
        $rules = [
            ['shop_title','require','店铺名不得为空'],
            ['name','require','联系人姓名不得为空'],
            ['phone','require','联系人电话不得为空'],
        ];
        $validate = new self($rules);
        $result = $validate->check($data);
        if(!$result){
            error($validate->getError());
           // echo($validate->getError());
        }
        return $result;
    }   
}