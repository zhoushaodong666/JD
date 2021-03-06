<?php
namespace app\admin\controller;
use think\Controller;

if (!isset($_SESSION['imgupload']))
{
    session_start();
}
class Goods extends Common
{
    //显示添加商品的界面
    public function add()
    {
        if (cookie('imgupload'))
        {
            $cookie_arr=unserialize(cookie('imgupload'));
            foreach ($cookie_arr as $key=>$value) {
                $url_pre=DS.'jd'.DS.'public';
                $url=str_replace($url_pre,'.',$value);
                if (file_exists($url))
                {
                    unlink($url);
                }
            }
        }
        cookie('imgupload',null);
        unset($_SESSION['imgupload']);
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
        $post['goods_status'] = isset($post['goods_status'])?$post['goods_status']:'0';
        $post['goods_pid']=isset($post['goods_pid'])? $post['goods_pid']:null;
        $post['goods_after_price']=empty($post['goods_after_price'])?'0':$post['goods_after_price'];
        if ($post['goods_after_price']!=0){
            if ($post['goods_after_price']>=$post['goods_price']){
                unset($_SESSION['imgupload']);
                session('goods_thumb',null);
                $this->error('促销价格不能大于或等于商品价格');
            }
        }
        if (!isset($_SESSION['imgupload'])){
            session('goods_thumb',null);
            $this->error('请不要同时打开多个添加商品窗口','goods/add');
        }
        $imgupload = $_SESSION['imgupload'];
        $validate=validate('Goods');
        if (!$validate->check($post))
        {
            session('goods_thumb',null);
            unset($_SESSION['imgupload']);
            return $this->error($validate->getError());
        }
        $goods_add_result=db('goods')->insertGetId($post);
        if ($goods_add_result)
        {
            session('goods_thumb',null);
            $goods_model = new \app\admin\model\Goods;
            $goods = $goods_model->find($goods_add_result);
            foreach ($imgupload as $key => $value) {
                if ($value!='0'){
                    $goods->img()->save(['url'=>$value]);
                }
            }
            unset($_SESSION['imgupload']);
            return $this->success('商品添加成功','goods/goodslist');
        }else{
            unset($_SESSION['imgupload']);
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
        $goods_model = model('Goods');

        $cate_model=model('Cate');
        $cate_all=$cate_model->all()->toArray();
        //var_dump($cate_all);die;
        $cate_select=$cate_model->select();
        $catelist1=$cate_model->getChildren($cate_select);
        //获取无限级分类列表
        $this->assign('catelist1',$catelist1);
        $cate_find=db('cate')->find($goods_pid);

        if ($cate_find)
        {
            $goods_all=$goods_model->all(function ($query) use ($goods_pid){
                $query->where('goods_pid','eq',$goods_pid) ;
            });
            $this->assign('cate_find',$cate_find);

        }else {
            $goods_all=$goods_model->all();
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
            $this->assign('cate_find',"1");
        }
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
            //$this->assign('cate_find'," ");
            //var_dump($cate_find);
        //var_dump($goods_info);
            $this->assign('goods_info',$goods_info);
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
        session('goods_thumb',null);
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

        //获取商品细节图信息
        $img_select = db('img')->where('goods_id','eq',$goods_id)->select();
        if (isset($_SESSION['imgupload']))
        {
            foreach ($_SESSION['imgupload'] as $key => $value){
                $url_pre = DS . 'jd' . DS . 'public';
                $url = str_replace($url_pre, '.',$value);
                if (file_exists($url)) {
                    unlink($url);
                }
            }
        }
        unset($_SESSION['imgupload']);
        unset($_SESSION['old']);
        foreach ($img_select as $key => $value) {
            $_SESSION['imgupload'][]='1';
            $_SESSION['old'][]=$value['url'];
        }
        $this->assign('img_select',$img_select);
        return $this->fetch();
    }

    public function updhanddle()
    {
        $post=request()->post();
        $goods_info = db('goods')->find($post['goods_id']);
        $img_url = $goods_info['goods_thumb'];
        if ((session('goods_thumb')!=null)){
            $post['goods_thumb']=session('goods_thumb');
            $url_pre = DS . 'jd' . DS . 'public';
            $url = str_replace($url_pre, '.',$img_url);
            if (file_exists($url)) {
                unlink($url);
            }
        }else{
            $post['goods_thumb']=$img_url;
        }
        $post['goods_status']=isset($post['goods_status'])?'1':'0';

        $post['goods_pid']=isset($post['goods_pid'])? $post['goods_pid']:null;
        $post['goods_after_price']=empty($post['goods_after_price'])?'0':$post['goods_after_price'];
        if ($post['goods_after_price']!=0){
            if ($post['goods_after_price']>=$post['goods_price']){
                $this->error('促销价格不能大于或等于商品价格');
            }
        }
        $imgupload = $_SESSION['imgupload'];
        $validate=validate('Goods');
        if (!$validate->check($post))
        {
            return $this->error($validate->getError());
        }
        $upd_result=db('goods')->update($post);

        if ($upd_result!==false)
        {
            session('goods_thumb', null);
            $goods_model = new \app\admin\model\Goods;
            $goods = $goods_model->find($post['goods_id']);
            foreach ($imgupload as $key => $value) {
                if($value == '-1'){
                    //旧图片删除
                    db('img')->where('url','eq',$_SESSION['old'][$key])->delete();
                    $url_pre = DS . 'jd' . DS . 'public';
                    $url = str_replace($url_pre, '.',$_SESSION['old'][$key]);
                    if (file_exists($url)) {
                        unlink($url);
                    }
                }else if($value!='1' && $value!='0'){
                    //新增图片情况
                    $goods->img()->save(['url'=>$value]);
                }

            }
            unset($_SESSION['old']);
            unset($_SESSION['imgupload']);
            $this->success('商品修改成功','goods/goodslist');
        }else
        {
            unset($_SESSION['old']);
            unset($_SESSION['imgupload']);
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
        //删除商品对应的关键字
        $goods_keywords_del_result = db('goods_keywords')->where('goods_id','eq',$goods_id)->delete();
        //删除商品对应的细节图
        //1.使用数据库的方式删除
        //db('img')->where('goods_id','eq',$goods_id)->delete();
        //2.使用数据库模型删除
        $goods_model = model('Goods');
        $goods_get = $goods_model->get($goods_id);
        $goods_img = $goods_get->img()->select();
        $goods_img_toArray = $goods_img->toArray();
        //删除细节图文件
        foreach ($goods_img as $key => $value) {
            $url_pre = DS . 'jd' . DS . 'public';
            $url = str_replace($url_pre, '.',$value['url']);
            if (file_exists($url)) {
                unlink($url);
            }
        }
        //删除数据表中的细节图记录
        $goods_get->img()->delete();
        //删除数据表中的商品属性值记录
        $goods_get->goodsproperty()->delete();
        //删除数据表中的商品记录
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

    public function keywordsajax()
    {
        if (request()->isAjax()) {
            $post = request()->post();
            $post_val = $post['val'];
            $keywords_like = db('keywords')->where('keywords_name','like','%'.$post_val.'%')->limit(3)->select();
            return $keywords_like;
        }
    }

    public function keywordsaddhanddle()
    {
        $post = request()->post();
        $goods_id = array_keys($post)[0];
        $keywords_name = array_values($post)[0];
        if (empty($keywords_name))
        {
             $this->error('关键字不能为空','goods/goodslist');
        }
        $keywords_find = db('keywords')->where('keywords_name','eq',$keywords_name)->find();
        if (empty($keywords_find))
        {
            $this->error('该关键字不存在,请先添加','keywords/add');
        }
        $keywords_id = $keywords_find['keywords_id'];
        $goods_keywords_find = db('goods_keywords')->where('goods_id','eq',$goods_id)
            ->where('keywords_id','eq',$keywords_id)->find();
        if (! empty($goods_keywords_find))
        {
            return $this->redirect('goods/goodslist');
        }
        $keywords_id=$keywords_find['keywords_id'];
        $goods_model = model('goods');
        $goods = $goods_model->get($goods_id);
        $goods->keywords()->attach($keywords_id);
        return $this->redirect('goods/goodslist');
    }

    public function keywordsdelhanddle($goods_id="",$keywords_name="")
    {
        if (empty($goods_id)|empty($keywords_name))
        {
            return $this->redirect('goods/goodslist');
        }
        $goods_find = db('goods')->find($goods_id);
        if (empty($goods_find))
        {
            return $this->redirect('goods/goodslist');
        }
        $keywords_find = db('keywords')->where('keywords_name','eq',$keywords_name)->find();
        if (empty($keywords_find))
        {
            return $this->redirect('goods/goodslist');
        }
        $keywords_id = $keywords_find['keywords_id'];
        $goods_keywords_find = db('goods_keywords')->where('goods_id','eq',$goods_id)
                                ->where('keywords_id','eq',$keywords_id)->find();
        if (empty($goods_keywords_find))
        {
            return $this->redirect('goods/goodslist');
        }
        //
        $goods_model = model('goods');
        $goods = $goods_model->get($goods_id);
        $goods->keywords()->detach($keywords_id);
        $this->redirect('goods/goodslist');

    }

    //商品细节图上传响应
    public function imgupload(){
       $file = request()->file('goods_img');
       $info = $file->move(ROOT_PATH.'public'.DS.'uploads'.DS.'img');
       if($info)
       {
           $address = DS.'jd'.DS.'public'.DS.'uploads'.DS.'img'.DS.$info->getSaveName();
           $_SESSION['imgupload'][]=$address;
           $session_str = serialize($_SESSION['imgupload']);
           cookie('imgupload',$session_str,3600);
           return $address;
       }else{
           echo $file->getError();
       }
    }

    public function imgcancle()
    {
        if(request()->isAjax()) {
            $post = request()->post();
            $img_index = $post['index'];
            $img_address = $_SESSION['imgupload'][$img_index];

            if ($img_address == 1){
                $_SESSION['imgupload'][$img_index] = '-1';
            }else{
                $_SESSION['imgupload'][$img_index] = '0';
            }
            $url_pre = DS.'jd'.DS.'public';
            $url=str_replace($url_pre,'.',$img_address);
            if (file_exists($url)){
                unlink($url);
            }
        }
    }

    public function addproperty($goods_id="")
    {
        $goods_find = db('goods')->find($goods_id);
        if (!$goods_find){
            $this->redirect('goods/goodslist');
        }
        $this->assign('goods_find',$goods_find);

        //根据商品id查找相关的属性
        $property_select = db('property')->where('property_pid','eq',$goods_find['goods_pid'])->select();
        $this->assign('property_select',$property_select);

        $goods_model = model('goods');
        $goods = $goods_model->get($goods_id);
        $goodsproperty_select = $goods->goodsproperty()->select();
        $goodsproperty_select_toArray = $goodsproperty_select->toArray();
        $this->assign('goodsproperty_select_toArray',$goodsproperty_select_toArray);
        return $this->fetch();
    }

    //属性添加的处理方法
    public function addpropertyhanddle(){
        $post = request()->post();
        $goods_id = $post['goods_id'];
        $goods_model = model('goods');
        $goods = $goods_model->get($goods_id);
        $goodsproperty_select = $goods->goodsproperty()->select();
        $goodsproperty_select_toArray = $goodsproperty_select->toArray();
        $goodsproperty_propertyid = array_column($goodsproperty_select_toArray,'property_id');
        /**
        提交数据的四种情况
        1、原有属性已存在，新的属性不为空。进行更新。
        2、原有属性已存在，新的属性为空，进行删除。
        3、原有属性不存在，新的属性不为空，进行添加。
        4、原有属性不存在，新的属性为空，do nothing。
         */
        foreach ($post as $key=> $value) {
            //除了 good_id 其他都是需要的键名
            if ($key!='goods_id'){
                //只修改goodsproperty表中存在的数据
                if (in_array($key,$goodsproperty_propertyid)){
                    //删除传过来为空的属性
                    if ($value==''){
                        db('goodsproperty')->where(['property_id'=>$key,'goods_id'=>$goods_id])->delete();
                    }else{
                        //更新传过来的值不为空的属性
                        db('goodsproperty')->where(['property_id'=>$key,'goods_id'=>$goods_id])
                            ->update(['goodsproperty_content' => $value]);
                    }
                }else{
                    // 不存在goodsproerty表中的数据,不为空就插入新数据
                    if($value!=''){
                        $goods->goodsproperty()->save(['property_id'=>$key,'goodsproperty_content'=>$value]);
                    }
                }
            }
        }
        $this->redirect('goods/goodslist');
    }

}
