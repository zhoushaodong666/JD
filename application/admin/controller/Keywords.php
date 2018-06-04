<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/4
 * Time: 12:40
 */
namespace app\admin\controller;
use think\Controller;

    class Keywords extends Controller{

        public function keywordslist()
        {
            $keywords_select=db('keywords')->select();
            $this->assign('keywords_select',$keywords_select);
            return $this->fetch();
        }

        public function add()
        {
            return $this->fetch();
        }

        public function addhanddle()
        {
            return $this->fetch();
        }

        public function upd()
        {
            return $this->fetch();
        }

        public function updhanddle()
        {
            return $this->fetch();
        }
    }