<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\service\order\OrderService;
use common\service\pay\weixin\NativePay;
use common\service\pay\weixin\PayNotifyCallBack;

use common\models\order\Order;
/**
 * Site controller
 */
class PayController extends BaseController
{	
	private $weixinNotify = '';
	/**
	* @desc 支付页面
	*/
	public function actionIndex()
	{
		$orderSn  = trim(Yii::$app->request->get('id'),'');
		if(!$orderSn)
		{
			return $this->redirect('/');
		}
		$orderService = new OrderService();
		$order = $orderService->getOrderByOrdersn($orderSn);
		if(!$order)
		{
			return $this->redirect('/');
		}
		return $this->render('index',['order' => $order]);
	}
	
	
    /**
    * @desc 发起微信支付
    */
    public function actionStartweixin()
    {	
    	$orderSn  = trim(Yii::$app->request->get('id'),'');
    	if(!$orderSn)
    	{
    		return $this->redirect('/');
    	}
    	$orderService = new OrderService();
    	$order = $orderService->getOrderByOrdersn($orderSn);
    	if(!$order)
    	{
    		return $this->redirect('/');
    	}
    	if($order['order_status'] !='1')
    	{
    		return $this->redirect('/');//已经支付
    	}
    	$orderGoods = $orderService->getOrderGoodsByOrderId($order['id']);
    	/**
    	* 流程：
    	* 1、组装包含支付信息的url，生成二维码
    	* 2、用户扫描二维码，进行支付
    	* 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
    	* 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
    	* 5、支付完成之后，微信服务器会通知支付成功
    	* 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
    	*/
    	$notify = new NativePay();
    	 
    	//模式二
    	/**
    	* 流程：
    	* 1、调用统一下单，取得code_url，生成二维码
    	* 2、用户扫描二维码，进行支付
    	* 3、支付完成之后，微信服务器会通知支付成功
    	* 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
    	*/
    	$input = new \WxPayUnifiedOrder();
    	$input->SetBody($orderGoods['goods_name']);
    	$input->SetAttach($orderGoods['goods_name']);
    	$input->SetGoods_tag($orderGoods['goods_name']);
    	$input->SetOut_trade_no($orderSn);
    	
    	$orderAmount = $order['order_amount'] * 100;
    	$input->SetTotal_fee($orderAmount);
    	
    	$url = Yii::$app->params['weixin.notify'];
    	$input->SetNotify_url($url);

    	$input->SetTime_start(date("YmdHis"));
    	$input->SetTime_expire(date("YmdHis", time() + 600));
    	$input->SetTrade_type("NATIVE");
    	$input->SetProduct_id($orderGoods['goods_id']);
    	$result = $notify->GetPayUrl($input);
		if($result['return_code'] == 'FAIL')
		{	
			echo $result['return_msg'];exit;
		}
		if($result['result_code'] == 'FAIL')
		{
			echo $result['err_code_des'];exit;
		}
    	$url = $result["code_url"];
    	$url = urlencode($url);
    	return $this->render('weixin',['url'=>$url,'orderAmount' =>$order['order_amount']]);
    }
    
    
    /**
    * @desc 微信支付生成二维码
    * @param
    */
    public function actionQrcode()
    {	
    	ob_clean();
    	require yii::getAlias('@common').'/service/pay/weixin/phpqrcode/phpqrcode.php';
    	$url = urldecode($_GET["data"]);
    	\QRcode::png($url , $outfile = false, $level = QR_ECLEVEL_L, $size = 6, $margin = 2, $saveandprint=false );
		exit();
    }
    
    /**
    * @desc 微信异步回调
    */
    public function actionWeixin()
    {
    	$notify = new PayNotifyCallBack();
    	$result = $notify->Handle(false);
    	$xml = file_get_contents('php://input');
    	file_put_contents("log.txt", var_export($xml,1)."\n",FILE_APPEND);
    	 
    	//验证签名成功
    	if($result)
    	{
	    	file_put_contents("log.txt", var_export("ok",1)."\n",FILE_APPEND);
    		$xml = file_get_contents('php://input');
    		try {
    			$result = \WxPayResults::Init($xml);
    			file_put_contents("log.txt", var_export($result,1),FILE_APPEND);
    		} catch (WxPayException $e){
    			$msg = $e->errorMessage();
    			$notify->setNofity('FAIL',$msg); return;
    		}
    		file_put_contents("log.txt", var_export($result,1),FILE_APPEND);
    	}else
    	{	
    		file_put_contents("log.txt", var_export("fail",1)."\n",FILE_APPEND);
    		echo "数据验证失败";
    	}
    }
    
    
    /**
     * @desc 微信异步回调
     */
    public function actionWeixinnotify()
    {
    	$notify = new PayNotifyCallBack();
    	$result = $notify->Handle(false);
    	$xml = file_get_contents('php://input');
    	file_put_contents("log.txt", var_export($xml,1)."\n",FILE_APPEND);
    
    	//验证签名成功
    	if($result)
    	{
    		file_put_contents("log.txt", var_export("ok",1)."\n",FILE_APPEND);
    		$xml = file_get_contents('php://input');
    		try {
    			$result = \WxPayResults::Init($xml);
    			file_put_contents("log.txt", var_export($result,1),FILE_APPEND);
    		} catch (WxPayException $e){
    			$msg = $e->errorMessage();
    			$notify->setNofity('FAIL',$msg); return;
    		}
    		file_put_contents("log.txt", var_export($result,1),FILE_APPEND);
    	}else
    	{
    		file_put_contents("log.txt", var_export("fail",1)."\n",FILE_APPEND);
    		echo "数据验证失败";
    	}
    }
    
}