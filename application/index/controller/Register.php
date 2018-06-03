<?php
namespace app\index\controller;

use think\Controller;

class Register extends Controller
{
    public function index()
    {
        return $this->fetch('register');
    }
}
