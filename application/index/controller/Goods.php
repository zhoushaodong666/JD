<?php
namespace app\index\controller;
use think\Controller;

class Goods extends Controller
{
    public function goodslist1($goods_pid="")
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

    public function goodslist($goods_pid="",$goods_order="id")
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
        if ($goods_order=='goods_sales')
        {
            $goods_order='goods_sales desc';
        }
        elseif ($goods_order=='goods_price_asc')
        {
            $goods_order='goods_price';
        }
        elseif($goods_order=='goods_price_desc')
        {
            $goods_order='goods_price desc';
        }
        else{
            $goods_order="goods_id";
        }
        $goods_model = new \app\admin\model\Goods;

        $cate_model=new \app\admin\model\Cate;
        $cate_all=$cate_model->all()->toArray();

        $goods_all=$goods_model->all(function ($query) use ($goods_pid,$goods_order){
            $query->where('goods_pid','eq',$goods_pid)->where('goods_status','eq','1')->order($goods_order);
        });


        $goods_all_toArray = $goods_all->toArray();
        $goods_info = array();
        foreach ($goods_all_toArray as $key=>$value)
        {
            $goods_get = $goods_model->get($value['goods_id']);
            $goods_keywords=$goods_get->keywords;
            $goods_keywords_toArray=$goods_keywords->toArray();
            $value['keywords']=$goods_keywords_toArray;
            $goods_cate = $goods_get->cate;
            $goods_cate_toArray = $goods_cate->toArray();
            $value['cate_name']=$goods_cate_toArray['cate_name'];
            $goods_info[] = $value;
        }
        $this->assign('goods_pid',$goods_pid);
        $this->assign('goods_info',$goods_info);
        return $this->fetch();
    }

    public function introduction($goods_id="")
    {
        if ($goods_id==''){
            $this->redirect('index/index');
        }
        $goods_find = db('goods')->find($goods_id);
        if (empty($goods_find)){
            $this->redirect('index/index');
        }
        $goods_status = $goods_find['goods_status'];
        if ($goods_status == 0)
        {
            $this->redirect('index/index');
        }
        $goods_model = new \app\admin\model\Goods;
        $goods_get = $goods_model->get($goods_id);
        $goods_get_toArray = $goods_get->toArray();
        //获取商品关键字
        $goods_keywords = $goods_get->keywords;
        $goods_keywords_toArray = $goods_keywords->toArray();
        $goods_get_toArray['keywords']=$goods_keywords_toArray;

        //获取商品细节图
        $goods_img = $goods_get->img;
        $goods_img_toArray = $goods_img->toArray();
        $goods_get_toArray['img']=$goods_img_toArray;

        //获取商品属性
        $goods_goodsproperty = $goods_get->goodsproperty;
        $goods_goodsproperty_toArray = $goods_goodsproperty->toArray();
        $goods_get_toArray['goodsproperty']=$goods_goodsproperty_toArray;

        $this->assign('goods_introduction',$goods_get_toArray);
        var_dump($goods_get_toArray);


        //商品类别定位
        $goods_pid = $goods_find['goods_pid'];
        $cate_select = db('cate')->select();
        $cate_model = new \app\admin\model\Cate;
        $cate_in = $cate_model->getFatherId($cate_select,$goods_pid);
        $this->assign('cate_in',$cate_in);
        return $this->fetch();
    }


}
