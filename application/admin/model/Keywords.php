<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/4
 * Time: 15:42
 */
namespace app\admin\model;
use think\Model;

class Keywords extends Model {
    protected $resultSetType = 'collection';

    //关键字和商品多对一关系
    public function goods()
    {
       return $this->belongsToMany('Goods','jd_goods_keywords');
    }

}