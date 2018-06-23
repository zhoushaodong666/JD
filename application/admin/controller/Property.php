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
    public function propertylist($property_pid=""){
        if($property_pid==''){
            $property_select = db('property')->select();
        }else{
            $property_select = db('property')->where('property_pid','eq',$property_pid)->select();
            if (empty($property_select)) {
                $this->redirect('property/propertylist');
            }
        }
        $cate_model = model('Cate');
        $cate_select  = db('cate')->select();

        static $property_info=array();
        foreach ($property_select as $key => $value) {
            $father=$cate_model->getFatherId($cate_select,$value['property_pid']);
            $value['father']= [$father[0],$father[1],$father[2]];
            $property_info[]=$value;
        }

        $cate_select=$cate_model->select();
        $catelist1=$cate_model->getChildren($cate_select);
        //获取无限级分类列表
        $this->assign('catelist1',$catelist1);
        $this->assign('property_info',$property_info);
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