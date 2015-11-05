<?php
namespace Home\Controller;
use THINK\Controller;

class ShowController extends Controller{
	public function index(){
        if(!session('?openid')){
            $this->getWxInfo();
        }
        $openid=session('openid');
        $user=D('user')->where(array('open_id'=>$openid))->find();
        //$user=D('user')->find(23);
		if(empty($user)){
			$this->redirect('Show/regist/');
		}
		session(array('name'=>'session_id','expire'=>1800));
	    session('user_id', $user['id']);
	   	session('user_name', $user['name']);
        $this->getShowInfo($user);
		$this->display();
	}

	public function regist(){
		$Relation=C('USER_RELATIONSHIP');
		$this->assign('class_list',D('class')->GetList());
		$this->assign('relation',$Relation);
		$this->display();
	}

	public function saveRegist(){
        $cellPhone=I('post.cell_phone');
        $name=I('post.name');
        $babyName=I('post.baby_name');
        $relation=I('post.relation_type');
        $classId=I('post.class_id');
        if(empty($cellPhone)||empty($name)||empty($babyName)||empty($relation)||empty($classId)){
            $this->ajaxReturn(['data'=>'','code'=>2,'msg'=>'请将数据填写完整！']);
        }
        if(strlen($cellPhone)!=11 || !preg_match('/1[34578]{1}\d{9}$/', $cellPhone)){
            $this->ajaxReturn(['data'=>'','code'=>2,'msg'=>'请填写正确格式的手机号码！']);
        }

        $dao=D('User');
        $data=$dao->create();
        $data['open_id']=session('openid');
        $result=$dao->add($data);
        if($result){
        	session(array('name'=>'session_id','expire'=>1800));
            session('openid',session('openid'));
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

    public function getWxInfo(){
        $appid = C('APP_ID');  
        $secret = C('SECRET');  
        $code = $_GET["code"];  
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';

        $res=$this->getCurl($get_token_url);
        $json_obj = json_decode($res,true);  

        //根据openid和access_token查询用户信息  
        $access_token = $json_obj['access_token'];  
        $openid = $json_obj['openid'];  
        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';  
        $res=$this->getCurl($get_user_info_url);

        //解析json
        $user_obj = json_decode($res,true);
        if(empty($user_obj['openid'])){
           exit('请从微信客户端进入！');
        }
        session('openid',$user_obj['openid']);
    }

    public function getCurl($url){
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url);  
        curl_setopt($ch,CURLOPT_HEADER,0);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  
        $res = curl_exec($ch);  
        curl_close($ch);
        return $res;        
    }
}