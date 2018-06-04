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

        public function keywords()
        {
            return $this->belongsToMany('Keywords','jd_goods_keywords');
        }

        //商品和分类的多对一关系
        public  function cate()
        {
            return $this->belongsTo('Cate','goods_pid');
        }

    }