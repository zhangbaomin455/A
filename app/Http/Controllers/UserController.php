<?php

namespace App\Http\Controllers;
use App\Common;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Tools\Captcha;
class UserController extends Controller

{
    /**登录 */
    public function login(){
        
        return view('login');
    }
    /**登录执行 */
    public function login_do(Request $request){
        $user_model=new Users;
        $where=[
            'user_tel'=>$request->user_tel
        ];
        $arr=$user_model->where($where)->first();
        if(!empty($arr)){
            if(decrypt($arr['user_pwd'])==$request->user_pwd){
                session(['user_id'=>$arr['user_id'],'user_tel'=>$arr['user_tel']]);
                echo json_encode(['font'=>'登录成功','code'=>1]);
            }else{
                echo json_encode(['font'=>'账号或密码错误','code'=>2]);exit;
            }
        }else{
            echo json_encode(['font'=>'账号或密码错误','code'=>2]);exit;
        }
    }
      /**注册 */
      public function register(){
        return view(' register');
    }
   
    //注册成功
    public function registerDo(Request $request)
    {
        $userMobile=$request->userMobile;
        if($userMobile==''){
            echo json_encode(['font'=>'手机号不能为空','code'=>2]);exit;
        }
        $userpwd=$request->pwd;
        if($userpwd==''){
            echo json_encode(['font'=>'密码不能为空','code'=>2]);exit;
        }
        $userconpwd=$request->conpwd;
        if($userconpwd==''){
            echo json_encode(['font'=>'确认密码不能为空','code'=>2]);exit;
        }else if($userpwd!=$userconpwd){
            echo json_encode(['font'=>'确认密码与密码不一致','code'=>2]);exit;
        }
        $usercode=$request->usercode;
        if($usercode==''){
            echo json_encode(['font'=>'验证码不能为空','code'=>2]);exit;
        }
        $code=session('code');
        if($code==''){
            echo json_encode(['font'=>'验证码已过期，请从新获取','code'=>2]);exit;
        } else if($code==$usercode){
            $address=session('address');
            if($address==$userMobile){
                $usermodel=new Users;
                $usermodel->user_tel=$userMobile;
                $usermodel->user_pwd=encrypt($userpwd);
                $usermodel->user_code=$usercode;
                $res=$usermodel->save();
                if($res){
                    session(['user_id'=>$usermodel->user_id,'user_name'=>$userMobile]);
                    echo json_encode(['font'=>'注册成功','code'=>1]);
                }else{
                    echo json_encode(['font'=>'注册失败','code'=>2]);exit;
                }
            }else{
                echo json_encode(['font'=>'手机号错误','code'=>2]);exit;
            }
        }else{
            echo json_encode(['font'=>'验证码错误','code'=>2]);exit;
        }
    }
    //发短信
    public function sendMobile(Request $request)
    {
        $address=$request->userMobile;
        $code=Common::createcode(4);
        $res=Common::sendSms($address,$code);
        if($res){
            session(['code'=>$code,'address'=>$address,],180);
            echo 1;
        }else{
            echo 2;
        }
    }


//    /** 阿里云发送短信 */
//    private function sendMobile($mobile){
//        $host = env("MOBILE_HOST");
//        $path = env("MOBILE_PATH");
//        $method = "POST";
//        $appcode = env("MOBILE_APPCODE");
//        $headers = array();
//        $code=Common::createcode(4);
//        session(['code'=>$code,'mobile'=>$mobile,'sendtime'=>time()]);
//        array_push($headers, "Authorization:APPCODE " . $appcode);
//        $querys = "content=【创信】你的验证码是：".$code."，3分钟内有效！&mobile=".$mobile;
//        $bodys = "";
//        $url = $host . $path . "?" . $querys;
//
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($curl, CURLOPT_FAILONERROR, false);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_HEADER, true);
//        if (1 == strpos("$".$host, "https://"))
//        {
//            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//        }
//        var_dump(curl_exec($curl));
//
//    }

    /**获取验证码 */
    public function create()
    {
        $verify = new Captcha();
        $code = $verify->getCode();
        //var_dump($code);
       session(['verifycode'=>$code]);
       return $verify->doimg();


    }
}
