<?php
namespace app\api\controller;
use think\Controller;
use think\Request;

class Article extends Controller
{
    public function create()
    {
        if(1)
        {
            $model =new \app\api\model\Article();
            $model->data([
                'title' => '',
                'author' => '',
                'content' => '',
            ]);
            $model->save();
        }
       return $this->fetch('create');
    }

    public function delete()
    {
        $id = Request::instance()->get('id');
        $article = \app\api\model\Article::get($id);
        $article->delete();
    }
}