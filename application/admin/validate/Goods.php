<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/3
 * Time: 10:53
 */

namespace app\admin\validate;

use think\Validate;

class Goods extends Validate
{
    protected $rule = [
                'goods_name'  =>  'require|max:90',
                'goods_thumb' =>  'require',
                'goods_price' =>  'require|>:0|number',
                'goods_after_price' =>  'require|>:0|number',
                'goods_sales' =>  'require|>=:0|number',
                'goods_inventory'=>  'require|>=:0|number',
                'goods_pid'  =>  'require',
    ];

    protected  $message = [
                    'goods_name.require' => '商品名称不能为空',
                    'goods_name.max'     => '名称最多不能超过30个字符',
                    'goods_thumb.require'     => '商品缩略图不能为空',
                    'goods_price.require'     => '商品价格不能为空',
                    'goods_price.>'     => '商品价格必须大于0',
                    'goods_price.number'     => '商品价格必须是数字',
                    'goods_after_price.require'     => '促销价格不能为空',
                    'goods_after_price.>'     => '促销价格必须大于0',
                    'goods_after_price.number'     => '促销价格必须是数字',
                    'goods_sales.require'     => '商品销量不能为空',
                    'goods_sales.>='     => '商品销量必须大于等于0',
                    'goods_sales.number'     => '商品销量必须是数字',
                    'goods_inventory.require'     => '商品库存不能为空',
                    'goods_inventory.>='     => '商品库存必须大于等于0',
                    'goods_inventory.number'     => '商品库存必须是数字',
                    'goods_pid.require'  =>  '商品所属分类不能为空',
    ];

}
