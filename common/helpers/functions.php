<?php
/**
 * Created by PhpStorm.
 * User: grace
 * Date: 2017/12/7
 * Time: 21:44
 */

/**
 * Created by PhpStorm.
 * User: grace
 * Date: 2017\12\7 0007
 * Time: 10:34
 */

/**
 * 格式化输出
 *
 * @param unknown $data
 */
function p($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

if (!function_exists('url')) {
    function url($url)
    {
        return \yii\helpers\Url::to($url);
    }
}


function dd($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    die();
}

/**
 * @param $data
 * 把数据写到文件
 */
function file_log($data){
    file_put_contents("log.txt", var_export($data,1)."\n",FILE_APPEND);
}

/**
 * @param array $da
 * @param int $status
 * @param string $message
 * @param int $pages
 * @param array $parameter
 * 返回json字符串
 */
function appReturn($da = array(), $status = 10000, $message = '成功',$pages=1,$parameter=[])
{
    $data['message'] = $message;
    $data['status'] = $status;
    $data['pages'] = $pages;
    $data['par']=$parameter;
    $data['data'] = $da;

    header('Content-Type:application/json; charset=utf-8');
    echo(json_encode($data,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    die();
}


/**
 * @param $rs
 * 简单的返回成功或失败
 */
function myAppReturn($rs)
{
    $rs ? appReturn() : appReturn([], 10001, '失败');
}

/**
 * 生成四位随机字符串
 * by grace
 * @param int $length
 * @return string
 */
function generate_invite_code($length = 4)
{
    // 密码字符集，可任意添加你需要的字符
    //$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $chars = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $str .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $str;
}

/**
 * @param $data
 * @return array
 * 获取一维数组的key,转为数组
 */
function get_array_key($data)
{
    $arr = [];
    if (is_array($data)) {
        foreach ($data as $k => $v) {
            $arr[] = $k;
        }
    }
    return $arr;
}

/**
 * 删除文件
 *
 * @param string $aimUrl
 * @return boolean
 */
function unlinkFile($aimUrl)
{
    if (file_exists($aimUrl)) {
        unlink($aimUrl);
        return true;
    } else {
        return false;
    }
}

/**
 * @desc 根据两点间的经纬度计算距离
 * @param float $lat 纬度值
 * @param float $lng 经度值
 */
function getDistance($lat1, $lng1, $lat2, $lng2)
{
    $earthRadius = 6367000; //approximate radius of earth in meters

    /*
    Convert these degrees to radians
    to work with the formula
    */

    $lat1 = ($lat1 * pi() ) / 180;
    $lng1 = ($lng1 * pi() ) / 180;

    $lat2 = ($lat2 * pi() ) / 180;
    $lng2 = ($lng2 * pi() ) / 180;

    /*
    Using the
    Haversine formula

    http://en.wikipedia.org/wiki/Haversine_formula

    calculate the distance
    */

    $calcLongitude = $lng2 - $lng1;
    $calcLatitude = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;

    return round($calculatedDistance)/1000;
}