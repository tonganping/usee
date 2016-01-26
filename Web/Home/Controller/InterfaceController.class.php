<?php
namespace Home\Controller;
use Think\Controller;
class InterfaceController extends Controller {

    public static $responseBody = array(
        'EXCEPTION'                         => array('errcode' => -2,    'errmsg' => 'system exception,please try again later'),
        'FAILED'                            => array('errcode' => -1,    'errmsg' => 'system busy,please try again later'),
        'SUCCESS'                           => array('errcode' => 0,     'errmsg' => 'success'),
        'CHANNELID_EMPTY'                   => array('errcode' => 10001, 'errmsg' => 'channelId empty'),
        'TIMESTAMP_EMPTY'                   => array('errcode' => 10002, 'errmsg' => 'timestamp empty'),
        'TOKEN_EMPTY'                       => array('errcode' => 10003, 'errmsg' => 'token empty'),
        'UNKOWN_CHANNELID'                  => array('errcode' => 10004, 'errmsg' => 'unknown channelId'),
        'INVALID_REQUEST'                   => array('errcode' => 10005, 'errmsg' => 'invalid request'),
    );

    /**
     * 获取渠道配置信息接口.
     * 
     * @return json
    */
    public function getChannelConfig() {        
        // 获取请求参数.
        $channelId = I('get.channelId','');
        $timestamp = I('get.ts','');
        $token     = I('get.token','');
         
        // 信息基本格式校验.
        if (\Think\isEmpty($channelId)) {
            \Think\genResponseJson(self::$responseBody['CHANNELID_EMPTY']);
        }
        if (\Think\isEmpty($timestamp)) {
            \Think\genResponseJson(self::$responseBody['TIMESTAMP_EMPTY']);
        }
        if (\Think\isEmpty($token)) {
            \Think\genResponseJson(self::$responseBody['TOKEN_EMPTY']);
        }

        // 获取渠道号密码.
        $collectAccount = D('collect_account');
        $map['account'] = $channelId;
        $password = $collectAccount->where($map)->getField('password');
        if (\Think\isEmpty($password)) {
            \Think\genResponseJson(self::$responseBody['UNKOWN_CHANNELID']);
        }
        
        // 校验token.
        $params = array('channelId' => $channelId, 'ts' => $timestamp);
        $result = \Think\CheckToken($params, $password, $token);
        if (!$result) {
            \Think\genResponseJson(self::$responseBody['INVALID_REQUEST']);
        }

        // 获取渠道配置
        $collectConfig = D('collect_config');
        $map['account'] = $channelId;
        $config = $collectConfig->where($map)->getField('source,target,name,args');

        // 返回配置信息
        \Think\genResponseJson(self::$responseBody['SUCCESS'], $config);
    }
}