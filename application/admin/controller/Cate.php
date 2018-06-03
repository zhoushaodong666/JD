<?php
namespace app\admin\controller;
use think\Controller;
use think\Page;
class Cate extends Controller
{
    //显示分类列表
    public function catelist()
    {
        $cate_model=model('Cate');
        $cate_select=$cate_model->order('cate_sort')->select();
        $catelist=$cate_model->getChildrenId($cate_select);
        //获取无限级分类列表
        $this->assign('catelist',$catelist);
        return $this->fetch();
    }

    //显示添加分类列表
    public function add()
    {
        $cate_model=model('Cate');
        $cate_select=$cate_model->select();
        $catelist=$cate_model->getChildrenId($cate_select);
        $this->assign('catelist',$catelist);
        return $this->fetch();
    }

    //处理添加分类
    public function addhanddle()
    {
        $post=request()->post();
        if (db('cate')->insert($post))
        {
            $this->success('添加分类成功','cate/catelist');
        }else{
            $this->error('添加分类失败','cate/catelist');
        }
    }
    //显示修改分类
    public function upd($cate_id="")
    {
        if($cate_id=="")
        {
            $this->redirect('cate/catelist');
        }
        $cate_find=db('cate')->find($cate_id);
        if ($cate_find=="")
        {
            $this->redirect('cate/catelist');
        }
        $cate_model=model('Cate');
        $cate_select=$cate_model->select();
        $catelist=$cate_model->getChildrenId($cate_select);
        //获取无限级分类列表
        $this->assign('catelist',$catelist);
        $this->assign('cate_find',$cate_find);


        return $this->fetch();
    }

    //处理分类修改
    public function updhanddle()
    {
        $post=request()->post();
        $cate_upd_result=db('cate')->update($post);
        if ($cate_upd_result!==false)
        {
            $this->success('修改分类成功','cate/catelist');
        }else{
            $this->error('修改分类成功','cate/catelist');
        }
    }

    //处理分类删除
    public function del($cate_id="")
    {
        if ($cate_id=="")
        {
            $this->redirect('cate/catelist');
        }
        $cate_find=db('cate')->find($cate_id);
        if ($cate_find=="")
        {
            $this->redirect('cate/catelist');
        }
        $cate_model=model('Cate');
        $cate_select=$cate_model->select();
        $catelist=$cate_model->getChildrenId($cate_select,$cate_id);
        $catelist[]=$cate_find;
        foreach ($catelist as $key => $value) {
            $cate_del_result=db('cate')->where('cate_id','=',$value['cate_id'])->delete();
        }
        $this->redirect('cate/catelist');
    }

    public function sort()
    {
        $post=request()->post();
        if ($post)
        {
            foreach ($post as $key => $value) {
                db('cate')->update([
                    'cate_id'=>$key,
                    'cate_sort'=>$value,
                    ]
                );
            }
            $this->redirect('cate/catelist');
        }else{
            $this->redirect('cate/catelist');
        }
    }

}
