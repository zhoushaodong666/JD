<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/7/1
 * Time: 15:30
 */

namespace app\admin\controller;
use think\Controller;

class Login extends Controller
{
    //登录显示
    public function login(){
        if (session('?admin_name')){
            $this->error('您已登录，请先退出','index/index');
        }
        return $this->fetch();
    }

    //登录验证
    public function checklogin(){
        $post = request()->post();
        if(empty($post)){
            $this->redirect('login/login');
        }
        if (!captcha_check($post['captcha'])){
            $this->error('验证码错误');
        }

        $admin_find = db('admin')->where('admin_name','eq',$post['admin_name'])->find();
        if (empty($admin_find)){
            $this->error('该管理员用户名不存在,请重新登录');
        }else{
            $admin_password = $admin_find['admin_password'];
            if (md5($post['admin_password'])==$admin_password){
                session('admin_name',$admin_find['admin_name']);
                session('admin_id',$admin_find['admin_id']);
                $this->success('管理员登录成功，正在跳转..','index/index');
            }else{
                $this->error('管理员密码错误，正在跳转..');
            }
        }
    }

    //退出登录
    public function logout(){
        session('admin_name',null);
        session('admin_id',null);
        $this->redirect('login/login');
    }
}