<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/17
 * Time: 11:33
 *
 *  商品细节图的模型类
 */

namespace app\admin\model;
use think\Model;

class Img extends Model
{
    protected $resultSetType = 'collection';

    //商品细节图和商品的多对一关系
    public function goods()
    {
        return $this->belongsTo('Goods','img_pid');
    }


}