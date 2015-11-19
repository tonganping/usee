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
            $data['sourceIds'] = $data['source_id'];
            $this->assign('data', $data);
            
            $cameraData=D('camera_source_relation')->where(array('camera_id'=>$id))->select();
            $sourceIds = array();
            $classId   = null;
            foreach ($cameraData as $key => $value) {
                if(!in_array($value['source_id'], $sourceIds)) {
                    $sourceIds[] = $value['source_id'];
                }
                $classId = $value['class_id'];
            }
            
            
            $data['sourceIds'] = $sourceIds;
            $data['classId'] = $classId;
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
        
        $sourceIds = I('post.sourceIds', 0);
        $classId = $data['class_id'];
        $sourceIds || $this->ajaxReturn($data, 1, '无效的资源ID !');
        if (empty($data['id'])) {
            unset($data['id']);
            $Task->data($data);
            $cameraId = $Task->add();
            
            $relationTask = D('camera_source_relation');
            foreach ($sourceIds as $sourceId) {
                $relationTask->data(
                        array(
                            'camera_id' => $cameraId,
                            'source_id' => $sourceId,
                            'class_id'  => $classId,
                            'time_in'   => NOW
                        )
                );
                $relationTask->add();
            }
        } else {
            $Task->data($data);
            $Task->save();
            $cameraId = $data['id'];
            $relationTask = D('camera_source_relation');
            $relationTask->where(array('camera_id' => $cameraId))->delete();
            foreach ($sourceIds as $sourceId) {
                $relationTask->data(
                        array(
                            'camera_id' => $cameraId,
                            'source_id' => $sourceId,
                            'class_id'  => $classId,
                            'time_in'   => NOW
                        )
                );
                $relationTask->add();
            }   
        }
                
        $this->ajaxReturn(1);
    }

    public function del() {
        $id=I('get.id', 0);
        $id || $this->ajaxReturn(null, 1, '#id 为空');

        $result=D('camera')->delete($id);

        $this->ajaxReturn(['data'=>$result, 'code'=>$result ? 0 : 1, 'msg'=>'']);
    }

}