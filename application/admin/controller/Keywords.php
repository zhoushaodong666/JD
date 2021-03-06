<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/4
 * Time: 12:40
 */
namespace app\admin\controller;
use think\Controller;

    class Keywords extends Common
    {

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
            $post=request()->post();
            $validate=validate('Keywords');
            if (!$validate->check($post)){
                $this->error($validate->getError());
            }
            if (db('keywords')->insert($post)){
                $this->success('关键字添加成功','keywords/keywordslist');
            }else{
                $this->error('关键字添加失败','keywords/keywordslist');
            }

        }

        public function upd()
        {
            return $this->fetch();
        }

        public function updhanddle()
        {

        }
    }