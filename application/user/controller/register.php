<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/7/3
 * Time: 20:00
 */
namespace app\user\controller;
use think\Controller;

class Register extends Controller
{
    //用户注册页面显示
    public function register(){
        return $this->fetch();
    }

    //用户注册提交处理的方法
    public function registerhanddle(){
        $post = request()->post();
        var_dump($post);die;

    }
}