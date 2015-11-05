<?php
/**
 * Created by PhpStorm.
 * User: very80
 * Date: 2015-08-03
 * Time: 15:14
 */
namespace Home\Model;
use Think\Model;

class AdminModel extends Model {

    public function GetIdByName($name) {
        return $this->where(['name'=>$name])->getField('id');
    }
}