<?php

namespace common\helpers;

use Yii;

/**
 * 自定义辅助函数，处理其他杂项
 */
class FuncHelper
{
    /**
     * ---------------------------------------
     * ajax标准返回格式
     * @param $code integer  错误码
     * @param $msg string  提示信息
     * @param $obj mixed  返回数据
     * @return void
     * ---------------------------------------
     */
    public static function ajaxReturn($code = 0, $msg = 'success', $obj = ''){
        /* api标准返回格式 */
        $json = array(
            'code' => $code,
            'msg'  => $msg,
            'obj'  => $obj,
        );
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($json));
    }
    
    /**
     * ---------------------------------------
     * 分析枚举类型字段值 格式 a:名称1,b:名称2
     * @param $string string  字符串
     * @return mixed
     * ---------------------------------------
     */
    public static function parse_field_attr($string) {
        if(0 === strpos($string,':')){
            // 采用函数定义
            return eval(substr($string,1).';');
        }
        $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
        if(strpos($string,':')){
            $value  =   array();
            foreach ($array as $val) {
                list($k, $v) = explode(':', $val);
                $value[$k]   = $v;
            }
        }else{
            $value  =   $array;
        }
        return $value;
    }

    /**
     * ---------------------------------------
     * 读出数据库后，经常将状态等数字转化为字符串
     * @param mixed $data  参数信息
     * @param array $map 要转化的数组信息
     * @return string
     * ---------------------------------------
     */
    public static function int_to_string($data, $map=array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿')) {
        if($data === false || $data === null ){
            return $data;
        }
        $data = (array)$data;
        if(isset($map[$data])){
            return $map[$data];
        }
        return '';
    }
    
    /**
     * ---------------------------------------
     * 上传base64格式的图片
     * @param string $imgbase64 图片的base64编码
     * @return mixed
     * ---------------------------------------
     */
    public static function uploadImage($imgbase64){
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $imgbase64, $result)){
            $type = $result[2];
            $type = $type == 'jpeg' ? 'jpg' : $type;
            $fileName = time() . rand( 1 , 1000 ) . ".".$type;
            /* 以年月日创建目录 */
            $dir = date('Ymd', time());
            if (!file_exists(Yii::$app->params['upload']['path'].$dir)) {
                mkdir(Yii::$app->params['upload']['path'].$dir, 0777,true);
            }
            $fileName = $dir.'/'.$fileName;
            if (file_put_contents(Yii::$app->params['upload']['path'].$fileName, base64_decode(str_replace($result[1], '', $imgbase64)))){
                //return Yii::$app->params['upload']['path'].$fileName;
                return $fileName;
            }
        }
        return false;
    }


    /**
     *---------------------------------------
     * 导出数据为excel表格
     * @param array $data 一个二维数组,结构如同从数据库查出来的数组
     * @param array $title excel的第一行标题,一个数组,如果为空则没有标题
     * @param string $filename 文件名
     *---------------------------------------
     */
    public static function exportexcel($data=array(),$title=array(),$filename='report'){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t", $data[$key]);

            }
            echo implode("\n",$data);
        }
    }
    
    
	public static function toStr($item)
	{	
		$returnData = [];
		foreach($item as $key=>$value)
		{	
			$_id = (string)$value['_id'];
			$returnData[$_id] = $value['name'];
		}
		return $returnData;
	}    
	
	
	public static function post($url, $keysArr, $flag = 0){
	
		$ch = curl_init();
		if(! $flag) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);
		curl_setopt($ch, CURLOPT_URL, $url);
		$ret = curl_exec($ch);
	
		curl_close($ch);
		return $ret;
	}
	
	
	public static function get($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	
	
	/**
	 * combineURL
	 * 拼接url
	 * @param string $baseURL   基于的url
	 * @param array  $keysArr   参数列表数组
	 * @return string           返回拼接的url
	 */
	public static function combineURL($baseURL,$keysArr){
		$combined = $baseURL."?";
		$valueArr = array();
	
		foreach($keysArr as $key => $val){
			$valueArr[] = "$key=$val";
		}
	
		$keyStr = implode("&",$valueArr);
		$combined .= ($keyStr);
	
		return $combined;
	}
}
