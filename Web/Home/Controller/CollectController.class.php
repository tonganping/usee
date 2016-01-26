<?php
namespace Home\Controller;
use Think\Controller;
class CollectController extends Controller {
    private $indexPageSize = 20;

    public function _initialize() {
        B('Home\Behavior\AuthCheck');
    }

    private function _checkUserSession() {
        $user_id=session('user_id');
        if(!$user_id) {
            $this->ajaxReturn('', 1, '登录失效');
        }

        return $user_id;
    }

    /**
     * 渠道账户信息列表页面.
     * 
     * @return void
    */
    public function accountList() {
        // 获取表单信息.
        $account = I('get.account','');
        
        // 筛选条件
        $condition = [];
        if ($account) {
            $condition['account'] = array('like', "%$account%");
        }

        $collectAccount = M('collect_account');
        $datas = $collectAccount->pager($condition, $this->indexPageSize, $pagerShow)->order(['id'=>'asc'])->select();
        foreach ($datas as &$data) {
            $data['create_time'] = !empty($data['create_time']) ? \Think\FormatTimeYMDHIS($data['create_time']) : '';
            $data['update_time'] = !empty($data['update_time']) ? \Think\FormatTimeYMDHIS($data['update_time']) : '';
        }

        $this->assign('account', $account);
        $this->assign('data_list', $datas);
        $this->assign('pager', $pagerShow);

        $this->display('accountList');
    }

    /**
     * 添加渠道账户信息页面.
     * 
     * @return void
    */
    public function accountAdd() {
        $this->display('accountAdd');
    }

    /**
     * 添加渠道账户信息.
     * 
     * @return json
    */
    public function accountAddSave() {
        // 获取表单信息.
        $account  = I('post.account','');
        $name     = I('post.name','');
        $password = I('post.password','');

        // 信息基本格式校验.
        if (!\Think\checkStringInScope($account, array("min" => 1, "max" => 50))) {
            $this->ajaxReturn(null, 1, '渠道号必须为字符串,长度1-50!');
        }
        if (!\Think\checkStringInScope($name, array("min" => 1, "max" => 100))) {
            $this->ajaxReturn(null, 1, '名称必须为字符串,长度1-100!');
        }
        if (!\Think\checkStringInScope($password, array("min" => 1, "max" => 64))) {
            $this->ajaxReturn(null, 1, '密码必须为字符串,长度1-64!');
        }
        
        // 渠道号重复校验
        $collectAuth = M('collect_account');
        $isExist = $collectAuth->where(array('account' => $account))->count();
        if ($isExist) {
            $this->ajaxReturn(null, 1, '重复的渠道号!');
        }


        // 添加数据
        $data = array(
                    'account'     => $account,
                    'password'    => $password,
                    'name'        => $name,
                    'create_time' => time(),
                    'update_time' => 0
        );
        $result = $collectAuth->add($data);
        // 返回结果
        $this->success('添加成功','Collect/accountList', true);
    }

    /**
     * 修改渠道账户信息页面.
     * 
     * @return void
    */
    public function accountEdit() {
        $id=I('get.id', 0);
        if($id) {
            $data=D('collect_account')->getById($id);
            $data['create_time']=\Think\FormatTimeYMDHIS($data['create_time']);
            $data['update_time']=\Think\FormatTimeYMDHIS($data['update_time']);
            $this->assign('data', $data);
        }

        $this->display('accountEdit');
    }

    /**
     * 修改渠道账户信息.
     * 
     * @return json
    */
    public function accountEditSave() {
        // 获取表单信息.
        $id       = I('post.id',0);
        $account  = I('post.account','');
        $name     = I('post.name','');
        $password = I('post.password','');

        // 信息基本格式校验.
        if (!\Think\checkIntInScope($id, array("min" => 1))) {
            $this->ajaxReturn(null, 1, '非法请求!');
        }
        if (!\Think\checkStringInScope($account, array("min" => 1, "max" => 50))) {
            $this->ajaxReturn(null, 1, '渠道号必须为字符串,长度1-50!');
        }
        if (!\Think\checkStringInScope($name, array("min" => 1, "max" => 100))) {
            $this->ajaxReturn(null, 1, '名称必须为字符串,长度1-100!');
        }
        if (!\Think\checkStringInScope($password, array("min" => 1, "max" => 64))) {
            $this->ajaxReturn(null, 1, '密码必须为字符串,长度1-64!');
        }
        
        // 渠道号重复校验
        $collectAccount = D('collect_account');
        $map['account'] = array('eq',$account);
        $map['id']      = array('neq',$id);
        $isExist        = $collectAccount->where($map)->count();
        if ($isExist) {
            $this->ajaxReturn(null, 1, '重复的渠道号!');
        }
        // 更新数据
        $data = array(
                    'account'     => $account,
                    'name'        => $name,
                    'password'    => $password,
                    'update_time' => time(),
        );
        $result = $collectAccount->where("id = $id")->save($data);
        // 返回结果
        $this->success('编辑成功','Collect/accountList',true);
    }

    /**
     * 删除渠道账户信息.
     * 
     * @return json
    */
    public function accountDel() {
        $id = I('get.id', 0);
        if (\Think\isEmpty($id)) {
            $this->ajaxReturn(null, 1, '#id 为空');
        }

        $result = D('collect_account')->delete($id);

        $this->success('删除成功','Collect/accountList',true);
    }

