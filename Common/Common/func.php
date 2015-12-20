<?php
/**
 * Created by PhpStorm.
 * User: very80
 * Date: 2015-07-31
 * Time: 11:28
 */
namespace Think;

function getSchoolByManager() {
    $schoolId = !empty($_SESSION['admin_school_id']) ? $_SESSION['admin_school_id'] : null;
    $schoolInfos = array();
    if (empty($schoolId)) {
        $schoolInfoArr = D('school')->select();
    } else {
        $schoolInfoArr = D('school')->where(array('id' => $schoolId))->select();
    }
    foreach ($schoolInfoArr as $key => $value) {
        $schoolInfos[$value['id']] = $value;
    }
    return $schoolInfos;
}

function getSchoolIdByUser() {
    $schoolId = !empty($_SESSION['admin_school_id']) ? $_SESSION['admin_school_id'] : null;
    return $schoolId;
}

function getSchoolByUser() {
    //var_dump($_SESSION['school_id']);
    $schoolInfos = array();
    $schoolInfoArr = D('school')->select();
    foreach ($schoolInfoArr as $key => $value) {
        $schoolInfos[$value['id']] = $value;
    }
    return $schoolInfos;
}



function udate($strFormat = 'u', $uTimeStamp = null)
{
    // If the time wasn't provided then fill it in
    if (is_null($uTimeStamp)) {
        $uTimeStamp = microtime(true);
    }

    // Round the time down to the second
    $dtTimeStamp = floor($uTimeStamp);

    // Determine the millisecond value
    $intMilliseconds = round(($uTimeStamp - $dtTimeStamp) * 1000000);
    // Format the milliseconds as a 6 character string
    $strMilliseconds = str_pad($intMilliseconds, 6, '0', STR_PAD_LEFT);

    // Replace the milliseconds in the date format string
    // Then use the date function to process the rest of the string
    return date(preg_replace('`(?<!\\\\)u`', $strMilliseconds, $strFormat), $dtTimeStamp);
}

function LOGFILE() {
    $file=$_SERVER['DOCUMENT_ROOT'].'/runtime.log';
    defined('RN') || define('RN', "\r\n");

    if(!is_file($file))
        return false;

    file_put_contents($file, udate('Y-m-d H:i:s.u T').RN, FILE_APPEND);

    $data=func_get_args();
    $content='';
    foreach($data as $d) {
        $content.=is_array($d) || is_object($d) || is_bool($d)
            ? json_encode($d)
            : $d;
        $content.=RN;
    }

    file_put_contents($file, $content.RN, FILE_APPEND);
}

/**
 * 获取加密密码
 * @param string $string 密码
 * @return string
 */
function genPassword($string){
    $en_pass = sha1($string.PASSWORD_SUFFIX);
    if(strlen($en_pass)>254){
        $en_pass = substr($en_pass, 0,254);
    }
    return $en_pass;
}

function arrayUrlEncode(&$data, $toReplace=array(), $toClear=array())
{
    if(is_array($data) && count($data)) {
        foreach($data as $k=>&$v) {
            if(is_array($v)) {
                arrayUrlEncode($v, $toReplace, $toClear);
            } elseif($v) {
                if(is_numeric($v) && $v<1 && $v>0 && $v{0}!='0') {
                    $v='0'.$v;
                }

                if(is_int($v) || is_float($v)) {

                } elseif(isset($v)) {
                    is_array($toReplace) && $v=strtr($v, $toReplace);
                    11!=strlen($v) && is_array($toClear) && $v=preg_replace($toClear, '', $v);

                    if(is_string($v)) {
                        $v = urlencode($v);
                    }
                }
            }
        }
    }

    return true;
}

/**
 * 格式化时间，并自动判断和隐藏 年、月日 部分
 *
 * @param int $t
 * @return bool|string
 */
function FormatTime($t=NOW) {
    if(!$t) {
        return '';
    }
    $format='';

    $_year_now=date('Y');
    $_date_now=date('md');

    $_year_then=date('Y');
    $_date_then=date('md', $t);

    if($_year_now != $_year_then) { // 不同年
        $format='Y-m-d ';
    } elseif($_date_now != $_date_then) {   // 同年，日期不同
        $format='m-d ';
    }

    $format.='H:i';

    return date($format, $t);
}
