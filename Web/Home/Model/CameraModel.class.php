<?php
/**
 * Created by PhpStorm.
 * User: very80
 * Date: 2015-08-04
 * Time: 12:41
 */

namespace Home\Model;
use Think\Model;

class CameraModel extends Model {
    protected $_validate = array(
        array('name','require','名称必须！'),
        array('class_id','require','所属班级必须！'),
        array('url','require','网络地址必须！'),
        array('type','require','资源类型必须！'),
    );

}