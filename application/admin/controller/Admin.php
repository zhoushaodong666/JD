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

    //后台管理员登录
    public function login()
    {
        return $this->fetch();
    }

    //后台管理员列表
    public function adminlist()
    {
        return $this->fetch();
    }

    //后台管理员添加
    public function addadmin()
    {
        return $this->fetch();
    }



}