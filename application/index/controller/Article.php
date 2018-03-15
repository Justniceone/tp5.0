<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Article extends Common
{
    //文章列表
    public function lists()
    {
        $lists = Db::name('articles')->select();
        return $this->fetch('article',['lists'=>$lists]);
    }

    //添加
    public function create()
    {
        if(Request::instance()->isPost())
        {
            $data['title'] = Request::instance()->post('title');
            $data['content'] = Request::instance()->post('content');
            $data['author'] = Request::instance()->post('author');
            $data['view'] = 0;
            $data['publish_at'] = date('Y-m-d H:i:s');

            $article = new \app\index\model\Article();
            $article->data($data);
            $article->save();
            $this->redirect('/index/article/lists');
        }
        return $this->fetch('create');
    }
}