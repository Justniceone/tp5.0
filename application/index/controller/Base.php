<?php
namespace app\index\controller;
use Firebase\JWT\JWT;
use think\Config;
use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->verfysign();
    }

    protected $_user_id;
    protected function createtoken($uid,$is_admin=0)
    {
        $payload = [
            'uid' => $uid,
            'is_admin' => $is_admin,
            'exp' => time() + Config::get('app')['expire'],
        ];
        $key = Config::get('app')['key'];
        $token = Jwt::encode($payload,$key);
        return $token;
    }

    protected function verfysign()
    {
        $token = $this->request->header('token');
        if($token)
        {
            $verfy = $this->verfyToken($token);
            if(!$verfy)
            {
                //return json(['code'=>400,'msg'=>'认证失败,请从新登录','data'=>[]]);
                header('content-type:application/json');
                echo json_encode(['code'=>400,'msg'=>'认证失败,请从新登录','data'=>[]]);
                exit;
            }
        }
    }

    protected function verfyLogin()
    {
        if(!$this->_user_id)
        {
            $token = $this->request->header('token');
            if(!$token) return json(['code'=>401,'msg'=>'请先登录','data'=>[]]);
            $verfy_token = $this->verfyToken($token);
            if(!$verfy_token) return json(['code'=>401,'msg'=>'请先登录','data'=>[]]);
        }
    }

    protected function verfyToken($token)
    {
        if(!$token) return false;
        try
        {
            $key = Config::get('app')['key'];
            $payload = JWT::decode($token,$key);
            if(!$payload) return false;
            $this->_user_id = $payload['uid'];
            return $payload;
        }catch (\UnexpectedValueException $e)
        {
            return false;
        }

    }
}