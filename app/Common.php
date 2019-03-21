<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Tools\sms\lib\Ucpaas;

class Common extends Model
{

    //生成随机码
    public static function createcode($len)
    {
        $code='';
        for($i=1;$i<=$len;$i++){
            $code.=mt_rand(0,9);
        }
        return $code;
    }
    //云之讯发送验证码
    public static function sendSms($address,$code)
    {
        //填写在开发者控制台首页上的Account Sid
        $options['accountsid']='8353867bc8c408ef00be691b09435045';
        //填写在开发者控制台首页上的Auth Token
        $options['token']='b26a8e4f1c1c1e705a4d0301df4906a0';

        //初始化 $options必填
        $appid = "3a2e2c4dfa61449183b2bd29ac9a3b14";	//应用的ID，可在开发者控制台内的短信产品下查看
        $templateid = "444799";    //可在后台短信产品→选择接入的应用→短信模板-模板ID，查看该模板ID

        //以下是发送验证码的信息
        $param = $code; //验证码 多个参数使用英文逗号隔开（如：param=“a,b,c”），如为参数则留空
        $mobile = $address; // 手机号
        // $uid =  config('sms.sms_uid');
        $uid =  "";
        $ucpass = new Ucpaas($options);
        $status = $ucpass->SendSms($appid, $templateid, $param, $mobile, $uid);
        if($status) {
            return true;
        }else{
            return false;
        }
    }
}
