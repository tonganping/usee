<?php
/**
 * Created by PhpStorm.
 * User: very80
 * Date: 2015-08-03
 * Time: 15:14
 */
namespace Home\Model;
use Think\Model;

class UserModel extends Model {
	protected $_auto = array ( 
	    array('time_in','time',1,'function'), // 对time_in字段在新增的时候写入当前时间戳
		array('password','password2','确认密码不一致',2,'confirm')
	 );

}