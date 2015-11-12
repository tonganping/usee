<?php
/**
 * Created by PhpStorm.
 * User: very80
 * Date: 2015-08-04
 * Time: 12:41
 */

namespace Home\Model;
use Think\Model;

class SourceModel extends Model {
    protected $_validate = array(
        array('name','require','资源名称必须！'),
    );

    public function GetList($type='all') {
        $this->order('`time_in` desc');
        $data=$type=='all'
            ? $this->select()
            : $this->getField('id,name');

        return $data;
    }



}