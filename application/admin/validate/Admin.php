<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/27
 * Time: 17:58
 */

namespace app\admin\validate;
use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'admin_name'  =>  'require|alphaNum|unique:admin,admin_name|length:3,10',
        'admin_password'  =>  'require|length:3,10',
        'admin_repassword'  =>  'require|confirm:admin_password',
    ];

    protected  $message = [
        'admin_name.require'        =>'管理员名称不能为空',
        'admin_name.alphaNum'        =>'管理员名称只能为数字和字母',
        'admin_name.unique'         =>'该管理员名称已存在，请修改',
        'admin_name.length'         =>'管理员名称长度要在3-10之间',
        'admin_password.require'    =>'管理员密码不能为空',
        'admin_password.length'     =>'管理员密码长度要在3-10之间',
        'admin_repassword.confirm  '=>'管理员两次密码不一致',
        'admin_repassword.require  '=>'管理员重复密码不能为空',
    ];

    protected  $scene = [
        'admin_name'    =>  ['admin_name'],
    ];
}