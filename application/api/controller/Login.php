<?php
namespace app\api\controller;

use app\api\model\Article;
use app\api\model\User;
use Firebase\JWT\JWT;
use think\Config;
use think\Controller;
use think\Db;
use think\Request;
use think\Validate;

class Login extends Controller
{
    public function jwt()
    {

    }

    public function decodejwt()
    {
        $token = Request::instance()->header('token');
        $obj = JWT::decode($token,'awdagsrgdhdjfkiljolyft',['HS256']);
        var_dump($obj);
    }

    /**
     * 创建用户token
     *
     * @param $user_id
     * @return mixed
     */
    protected function createUserToken($user_id,$operator=0)
    {
        $token = $this->jwt->encode(
            array(
                'user_id' => $user_id,
                'is_operator'=>$operator, //是否是管理员登录 管理员登录为1，其他为0
                'exp' => time() + Config::get('app')['expire'],
            ), Config::get('app')['key']
        );

        //$this->cache->redis->save('jwt:' . $token, $user_id, $this->config->item('jwt_exp'));

        return $token;
    }

    public function signin()
    {
        return $this->fetch('signin');
    }
    public function check()
    {
        $username = Request::instance()->post('username');
        $password = Request::instance()->post('password');

        $validate = new Validate([
            'username'  => 'require|min:2',
            'password' => 'require|min:3',
        ]);

        if (!$validate->check(['username'=>$username,'password'=>$password])) {
            dump($validate->getError());
            exit;
        }
        //验证用户名是否正确
        $user = User::get(['username'=>$username,'password'=>$password]);
        if(!$user)
        {
            echo '用户名或密码错误';
            exit;
        }
        $lists = Db::name('articles')->select();
        //collection($lists)->toArray();
        return $this->fetch('article',['lists'=>$lists]);
    }

    public function test()
    {
        $lists = Db::name('users')->select();
        print_r($lists);
    }
}