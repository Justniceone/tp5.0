<?php
class BdmController extends \think\Controller
{
    protected function response($data = [])
    {
        header('Content-Type:application/json');
        echo json_encode(
            [
                'code'  =>  200,
                'msg'   =>  '',
                'data'  =>$data,
            ]
        );
        exit;
    }
}