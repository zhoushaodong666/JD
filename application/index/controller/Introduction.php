<?php
namespace app\index\controller;

use think\Controller;

class Introduction extends Controller
{
    public function index()
    {
        return $this->fetch('introduction');
    }
}
