<?php
namespace app\index\controller;
use think\Controller;

class Goods extends Controller
{
    public function goodslist($goods_pid="")
    {
        if ($goods_pid=="")
        {
            $this->redirect('index/index');
        }
        $goods_find=db('goods')->where('goods_pid','=',$goods_pid)
            ->where('goods_status','=',1)->select();
        if (empty($goods_find))
        {
            $this->redirect('index/index');
        }
        $goods_select=db('goods')->where('goods_pid','=',$goods_pid)
            ->where('goods_status','=',1)->paginate(4);
        $this->assign('goods_select',$goods_select);
//        var_dump($goods_select);
        return $this->fetch();
    }
}
