<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/7/7
 * Time: 18:49
 */

namespace app\user\controller;
use think\Controller;

//用户模块登录控制器
class Login extends Controller
{
    public function login(){
        return $this->fetch();
    }

    public function loginhanddle(){
        $post = request()->post();
        $user_email = $post['user_email'];
        $user_password = md5($post['user_password']);
        $user_find = db('user')->where('user_email','eq',$user_email)->where('user_password','eq',$user_password)->find();
        if ($user_find){
            session('user',$user_email);
            $this->success('登录成功','index/index/index');
        }else{
            $this->error('用户名或密码错误');
        }
    }

    public function loginout(){
        session('user',null);
        $this->redirect('index/index/index');
    }
}