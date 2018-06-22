<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/22
 * Time: 18:54
 */

namespace app\admin\controller;

use think\Controller;

class Property extends Controller
{
    public function propertylist(){

        return $this->fetch();
    }

    public function add()
    {
        $cate_model=model('Cate');
        $cate_select=$cate_model->select();

        $catelist1=$cate_model->getChildren($cate_select);
        $this->assign('catelist1',$catelist1);
        return $this->fetch();
    }

    public function addhanddle()
    {
        $post = request()->post();
        $post['property_pid']=isset($post['property_pid'])?$post['property_pid']:'0';
        $validate = validate('Property');
        if(!$validate->check($post)){
            return $this->error($validate->getError());
        }
        $property_add_result = db('property')->insert($post);
        if ($property_add_result){
            return $this->success('添加属性成功');
        }else{
            return $this->error('添加属性失败');
        }
    }
}