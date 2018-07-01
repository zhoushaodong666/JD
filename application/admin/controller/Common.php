<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/7/1
 * Time: 16:22
 */

namespace app\admin\controller;
use think\Controller;

class Common extends Controller
{
    //判断是否登录，未登录的跳转到登录页面
    public function _initialize(){
        if (!session('?admin_name')){
            $this->error('您还没有登录','login/login');
        }
    }

}