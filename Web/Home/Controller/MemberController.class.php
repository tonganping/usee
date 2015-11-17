<?php
namespace Home\Controller;
use THINK\Controller;

class MemberController extends Controller{
	public function index(){
        if(!cookie('user_id')){
            $this->redirect('Member/login');
        }

        $user_id=cookie('user_id');
        $user=D('user')->find($user_id);
		if(empty($user)){
			$this->redirect('Member/reg');
		}
                
       $restTime = D('conf')->find(array('key'=>'rest_time'));
        if (!empty($restTime['val'])) {
            $restTimes = json_decode($restTime['val'],true);
            $startHRestTime = strtotime($restTimes['start_time']);
            $endHRestTime = strtotime($restTimes['end_time']);
            $now = time();
            if ($now >= $startHRestTime && $now <= $endHRestTime) {
                redirect("/Public/p/rest.png");
            }
        }
                
        $this->getShowInfo($user);
		$this->display();
	}

	public function login(){
		$this->display();
	}

    public function logout() {
        cookie('user_id', null);
        cookie('user_name', null);

        $this->redirect('Member/login');
    }

	public function check() {
        $name=trim(I('post.name', ''));
        $pass=trim(I('post.pass', ''));

        if($name==='' || $pass==='') {
            $this->ajaxReturn(['data'=>'','code'=>1,'msg'=>'请输入手机号（或姓名）和密码']);
        }

        $pass=\Think\genPassword($pass);

        $cond=['password'=>$pass];
        $map=[
            'name' =>$name,
            'cell_phone'  =>$name,
            '_logic'    =>'or',
        ];
        $cond['_complex'] = $map;
        $user=D('user')->where($cond)->find();

        \Think\LOGFILE('LastSql', D('user')->getLastSql(), 'result', $user);

        if($user) {
            cookie('user_id', $user['id'], 1800);
            cookie('user_name', $user['name']);

            $this->ajaxReturn(['data'=>'','code'=>0,'msg'=>'ok']);
        } else {
            $this->ajaxReturn(['data'=>'','code'=>1,'msg'=>'用户名与密码不匹配']);
        }
	}

	public function reg(){
		$Relation=C('USER_RELATIONSHIP');
		$this->assign('class_list',D('class')->GetList());
		$this->assign('relation',$Relation);
		$this->display();
	}

	public function regSave(){
        $cellPhone=I('post.cell_phone');
        $name=I('post.name');
        $babyName=I('post.baby_name');
        $relation=I('post.relation_type');
        $classId=I('post.class_id');
        $pass1=I('post.password');
        $pass2=I('post.password2');

        if(empty($cellPhone) || empty($name) || empty($babyName) || empty($relation) || empty($classId) || empty($pass1) || empty($pass2)){
            $this->ajaxReturn(['data'=>'','code'=>2,'msg'=>'请将数据填写完整！']);
        }
        if(strlen($cellPhone)!=11 || !preg_match('/1[34578]{1}\d{9}$/', $cellPhone)){
            $this->ajaxReturn(['data'=>'','code'=>2,'msg'=>'请填写正确格式的手机号码！']);
        }

        if($pass1 != $pass2) {
            $this->ajaxReturn(['data'=>'','code'=>2,'msg'=>'两次密码不一致！']);
        }

        $dao=D('User');
        $data=$dao->create();
        $data['password']=\Think\genPassword($data['password']);
        $insertId=$dao->add($data);

        if($insertId){
            cookie('user_id', $insertId, 1800);
            cookie('user_name', $name);

        	$this->ajaxReturn(['data'=>'','code'=>0,'msg'=>'注册成功，请耐心等待老师审核！']);
        }else{
        	$this->ajaxReturn(['data'=>'','code'=>1,'msg'=>'注册失败！']);
        }
    }

    private function getShowInfo($user){
        $class=array();
        switch(intval($user['type'])){
            case 0:
                $imgResource=D('camera')->where(['name'=>['like','幼儿园%'], 'type'=>2])->select();
                $camResource=D('camera')->where(['name'=>['like','幼儿园%'], 'type'=>1])->select();
                $title='幼儿园照片与实时视频';
                break;
            case 1:
                $imgResource=D('camera')->where(['name'=>['like','操场%'], 'type'=>2])->select();
                $camResource=D('camera')->where(['name'=>['like','操场%'], 'type'=>1])->select();
                $title='操场照片与实时视频';
                break;
            default:
                $class=D('class')->find(intval($user['class_id']));
                $imgResource=D('camera')->where(array(
                        'class_id'=>intval($class['id']),
                        'type'=>2
                    )
                )->select();

                $camResource=D('camera')->where(
                    array(
                        'class_id'=>intval($class['id']),
                        'type'=>1
                    )
                )->select();
                $title=$class['name'];
                break;
        }

        $this->assign('imgResource',$imgResource);
        $this->assign('camResource',$camResource);
        $this->assign('class_name', $title);
    }

}