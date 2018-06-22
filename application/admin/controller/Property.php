<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/22
 * Time: 18:54
 */

namespace app\admin\controller;

use think\Controller;

class Property extends Controller
{
    public function propertylist(){

        return $this->fetch();
    }
}