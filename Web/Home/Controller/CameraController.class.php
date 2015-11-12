<?php
namespace Home\Controller;
use Think\Controller;
class CameraController extends Controller {
    private $indexPageSize = 20;
    public function _initialize() {
        B('Home\Behavior\AuthCheck');
    }

    public function index() {
        $Task=M('camera');

        // 筛选条件
        $condition=[];

        $data=$Task->pager($condition, $this->indexPageSize, $pagerShow)->order(['id'=>'desc'])->select();
        if($data) {
            $ClassList=D('class')->GetList('list');
            $Types=C('CAMERA_TYPES');
            foreach($data as &$d) {
                $d['time_in_text']=\Think\FormatTime($d['time_in']);
                $d['class_name']=$ClassList[$d['class_id']];
                $d['type_name']=$Types[$d['type']];
            }
        }

        $this->assign('data_list', $data);
        $this->assign('pager', $pagerShow);

        $this->display('index');
    }


    public function edit() {
        $id=I('get.id', 0);
        if($id) {
            $data=D('camera')->getById($id);
            $this->assign('data', $data);
        }

        // 班级
        $this->assign('class_list', D('class')->GetList());
        
        // 资源
        $this->assign('source_list', D('source')->GetList());

        $this->display('edit');
    }

    public function editSave() {
        $Task=D('camera');

        $data=$Task->create();

        $data || $this->ajaxReturn($data, 1, $Task->getError());

        $data['id'] || $data['time_in']=NOW;
        
        $sourceId=I('post.source_id', 0);
                
        $sourceInfo = D('source')->getById($sourceId);
        $data['url'] = $sourceInfo['url'];
        $data['type'] = $sourceInfo['type'];
        
        if (empty($data['id'])) {
            unset($data['id']);
            $Task->data($data);
            $result = $Task->add();
        } else {
            $Task->data($data);
            $result = $Task->save();
        }
        $this->ajaxReturn($result);
    }

    public function del() {
        $id=I('get.id', 0);
        $id || $this->ajaxReturn(null, 1, '#id 为空');

        $result=D('camera')->delete($id);

        $this->ajaxReturn(['data'=>$result, 'code'=>$result ? 0 : 1, 'msg'=>'']);
    }

}