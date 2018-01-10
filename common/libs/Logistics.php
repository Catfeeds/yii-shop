<?php 
/**
 * @desc快递鸟即时查询物流
 */
namespace common\libs;
class Logistics
{

	
	public static function search($code, $invoice_no)
	{
		$config = Yii::$app->params['logistics'];
		$requestData = json_encode(['ShipperCode' => $code,'LogisticCode' => $invoice_no]);
		$datas = array(
				'EBusinessID' => $config['appid'],
				'RequestType' => '1002',
				'RequestData' => urlencode($requestData) ,
				'DataType' => '2'
		);
		$datas['DataSign'] = $this->encrypt($requestData, $config['appkey']);
	
		$return = $this->sendPost($config['search'], $datas);
		return json_decode($return,true);
	}	
	
	/**
	 * 电商Sign签名生成
	 * @param data 内容
	 * @param appkey Appkey
	 * @return DataSign签名
	 */
	private static function encrypt($data, $appkey) {
		return urlencode(base64_encode(md5($data.$appkey)));
	}
	
	

	/**
	 *  向快递鸟发送请求
	 * @param  string $url 请求Url
	 * @param  array $datas 提交的数据
	 * @return url响应返回的html
	 */
	private static function sendPost($url, $datas) {
		$temps = array();
		foreach ($datas as $key => $value) {
			$temps[] = sprintf('%s=%s', $key, $value);
		}
		$post_data = implode('&', $temps);
		$url_info = parse_url($url);
		if(empty($url_info['port']))
		{
			$url_info['port']=80;
		}
		$httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
		$httpheader.= "Host:" . $url_info['host'] . "\r\n";
		$httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
		$httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
		$httpheader.= "Connection:close\r\n\r\n";
		$httpheader.= $post_data;
		$fd = fsockopen($url_info['host'], $url_info['port']);
		fwrite($fd, $httpheader);
		$gets = "";
		$headerFlag = true;
		while (!feof($fd)) {
			if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
				break;
			}
		}
		while (!feof($fd)) {
			$gets.= fread($fd, 128);
		}
		fclose($fd);
	
		return $gets;
	}
	
}
?>