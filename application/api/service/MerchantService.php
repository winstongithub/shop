<?php
namespace app\api\service;
use app\api\validate\MerchantValidate;

class MerchantService{
        //商户申请
    public static function Apply($applyData){
        if(!MerchantValidate::CheckApply($applyData)){
            return false;
        }
        
        try {
            $id = db('merchant_apply')->find(["id"=>1]);//->insertGetId($applyData);            
        } catch (Exception $e){
            error('数据库插入失败',APP_CODE_DB);
            return false;
        }
        
        return true;
    }
}