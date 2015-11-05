<?php
namespace Home\Controller;
use Think\Controller;
class ClassController extends Controller {
    private $indexPageSize = 20;

    public function _initialize() {
        B('Home\Behavior\AuthCheck');
    }

    public function index() {
        $Task=M('class');

        // 筛选条件
        $condition=[];

        $data=$Task->pager($condition, $this->indexPageSize, $pagerShow)->order('`order` asc,id desc')->select();

        $this->assign('data_list', $data);
        $this->assign('pager', $pagerShow);

        $this->display('index');
    }

    public function edit() {
        $id=I('get.id', 0);
        if($id) {
            $data=D('class')->getById($id);
            $this->assign('data', $data);
        }
        $this->display('edit');
    }

    public function editSave() {
        $Task=D('class');

        $data=$Task->create();

        $data || $this->ajaxReturn($data, 1, $Task->getError());

        $data->order || $data->order=100;
        $Task->data($data);
        $result=$data['id']
            ? $Task->save()
            : $Task->add();

        $this->ajaxReturn($result);
    }

    public function del() {
        $id=I('get.id', 0);
        $id || $this->ajaxReturn(null, 1, '#id 为空');

        $result=D('class')->delete($id);

        $this->ajaxReturn(['data'=>$result, 'code'=>$result ? 0 : 1, 'msg'=>'']);
    }

}