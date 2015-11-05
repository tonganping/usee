<?php
/**
 * Created by PhpStorm.
 * User: very80
 * Date: 2015-08-14
 * Time: 10:58
 */

namespace Home\Behavior;
use Think\Behavior;
class AuthCheckBehavior extends Behavior {
    // 行为扩展的执行入口必须是run
    public function run(&$return) {
        if(!session('admin_id')) {
            $return=false;
            redirect('/index.php', 5, '请登录...');
        } else {
            $return=true;
        }
    }
}
