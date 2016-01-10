<?php
namespace Home\Controller;
use Think\Controller;
use THINK;
class AdminController extends Controller {
    private $indexPageSize = 20;

    public function _initialize() {
        B('Home\Behavior\AuthCheck');
    }

    public function index() {
        $Task=M('admin');

        // 筛选条件
        $condition=[];
        if ($_SESSION['admin_role'] !=1) {
                $condition['id'] = $_SESSION['admin_id']; 
        }
        $data=$Task->pager($condition, $this->indexPageSize, $pagerShow)->order(['id'=>'desc'])->select();

        if($data) {
 
            $Types=C('ROLE_TYPES');
  
            foreach($data as &$d) {
                $d['role_name']=$Types[$d['role_id']];
            }
        }
        $schoolInfos = Think\getSchoolByManager();
        $this->assign('schoolInfo', $schoolInfos);
        $this->assign('data_list', $data);
        $this->assign('pager', $pagerShow);

        $this->display('index');
    }

    public function add() {
        $schoolInfos = Think\getSchoolByManager();
        $this->assign('schoolInfo', $schoolInfos);
        $this->display('add');
    }

    public function addSave() {
        $Task=D('Admin');

        $data=$Task->create();
        $oldData=$Task->where(array("name"=>$data['name']))->find();
        
        $oldData && $this->ajaxReturn(null, 1, '已经存在该用户!');
        
        $data['code'] || $this->ajaxReturn(null, 1, '密码必填!');
        
        $data['role_id'] || $this->ajaxReturn(null, 1, '角色未选!');
        
        $data || $this->ajaxReturn($data, 1, $Task->getError());
        if ($data['role_id'] == 1) {
            $data['school_id'] = 0;
        }
        $data['code'] = sha1($data['code'].'_80_80_');
        $Task->data($data);
        $result=$data['id']
            ? $Task->save()
            : $Task->add();

        $this->ajaxReturn($result);
    }

    public function edit() {
        $id=I('get.id', 0);
        if($id) {
            $Types=C('ROLE_TYPES');
            $data=D('admin')->getById($id);
            $data['role_name']=$Types($data['role_id']);
            $this->assign('data', $data);
        }
        $this->display('edit');
    }

    public function editSave() {
        $Task=D('Admin');

        $data=$Task->create();
        $data || $this->ajaxReturn($data, 1, $Task->getError());
 
        $data['code'] = sha1($data['code'].'_80_80_');
        $Task->data($data);
        $result=$data['id']
            ? $Task->save()
            : $Task->add();

        $this->ajaxReturn($result);
    }

    public function del() {
        $id=I('get.id', 0);
        $id || $this->ajaxReturn(null, 1, '#id 为空');
        
        if ($_SESSION['admin_role'] != 1) {
             $this->ajaxReturn(null, 1, '无操作权限!');
        } 
        if ($id == 1) {
             $this->ajaxReturn(null, 1, '#无操作权限!');
        }
        
        if ($id == $_SESSION['admin_id']) {
             $this->ajaxReturn(null, 1, '#不能删除自己啊!');
        }
        
        $result=D('admin')->delete($id);

        $this->ajaxReturn(['data'=>$result, 'code'=>$result ? 0 : 1, 'msg'=>'']);
    }

    public function changepwd() {
        $id=I('get.id', 0);
        if($id) {
            $data=D('admin')->getById($id);
            $this->assign('data', $data);
        }
        $this->display('changepwd');
    }
    
    
    public function changeSave() {
        $id=I('post.id', 0);
        $id || $this->ajaxReturn(null, 1, '#id 为空');

        $pwd=I('post.oldpwd', 0);
        //$pwd || $this->ajaxReturn(null, 1, '#旧密码为空');
        
        $code=I('post.code', 0);
        $code || $this->ajaxReturn(null, 1, '#密码为空');
         
        $Task=D('admin');

        $data=$Task->getById($id);
        $data || $this->ajaxReturn($data, 1, $Task->getError());
        
        if ($_SESSION['admin_role'] != 1) {
            if ($data['code'] != sha1($pwd.'_80_80_')) {
                $this->ajaxReturn($data, 1, '旧密码不匹配!');
            }
        }
        $data['code'] = sha1($code.'_80_80_');
        $Task->data($data);
        $result=$data['id']
            ? $Task->save()
            : $Task->add();

        $this->ajaxReturn($result);
    }
    
}