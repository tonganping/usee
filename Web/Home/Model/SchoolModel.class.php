<?php
/**
 * Created by PhpStorm.
 * User: very80
 * Date: 2015-08-04
 * Time: 12:41
 */

namespace Home\Model;
use Think\Model;
use Think;
class SchoolModel extends Model {
    protected $_validate = array(
        array('name','require','班级名称必须！'),
    );

    public function GetList($type='all') {
        //$school_id = Think\getSchoolIdByUser();
        
        $this->order('`order` asc');
        $data=$type=='all'
            ? $this->select()
            : $this->getField('id,name');

        return $data;
    }



}