<?php
namespace app\admin\controller;
use think\Controller;
class Goods extends Controller
{
    //显示添加商品的界面
    public function add()
    {
        if (session('goods_thumb'))
        {
            $url_pre=DS.'jd'.DS.'public';
            $url=str_replace($url_pre,'.',session('goods_thumb'));
            if (file_exists($url))
            {
                unlink($url);
            }
        }
        session('goods_thumb',null);
        $cate_model=model('Cate');
        $cate_select=$cate_model->select();
        $catelist=$cate_model->getChildrenId($cate_select);
        $this->assign('catelist',$catelist);

        $catelist1=$cate_model->getChildren($cate_select);
        $this->assign('catelist1',$catelist1);
        return $this->fetch();
    }

    //利用插件上传图片的方法
    public function uploadthumb(){
        if (session('goods_thumb')){
            $url_pre = DS.'jd'.DS.'public';
            $url = str_replace($url_pre,'.',session('goods_thumb'));
            if (file_exists($url)) {
                unlink($url);
            }
        }
        $file = request()->file('goods_thumb');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $address = DS.'jd'.DS.'public' . DS . 'uploads'.DS.$info->getSaveName();
            session('goods_thumb',$address);
            return $address;
        }else{
            echo $file->getError();
        }
    }

    //处理添加商品
    public function addhanddle()
    {
        $post=request()->post();
        $post['goods_thumb']=session('goods_thumb');
        $post['goods_status']=isset($post['goods_status'])? $post['goods_status']:'0';
        $post['goods_pid']=isset($post['goods_pid'])? $post['goods_pid']:null;

        $validate=validate('Goods');
        if (!$validate->check($post))
        {
            return $this->error($validate->getError());
        }
        $goods_add_result=db('goods')->insert($post);
        if ($goods_add_result)
        {
            session('goods_thumb',null);
            return $this->success('商品添加成功','goods/goodslist');
        }else{
            session('goods_thumb',null);
            return $this->error('商品添加失败','goods/goodslist');
        }

    }

    //实时删除缩略图
    public function canclethumb()
    {
        if (request()->isAjax()) {
            if (session('goods_thumb')) {
                $url_pre = DS . 'jd' . DS . 'public';
                $url = str_replace($url_pre, '.', session('goods_thumb'));
                if (file_exists($url)) {
                    unlink($url);
                }
            }
            session('goods_thumb', null);
        }
    }

    //显示商品列表
    public function goodslist($goods_pid="")
    {
        $cate_model=model('Cate');
        $cate_select=$cate_model->select();
        $catelist1=$cate_model->getChildren($cate_select);
        //获取无限级分类列表
        $this->assign('catelist1',$catelist1);
        $cate_find=db('cate')->find($goods_pid);
        if ($cate_find)
        {
            $goods_select = db('goods')->where('goods_pid','=',$goods_pid)
                ->join('cate','jd_goods.goods_pid = cate.cate_id')->paginate(3);
            $this->assign('cate_find',$cate_find);

        }else {
            $goods_select = db('goods')->join('cate', 'jd_goods.goods_pid = cate.cate_id')->paginate(3);
            $this->assign('cate_find',"1");
        }
            //$this->assign('cate_find'," ");
            $this->assign('goods_select', $goods_select);
            //var_dump($cate_find);
            return $this->fetch();
        }


    //显示商品列表
//    public function goodslist1()
//    {
//        $goods_select = db('goods')->join('cate','jd_goods.goods_pid = cate.cate_id')->paginate(3);
//        $this->assign('goods_select',$goods_select);
//        return $this->fetch();
//    }
    //显示商品更新界面
    public function upd($goods_id="")
    {
        if ($goods_id=="")
        {
            $this->redirect('goods/goodslist');
        }
        $goods_find = db('goods')->find($goods_id);
        if (empty($goods_find)) {
            $this->redirect('goods/goodslist');
        }
        if (session('goods_thumb')!=$goods_find['goods_thumb'])
        {
            $url_pre=DS.'jd'.DS.'public';
            $url=str_replace($url_pre,'.',session('goods_thumb'));
            if (file_exists($url))
            {
                unlink($url);
            }
        }
        session('goods_thumb',$goods_find['goods_thumb']);
        $cate_model=model('Cate');
        $cate_select=$cate_model->select();
        $cate_in=$cate_model->getFatherId($cate_select,$goods_find['goods_pid']);
        $catelist1=$cate_model->getChildren($cate_select);
        $this->assign([
                    'catelist1'=>$catelist1,
                    'goods_find'=>$goods_find,
                    'cate_in'=>$cate_in,
            ]
        );
        return $this->fetch();
    }

    public function updhanddle()
    {
        $post=request()->post();
        $post['goods_thumb']=session('goods_thumb');
        $post['goods_status']=isset($post['goods_status'])? $post['goods_status']:'0';
        $post['goods_pid']=isset($post['goods_pid'])? $post['goods_pid']:null;
        $validate=validate('Goods');
        if (!$validate->check($post))
        {
            return $this->error($validate->getError());
        }
        $upd_result=db('goods')->update($post);

        if ($upd_result!==false)
        {
            session('goods_thumb', null);
            $this->success('商品修改成功','goods/goodslist');
        }else
        {
            session('goods_thumb', null);
            $this->error('商品修改失败','goods/goodlist');
        }

    }

    //处理商品删除
    public function del($goods_id="")
    {
        if ($goods_id=="")
        {
            $this->redirect('goods/goodslist');
        }
        $goods_find = db('goods')->find($goods_id);
        if (empty($goods_find)) {
            $this->redirect('goods/goodslist');
        }
        $goods_del_result=db('goods')->delete($goods_id);
        if ($goods_del_result){
            if ($goods_find['goods_thumb'])
            {
                $url_pre=DS.'jd'.DS.'public';
                $url=str_replace($url_pre,'.',$goods_find['goods_thumb']);
                if (file_exists($url))
                {
                    unlink($url);
                }
            }
            $this->success('商品删除成功','goods/goodslist');
        }
        else{
            $this->error('商品删除失败','goods/goodslist');
        }


    }



}
