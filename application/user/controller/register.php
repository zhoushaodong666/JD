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

    //用户注册提交处理方法
    public function registerhanddle(){
        $post = request()->post();
        unset($post['user_repassword']);
        $post['user_password'] = md5($post['user_password']);
        $user_register_result = db('user')->insert($post);
        if ($user_register_result){
            $this->success('恭喜用户注册成功','index/index/index');
        }else{
            $this->error('用户注册失败');
        }
    }

    public function checkuseremail(){
        if (request()->isAjax()){
            $post = request()->post();
            var_dump($post);
        }
    }
}