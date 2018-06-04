<?php

namespace app\admin\validate;
use think\Validate;

class Keywords extends Validate
{
    protected $rule = [
                'keywords_name'  =>  'require|unique:Keywords',

    ];

    protected  $message = [
                'keywords_name.require'=>'关键字名称不能为空',
                'keywords_name.unique'=>'关键字名称不能重复',

    ];

}
