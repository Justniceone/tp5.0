<?php
namespace app\index\controller;

use app\index\model\User;
use app\index\model\UserHeadhunting;
use Firebase\JWT\JWT;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\Validate;

class Home extends Controller
{
    //用户登录
    public function login()
    {
        if( Request::instance()->isPost() )
        {
            $username = Request::instance()->post('username');
            $password = Request::instance()->post('password');

            $model = User::get(['username'=>$username,'password'=>$password]);
            if(!$model)
            {
                echo '用户名或密码错误';
                exit;
            }
            $model = $model->toArray();
            //用户ID和用户名存入session
            Session::set('uid',$model['id']);
            Session::set('uname',$model['username']);
            $this->success('登录成功','article/lists');
        }
        return $this->fetch('login');
    }

    //退出登录
    public function logout()
    {
        Session::set('uid',null);
        Session::set('uname',null);
        $this->redirect('/index/home/login');
    }

    public function test()
    {
        $str = file_get_contents('http://edu.51cto.com/t/exam/list/id-25.html');
        preg_match_all('/<ul class="subNav">([\S\s]*?)<\/ul>\n            <div class="navbl"><\/div>/m',$str,$matches);
        var_dump($matches);
    }

    public function test2()
    {
        print_r($this->request->param());
        print_r(input());
    }

    public function test3()
    {
        //$lists = Db::name('user_headhuntings')->select();
        $lists = UserHeadhunting::paginate(3);
        return  $this->fetch('lists',['lists'=>$lists]);
        /*$user = User::where('id','=',1)->find()->toArray();
        var_dump($user);*/
    }

    public function test4()
    {

    }
}