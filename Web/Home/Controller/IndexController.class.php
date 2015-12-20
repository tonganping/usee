<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function Index() {
        if(!session('admin_id')) {
            $this->display('login');
            return false;
        }

        $this->redirect('/User/index/');
    }

    /**
     * 处理登录请求，成功后保存session和cookie
     */
    public function login() {
        $adminName=I('post.user');
        $adminCode=I('post.pass');
        if(!$adminName || !$adminCode) {
            $this->ajaxReturn(['data'=>'', 'code'=>1, 'msg'=>'用户名或密码为空']);
        }

        $Admin=M('admin');
        $Admin->getByName($adminName);

        // 检查用户是否存在
        if(!$Admin->id) {
            $this->ajaxReturn(['data'=>'', 'code'=>2, 'msg'=>'用户名与密码不匹配(2)']);
        }

        // 验证密码
        $userPassword=\strtolower($adminCode);
        if($userPassword!=$Admin->code) {
            $this->ajaxReturn(['data'=>'', 'code'=>3, 'msg'=>'用户名与密码不匹配(3)']);
        }

        // 处理登录session，及客户端cookie
        session(array('name'=>'session_id','expire'=>1800));
        session('admin_id', $Admin->id);
        session('admin_role', $Admin->role_id);
        session('admin_name', $Admin->name);
        session('admin_school_id', $Admin->school_id);

        (IS_AJAX || 1) && $this->ajaxReturn($Admin->id);

        return true;
    }

    public function logout() {
        session(null);
        cookie(null);

        $this->redirect('/Index/index');
    }

}