<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/1
 * Time: 16:24
 */

namespace app\admin\model;
use think\Model;
    class Cate extends Model
    {
        protected $resultSetType = 'collection';

        public function getChildrenId($cate_list, $pid = 0, $cate_level = 0)
        {
            static $arr = array();
            foreach ($cate_list as $key => $value) {
                if ($value['cate_pid'] == $pid) {
                    $value['str'] = str_repeat('—', $cate_level);
                    $arr[] = $value;
                    $this->getChildrenId($cate_list, $value['cate_id'], $cate_level + 1);
                }
            }
            return $arr;
        }

        //获取全部子级
        public function getChildren($cate_list, $pid = 0)
        {
            $arr = array();
                foreach ($cate_list as $key => $value) {
                    if ($value['cate_pid'] == $pid) {
                        $value['children'] = $this->getChildren($cate_list, $value['cate_id']);
                        $arr[] = $value;
                    }
                }
                return $arr;
            }



        //获取子级的全部父类
        public function getFatherId($cate_list, $pid = 0)
        {
           static $arr = array();
            foreach ($cate_list as $key => $value) {
                if ($value['cate_id'] == $pid) {
                    $this->getFatherId($cate_list, $value['cate_pid']);
                    $arr[] = $value;
                    }
                }
                return $arr;
        }

        //分类和商品的一对多关系
        public function goods()
        {
            return $this->hasMany('Goods');
        }

    }
