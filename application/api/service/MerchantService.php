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
            $id = db('merchant_apply')->insertGetId($applyData);            
        } catch (Exception $e){
            error('数据库插入失败',APP_CODE_DB);
            return false;
        }
        
        return true;
    }

        //商户登陆
        public static function Login($phone,$password){
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            $user = db('user')->where(['phone' => $phone,'status' => UserConfig::STATUS_NORMAL,'type' => ['in',[UserConfig::TYPE_MANAGER,UserConfig::TYPE_MERCHANT]]])->find();
            
            if(!$user || !password_verify($password, $user['password'])){
                error('手机号密码错误');
                return false;
            }
            
            if($user['type'] == UserConfig::TYPE_MANAGER){
                $merchant = db('merchant')->where('id',$user['merchant_id'])->find();
            } else {
                $merchant = db('merchant')->where(['uid' => $user['id']])->find();
            }
            
            $expireTime = time() + 7 * 86400;
            $token = array(
                'uid' => $user['id'],
                'create_time' => time(),
                'expire' => $expireTime,
            );
            $token = UserTokenService::GenToken($user['id']);
            
            $user = [
                'id' => $user['id'],
                'type' => $user['type'],
                'name' => $user['name'],
                'sex' => $user['sex'],
                'phone' => $user['phone'],
            ];
            
            $result = array(
                'token' => $token,
                'merchant' => $merchant,
                'user' => $user,
            );
            return $result;
        }
}