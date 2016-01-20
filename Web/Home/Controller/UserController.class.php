<?php
namespace Home\Controller;
use Think\Controller;
use Think;
class UserController extends Controller {
    private $indexPageSize = 20;

    public function _initialize() {
        B('Home\Behavior\AuthCheck');
    }

    public function index() {
        $Task=M('user');

        // 筛选条件
        $condition='';
        $schoolInfos = $tmpSchoolInfos = Think\getSchoolByManager();
        
        if (count($tmpSchoolInfos) == 1) {

            $condition .= ' AND school_id =' .(Think\getSchoolIdByUser());
        }
        $pageSize = 20;
        $page = isset($_REQUEST['p']) ? max(1,$_REQUEST['p']) : 1;
        $skip = ($page - 1) * $pageSize;
        $model = new \Think\Model();
        $sql = "SELECT u.*,c.name as class_Name from tbl_user u,tbl_class  c where u.class_id = c.id {$condition} limit {$skip} ,{$pageSize}";
        $data = $model->query($sql);
        $sql2 = "SELECT count(*) as num from tbl_user u,tbl_class  c where u.class_id = c.id {$condition}";
        $data2 = $model->query($sql2);
        $Page = new \Think\Page($data2[0]['num'], 20);
        $Page->setConfig('prev', '');
        $Page->setConfig('next', '');
        $pagerShow=$Page->show();
        //var_dump($info,  $this->indexPageSize,$pagerShow);die;
        //$data=$Task->alias('u')->join('tbl_class c ON u.class_id=c.id')->pager($condition, $this->indexPageSize, $pagerShow)->order(['time_in'=>'desc'])->select();
        
        if($data) {
            $Relation=C('USER_RELATIONSHIP');
            $Types=C('USER_TYPES');
            $Classes=D('class')->GetList('list');

            foreach($data as &$d) {
                $d['time_in_text']=\Think\FormatTime($d['time_in']);
                $d['relation']=$Relation[$d['relation_type']];
                $d['type_name']=$Types[$d['type']];
              //  $d['class_name']=$Classes[$d['class_id']];
            }
        }

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
            $data=D('user')->getById($id);
            $data['time_in_text']=\Think\FormatTime($data['time_in']);
            $this->assign('data', $data);
        }

        // 班级
        $this->assign('class_list', D('class')->GetList());
        $this->assign('relation', C('USER_RELATIONSHIP'));

        $this->display('edit');
    }

    public function editSave() {
        $Task=D('user');
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

        $result=D('user')->delete($id);

        $this->ajaxReturn(['data'=>$result, 'code'=>$result ? 0 : 1, 'msg'=>'']);
    }
    
}