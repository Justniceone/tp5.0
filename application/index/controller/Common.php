<?php
namespace app\index\controller;

use think\Controller;
use think\Session;

class Common extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if( !Session::get('uid') or !Session::get('uname') )
        {
            $this->redirect('/index/home/login');
        }
    }
}