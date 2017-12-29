<?php
namespace app\api\controller\merchant;

use app\api\controller\APIControllerBase;
use think\Request;
use app\api\service\MerchantService;
class User extends APIControllerBase{
    public function apply()
    {
        $applyData = Request::instance()->only(['shop_title','phone','shop_address','name']);
        $result = MerchantService::Apply($applyData);
        return json_encode($result);
    }
}
