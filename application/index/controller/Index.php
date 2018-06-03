<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $cate_select=db('cate')->order('cate_sort')->select();
        $cate_model=model('cate');
        $cate_list=$cate_model->getChildren($cate_select);
        $this->assign('cate_list',$cate_list);
        return $this->fetch();
    }
}
