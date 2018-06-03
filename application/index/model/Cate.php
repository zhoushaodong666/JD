<?php
/**
 * Created by PhpStorm.
 * User: 11388
 * Date: 2018/6/2
 * Time: 10:27
 */

namespace app\index\model;
use think\Model;
class Cate extends Model{

    public function getChildren($cate_list,$pid=0)
    {
        $arr = array();
        if(is_array($cate_list)) {
            foreach ($cate_list as $key => $value) {
                if ($value['cate_pid'] == $pid) {
                    $value['children'] = $this->getChildren($cate_list,$value['cate_id']);
                    $arr[]=$value;
                }
            }
            return $arr;
        }

    }

}