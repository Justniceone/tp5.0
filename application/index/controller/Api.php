<?php
namespace app\index\controller;

use Lib\Redis;
use think\Config;
use think\Db;

class Api extends Base
{
    public function login()
    {
        $username = $this->request->param('username');
        $password = $this->request->param('password');
        $user = Db::name('users')->where(['username'=>$username,'password'=>$password])->find();
        if(!$user) return json(['code'=>400,'msg'=>'用户名或密码错误','data'=>[]]);
        $token = $this->createtoken($user['id']);
        $redis = new Redis();
        $redis->save('jwt'.$token,Config::get('app')['expire']);
        return json(['code'=>200,'msg'=>'','data'=>['token'=>$token,'expiration'=>$redis->ttl('jwt'.$token)]]);
    }

    public function verfy()
    {
        $token = $this->request->header('token');
        $payload = $this->verfyToken($token);
        var_dump($payload);
    }
}