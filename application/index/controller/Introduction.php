<?php
namespace app\index\controller;

use think\Controller;

class Introduction extends Controller
{
    public function introduction()
    {
        return $this->fetch('introduction');
    }
}
