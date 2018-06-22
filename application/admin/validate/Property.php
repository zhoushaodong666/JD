<?php

namespace app\admin\validate;
use think\Validate;

class Property extends Validate
{
    protected $rule = [
                'property_name'  =>  'require|unique:property,property_name^property_pid',
                'property_pid'=>'require|gt:0'
    ];

    protected  $message = [
                'property_name.require'=>'属性名称不能为空',
                'property_name.unique'=>'属性名称不能重复',
                'property_pid.require'=>'所属分类不能为空',
                'property_pid.gt'=>'所属分类不能为空',

    ];

}
