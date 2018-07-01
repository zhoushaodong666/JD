<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/26
 * Time: 21:53
 */

namespace app\admin\controller;
use think\Controller;

class Admin extends Common
{

    //后台管理员登录页面
    public function login()
    {
        return $this->fetch();
    }

    //后台管理员列表页面
    public function adminlist()
    {
        $admin_select = db('admin')->select();
        $this->assign('admin_select',$admin_select);
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

//    public function checkadminname1(){
//    if (request()->isAjax()){
//        $admin_name = request()->post('parm');
//        $admin_name_find_result = db('admin')->where('admin_name','eq',$admin_name)->find();
//        if ($admin_name_find_result){
//            return array(
//                'status'=>'n',
//                'info'=>'管理员'.$admin_name.'不可用',
//            );
//        }else{
//            return array(
//                'status'=>'y',
//                'info'=>'管理员'.$admin_name.'可用',
//            );
//        }
//    }
//}

    //管理员添加用户名ajax验证
    public function checkadminname(){
        if (request()->isAjax()){
            $post = request()->post();
            $data['admin_name'] = $post['param'];
            $validate = validate('Admin');
            if ($validate->scene('admin_name')->check($data)){
                return array('status'=>'y','info'=>'管理员名称可用');
            }else{
                return array('status'=>'n','info'=>$validate->getError());
            }
        }
    }

    //管理员修改 用户名ajax验证
    public function checkupdadminname(){
        if (request()->isAjax()) {
            $post = request()->post();
            $admin['admin_id'] = $post['name'];
            $admin['admin_name'] = $post['param'];
            $validate = validate('admin');
            if ($validate->scene('admin_name')->check($admin)) {
                return array('status'=>'y','info'=>'管理员名称可以使用');
            }
            else{
                return array('status'=>'n','info'=>$validate->getError());
            }
        }
    }

    //管理员修改页面
    public function upd($admin_id=""){
        $admin_find = db('admin')->find($admin_id);
        if (!$admin_find){
            $this->redirect('admin/adminlist');
        }
        $this->assign('admin_find',$admin_find);
        return $this->fetch();
    }

    //管理员修改提交处理
    public function updhanddle(){
        $post = request()->post();
        $post['admin_name'] = $post[$post['admin_id']];
        unset($post[$post['admin_id']]);
        $validate = validate('Admin');
        if ($validate->check($post)){
            unset($post['admin_repassword']);
            $post['admin_password'] = md5($post['admin_password']);
            $admin_upd_result = db('admin')->update($post);
            if ($admin_upd_result!==false){
                $this->success('管理员修改成功','admin/adminlist');
            }else{
                $this->error('管理员修改失败','admin/adminlist');
            }
        }else{
            $this->error($validate->getError(),'admin/adminlist');
        }
    }

    //管理员删除 提交处理
    public function del($admin_id=''){
        $admin_find = db('admin')->find($admin_id);
        if (empty($admin_find)){
            $this->redirect('admin/adminlist');
        }
        $admin_del_result = db('admin')->delete($admin_id);
        if ($admin_del_result){
            $this->success('管理员删除成功','admin/adminlist');
        }else{
            $this->error('管理员删除失败','admin/adminlist');
        }
    }



}