<?php
namespace Home\Controller;
use Think\Controller;
use THINK;
class SourceController extends Controller {
    private $indexPageSize = 20;

    public function _initialize() {
        B('Home\Behavior\AuthCheck');
    }

    public function index() {
        $Task=M('source');

        // 筛选条件
        $condition=[];
        $schoolInfos = $tmpSchoolInfos = Think\getSchoolByManager();
        
        if (count($tmpSchoolInfos) == 1) {

            $condition['school_id'] = Think\getSchoolIdByUser();
        }
        
        $data=$Task->pager($condition, $this->indexPageSize, $pagerShow)->order('id desc')->select();
        $Types=C('CAMERA_TYPES');
        foreach($data as &$d) {
            $d['time_in_text']=\Think\FormatTime($d['time_in']);
            $d['type_name']=$Types[$d['type']];
        }
            
        $this->assign('data_list', $data);
        $this->assign('pager', $pagerShow);

        $this->display('index');
    }

    public function add() {
        if(IS_POST) {
            $data=D('class')->getById($id);
            $this->assign('data', $data);
        }
        $schoolInfos = Think\getSchoolByManager();
        $this->assign('schoolInfo', $schoolInfos);
        $this->display('add');
    }
    
    public function edit() {
        $id=I('get.id', 0);
        if($id) {
            $data=D('source')->getById($id);
            $this->assign('data', $data);
        }
        $schoolInfos = Think\getSchoolByManager();
        $this->assign('schoolInfo', $schoolInfos);
        $this->display('edit');
    }

    public function editSave() {
        $Task=D('source');

        $data=$Task->create();

        $data || $this->ajaxReturn($data, 1, $Task->getError());
        $data['id'] || $data['time_in']=NOW;
        $Task->data($data);
        $result=$data['id']
            ? $Task->save()
            : $Task->add();

        $this->ajaxReturn($result);
    }

    public function del() {
        $id=I('get.id', 0);
        $id || $this->ajaxReturn(null, 1, '#id 为空');

        $result=D('source')->delete($id);

        $this->ajaxReturn(['data'=>$result, 'code'=>$result ? 0 : 1, 'msg'=>'']);
    }

}