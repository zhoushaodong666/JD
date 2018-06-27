<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/26
 * Time: 21:53
 */

namespace app\admin\controller;
use think\Controller;

class Admin extends Controller
{

    //后台管理员登录页面
    public function login()
    {
        return $this->fetch();
    }

    //后台管理员列表页面
    public function adminlist()
    {
        return $this->fetch();
    }

    //后台管理员添加页面
    public function add()
    {
        return $this->fetch();
    }

    //后台管理员添加，提交处理
    public function addhanddle()
    {
        $post = request()->post();
        $validate = validate('Admin');
        if($validate->check($post)){
            unset($post['admin_repassword']);
            $post['admin_password'] = md5($post['admin_password']);
            $admin_add_result = db('admin')->insert($post);
            if ($admin_add_result){
                $this->success('管理员添加成功');
            }else{
                $this->success('管理员添加失败');
            }
        }else{
            return $this->error($validate->getError());
        }

    }



}