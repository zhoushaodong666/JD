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
    public function login(){

        return $this->fetch();
    }

    public function checklogin(){
        $post = request()->post();
        $admin_find = db('admin')->where('admin_name','eq',$post['admin_name'])->find();
        if (empty($admin_find)){
            $this->error('该管理员用户名不存在,请重新登录');
        }else{
            $admin_password = $admin_find['admin_password'];
            if (md5($post['admin_password'])==$admin_password){
                $this->success('管理员登录成功，正在跳转..','index/index');
            }else{
                $this->error('管理员密码错误，正在跳转..');
            }
        }

    }
}