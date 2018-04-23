<?php
namespace  common\service\order;
class LogisticsService
{	
	/**
	* @desc查询快递 
	* @param $code 快递公司代码   $invoiceNo 快递单号
	* @return
	*/
	public static function getInfo($code,$invoiceNo)
	{
		$typeCom = $_GET["com"];//快递公司
		$typeNu = $_GET["nu"];  //快递单号
		
		$AppKey = Yii::$app->params['kuaidi_100'];
		$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$code.'&nu='.$invoiceNo.'&show=2&muti=1&order=asc';
		
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt ($curl, CURLOPT_HEADER,0);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		curl_setopt ($curl, CURLOPT_TIMEOUT,5);
		$get_content = curl_exec($curl);
		curl_close ($curl);
		return $get_content;
	}
}