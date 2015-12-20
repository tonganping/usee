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
class ClassModel extends Model {
    protected $_validate = array(
        array('name','require','班级名称必须！'),
    );

    public function GetList($type='all') {
        $school_id = Think\getSchoolIdByUser();
        $where = " name <>'幼儿园' AND name<>'操场'";
        if (!empty($school_id)) {
            $where .= " AND school_id ={$school_id}";
        }
                        
        $this->order('`order` asc')->where($where);
        $data=$type=='all'
            ? $this->select()
            : $this->getField('id,name');

        return $data;
    }



}