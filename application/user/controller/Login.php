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
        if(empty($user_find)){
            //用户或密码错误的情况
            $this->error('用户或密码错误，请重新登录','user/login/login');
        }
        else if($user_find['user_email_active']=='0'){
            //用户邮箱没有激活的情况
            $this->error('该邮箱并未激活，请登录该邮箱进行激活',url('user/login/active',array('user_email'=>$user_find['user_email'])));
        }else{
            //用户邮箱已经激活的情况
            session('user_id',$user_find['user_id']);
            session('user_email',$user_find['user_email']);
            $this->success('登录成功！','index/index/index');
        }
    }

    public function loginout(){
        session('user',null);
        $this->redirect('index/index/index');
    }
}