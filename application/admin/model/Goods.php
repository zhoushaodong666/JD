<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/4
 * Time: 15:52
 */

namespace app\admin\model;

use think\Model;
    class Goods extends Model
    {
        protected $resultSetType = 'collection';

        //商品和关键字的多对多关系
        public function keywords()
        {
            return $this->belongsToMany('Keywords','jd_goods_keywords');
        }

        //商品和分类的一对多关系
        public  function cate()
        {
            return $this->belongsTo('Cate','goods_pid');
        }

        //商品和商品细节图的一对多关系
        public function img()
        {
            return $this->hasMany('Img');
        }

        //商品和属性的一对多关系
        public function goodsproperty(){

            return $this->hasMany('Goodsproperty');
        }

    }