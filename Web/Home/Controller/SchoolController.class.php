<?php
namespace Home\Controller;
use Think\Controller;
use Think;
class SchoolController extends Controller {
    private $indexPageSize = 20;

    public function _initialize() {
        B('Home\Behavior\AuthCheck');
    }

    public function index() {
        $Task=M('School');

        // 筛选条件
        $condition=[];
        $schoolInfos = $tmpSchoolInfos = Think\getSchoolByManager();
        
        if (count($tmpSchoolInfos) == 1) {

            $condition['school_id'] = Think\getSchoolIdByUser();
        }
        
        $data=$Task->pager($condition, $this->indexPageSize, $pagerShow)->order(['id'=>'desc'])->select();

//        if($data) {
//            $Relation=C('USER_RELATIONSHIP');
//            $Types=C('USER_TYPES');
//            $Classes=D('class')->GetList('list');
//
//            foreach($data as &$d) {
//                $d['time_in_text']=\Think\FormatTime($d['time_in']);
//                $d['relation']=$Relation[$d['relation_type']];
//                $d['type_name']=$Types[$d['type']];
//                $d['class_name']=$Classes[$d['class_id']];
//            }
//        }

        $this->assign('data_list', $data);
        $this->assign('pager', $pagerShow);

        $this->display('index');
    }

    private function _checkUserSession() {
        $user_id=session('user_id');
        if(!$user_id) {
            $this->ajaxReturn('', 1, '登录失效');
        }

        return $user_id;
    }


    public function edit() {
        $id=I('get.id', 0);
        if($id) {
            $data=D('school')->getById($id);
            //$data['time_in_text']=\Think\FormatTime($data['time_in']);
            $this->assign('data', $data);
        }  
        $this->display('edit');
    }

    public function editSave() {
        $Task=D('school');
        $data=$Task->create();

        $data || $this->ajaxReturn($data, 1, $Task->getError());

        $Task->data($data);
        $result=$data['id']
            ? $Task->save()
            : $Task->add();

        $this->ajaxReturn($result);
    }

    public function del() {
        $id=I('get.id', 0);
        $id || $this->ajaxReturn(null, 1, '#id 为空');

        $result=D('school')->delete($id);

        $this->ajaxReturn(['data'=>$result, 'code'=>$result ? 0 : 1, 'msg'=>'']);
    }
    
}