    /**
     * 采集端配置信息列表页面.
     * 
     * @return void
    */
    public function configList() {
        // 获取表单信息.
        $account = I('get.account','');
        
        // 筛选条件
        $condition = [];
        if ($account) {
            $condition['account'] = array('like', "%$account%");
        }

        $collectConfig = M('collect_config');
        $datas = $collectConfig->pager($condition, $this->indexPageSize, $pagerShow)->order(['id'=>'asc'])->select();
        foreach ($datas as &$data) {
            $data['create_time'] = !empty($data['create_time']) ? \Think\FormatTimeYMDHIS($data['create_time']) : '';
            $data['update_time'] = !empty($data['update_time']) ? \Think\FormatTimeYMDHIS($data['update_time']) : '';
        }

        $this->assign('account', $account);
        $this->assign('data_list', $datas);
        $this->assign('pager', $pagerShow);

        $this->display('configList');
    }

    /**
     * 添加采集端配置信息页面.
     * 
     * @return void
    */
    public function configAdd() {
        $this->display('configAdd');
    }

    /**
     * 添加采集端配置信息.
     * 
     * @return json
    */
    public function configAddSave() {
        // 获取表单信息.
        $account  = I('post.account','');
        $source   = I('post.source','');
        $target   = I('post.target','');
        $name     = I('post.name','');
        $args     = I('post.args','');

        // 信息基本格式校验.
        if (!\Think\checkStringInScope($account, array("min" => 1, "max" => 50))) {
            $this->ajaxReturn(null, 1, '渠道号必须为字符串,长度1-50!');
        }
        if (!\Think\checkStringInScope($source, array("min" => 1, "max" => 255))) {
            $this->ajaxReturn(null, 1, '源地址必须为字符串,长度1-255!');
        }
        if (!\Think\checkStringInScope($target, array("min" => 1, "max" => 255))) {
            $this->ajaxReturn(null, 1, '目标地址必须为字符串,长度1-255!');
        }
        if (!\Think\checkStringInScope($name, array("min" => 1, "max" => 100))) {
            $this->ajaxReturn(null, 1, '名称必须为字符串,长度1-100!');
        }
        if (!\Think\checkStringInScope($args, array("min" => 1, "max" => 255))) {
            $this->ajaxReturn(null, 1, '参数必须为字符串,长度1-255!');
        }
        
        // 渠道号重复校验.
        $collectAuth = M('collect_config');
        $isExist = $collectAuth->where(array('account' => $account))->count();
        if ($isExist) {
            $this->ajaxReturn(null, 1, '该渠道号配置已经存在!');
        }


        // 添加数据
        $data = array(
                    'account'     => $account,
                    'source'      => $source,
                    'target'      => $target,
                    'name'        => $name,
                    'args'        => $args,
                    'create_time' => time(),
                    'update_time' => 0
        );
        $result = $collectAuth->add($data);
        // 返回结果
        $this->success('添加成功','Collect/configList', true);
    }

    /**
     * 修改采集端配置信息页面.
     * 
     * @return void
    */
    public function configEdit() {
        $id = I('get.id', 0);
        if($id) {
            $data = D('collect_config')->getById($id);
            $data['create_time'] = \Think\FormatTimeYMDHIS($data['create_time']);
            $data['update_time'] = \Think\FormatTimeYMDHIS($data['update_time']);
            $this->assign('data', $data);
        }

        $this->display('configEdit');
    }

    /**
     * 修改采集端配置信息.
     * 
     * @return json
    */
    public function configEditSave() {
        // 获取表单信息.
        $id       = I('post.id',0);
        $account  = I('post.account','');
        $source   = I('post.source','');
        $target   = I('post.target','');
        $name     = I('post.name','');
        $args     = I('post.args','');

        // 信息基本格式校验.
        if (!\Think\checkIntInScope($id, array("min" => 1))) {
            $this->ajaxReturn(null, 1, '非法请求!');
        }
        if (!\Think\checkStringInScope($account, array("min" => 1, "max" => 50))) {
            $this->ajaxReturn(null, 1, '渠道号必须为字符串,长度1-50!');
        }
        if (!\Think\checkStringInScope($source, array("min" => 1, "max" => 255))) {
            $this->ajaxReturn(null, 1, '源地址必须为字符串,长度1-255!');
        }
        if (!\Think\checkStringInScope($target, array("min" => 1, "max" => 255))) {
            $this->ajaxReturn(null, 1, '目标地址必须为字符串,长度1-255!');
        }
        if (!\Think\checkStringInScope($name, array("min" => 1, "max" => 100))) {
            $this->ajaxReturn(null, 1, '名称必须为字符串,长度1-100!');
        }
        if (!\Think\checkStringInScope($args, array("min" => 1, "max" => 255))) {
            $this->ajaxReturn(null, 1, '参数必须为字符串,长度1-255!');
        }
        
        // 渠道号重复校验
        $collectConfig  = D('collect_config');
        $map['account'] = array('eq',$account);
        $map['id']      = array('neq',$id);
        $isExist        = $collectConfig->where($map)->count();
        if ($isExist) {
            $this->ajaxReturn(null, 1, '已配置的渠道号!');
        }
        // 更新数据
        $data = array(
                    'account'     => $account,
                    'source'      => $source,
                    'target'      => $target,
                    'name'        => $name,
                    'args'        => $args,
                    'update_time' => time()
        );
        $result = $collectConfig->where("id = $id")->save($data);
        // 返回结果
        $this->success('编辑成功','Collect/configList',true);
    }

    /**
     * 删除采集端配置信息.
     * 
     * @return json
    */
    public function configDel() {
        $id = I('get.id', 0);
        if (\Think\isEmpty($id)) {
            $this->ajaxReturn(null, 1, '#id 为空');
        }

        $result = D('collect_config')->delete($id);

        $this->success('删除成功','Collect/configList',true);
    }    
}