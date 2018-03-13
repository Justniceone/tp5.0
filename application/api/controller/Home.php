<?php
namespace app\api\controller;
use think\cache\driver\Redis;
use think\Db;
use think\Log;
use think\Request;
use think\Validate;

class Home extends \BdmController
{
    public function login()
    {
        $this->response();
    }

    public function test($name='')
    {
        $request = Request::instance();
        $validate = new Validate([
            'name'  =>  'required|max:25',
            'age'   =>  'required'
        ]);

        $data = [
          'name' => $request->get('name'),
          'age' => $request->get('age'),
        ];

        if (!$validate->check($data)) {
            dump($validate->getError());
        }

        //echo $request->url();
        //echo $request->input('name');
        $post = $request->post();
    }

    public function db()
    {
        $lists = Db::name('user_headhuntings')
            ->join('relations','bdm_user_headhuntings.uid = relations.he_id')
            ->join('industries','relations.in_id = industries.id')
            ->group('bdm_user_headhuntings.uid')
            ->select();
        $this->response($lists);
    }

    public function log()
    {
        Log::write('测试一波日志记录');
    }

    public function redis()
    {
        $redis = new \Lib\Redis();
        echo '<pre/>';
        $redis->save('uid_6','xiaopang');
        echo $redis->get('uid_6');
    }
}