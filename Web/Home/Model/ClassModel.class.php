<?php
/**
 * Created by PhpStorm.
 * User: very80
 * Date: 2015-08-04
 * Time: 12:41
 */

namespace Home\Model;
use Think\Model;

class ClassModel extends Model {
    protected $_validate = array(
        array('name','require','班级名称必须！'),
    );

    public function GetList($type='all') {
        $this->order('`order` asc')->where(" name <>'幼儿园' AND name<>'操场'");
        $data=$type=='all'
            ? $this->select()
            : $this->getField('id,name');

        return $data;
    }



}